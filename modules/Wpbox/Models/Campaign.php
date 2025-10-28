<?php

namespace Modules\Wpbox\Models;

use App\Models\Company;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;
use Modules\Contacts\Models\Contact;
use Modules\Contacts\Models\Group;
use Modules\Wpbox\Models\MessageDailyLimit;
use Modules\Wpbox\Traits\Whatsapp;
use Illuminate\Support\Facades\DB;

class Campaign extends Model
{
    use Whatsapp;
    
    protected $table = 'wa_campaings';
    public $guarded = [];

 // 🔗 Relación: una campaña → pertenece a un tipo
    public function type()
    {
        return $this->belongsTo(CampaignType::class, 'idtipocampaña', 'id');
        //             ^ modelo padre         ^ foreign key en esta tabla  ^ owner key
    }


public function detalles()
{
    return $this->hasMany(CampaignDetalle::class, 'campaign_id');
}

public function grupos()
{
    return $this->belongsToMany(
        \Modules\Contacts\Models\Group::class, // Modelo relacionado
        'wa_campaigns_detalles',               // Tabla pivote
        'campaign_id',                         // Foreign key en pivote hacia Campaign
        'group_id'                             // Foreign key en pivote hacia Group
    );
}

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    public function messages()
    {
        return $this->hasMany(Message::class);
    }


    protected static function booted(){
        static::addGlobalScope(new CompanyScope);

        static::creating(function ($model){
           $company_id=session('company_id',null);
            if($company_id){
                $model->company_id=$company_id;
            }
        });
    }



public static function hasCitaCancela()
{
    return static::where('cita_cancela', 1)->exists();
}


public static function hasCitaOk()
{
    return static::where('cita_ok', 1)->exists();
}



public static function hasCitaAgenda()
{
    return static::where('cita_agenda', 1)->exists();
}

/**
 * Verifica si existe una campaña con cita_recuerda activo
 * @return bool
 */
public static function hasCitaRecuerda()
{
    return static::where('cita_recuerda', 1)->exists();
}





/**
 * Obtiene el ID de cita_agenda de forma segura (sin excepción)
 * @return int|null
 */
public static function getCitaCancelaIdSafe()
{
    $campaign = static::where('cita_cancela', 1)->first();
    return $campaign ? $campaign->id : null;
}



/**
 * Obtiene el ID de cita_agenda de forma segura (sin excepción)
 * @return int|null
 */
public static function getCitaOkIdSafe()
{
    $campaign = static::where('cita_ok', 1)->first();
    return $campaign ? $campaign->id : null;
}


/**
 * Obtiene el ID de cita_agenda de forma segura (sin excepción)
 * @return int|null
 */
public static function getCitaAgendaIdSafe()
{
    $campaign = static::where('cita_agenda', 1)->first();
    return $campaign ? $campaign->id : null;
}

/**
 * Obtiene el ID de cita_recuerda de forma segura (sin excepción)
 * @return int|null
 */
public static function getCitaRecuerdaIdSafe()
{
    $campaign = static::where('cita_recuerda', 1)->first();
    return $campaign ? $campaign->id : null;
}



    public function shouldWeUseIt($receivedMessage,Contact $contact){
       
             // Check if enabled_bot is false and return false if so
    if (!$contact->enabled_bot) {
        return false;
    }
       
        $receivedMessage = " " . strtolower($receivedMessage);
        $message = "";
        $sendThisCampaign=false;

        

        // Store the value of $this->trigger in a new variable
        $triggerValues = $this->trigger;

        // Convert $triggerValues into an array if it contains commas
        if (strpos($triggerValues, ',') !== false) {
            $triggerValues = explode(',', $triggerValues);
        }

        if (is_array($triggerValues)) {
            foreach ($triggerValues as $trigger) {
                if ($this->bot_type == 2) {
                    // Exact match
                    if ($receivedMessage == " " . $trigger) {
                        $sendThisCampaign=true;
                        break; // exit the loop once a match is found
                    }
                } else if ($this->bot_type == 3) {
                    // Contains
                    if (stripos($receivedMessage, $trigger) !== false) {
                        $sendThisCampaign=true;
                        break; // exit the loop once a match is found
                    }
                }
            }
        } else {
            //Doesn't contain commas
            if ($this->bot_type == 2) {
                // Exact match
                if ($receivedMessage == " " . $triggerValues) {
                    $sendThisCampaign=true;
                }
            } else if ($this->bot_type == 3) {
                // Contains
                if (stripos($receivedMessage, $triggerValues) !== false) {
                    $sendThisCampaign=true;
                }
            }
        }

    
        
        //Change message
        if($sendThisCampaign){
            $this->increment('used', 1);
            $this->update();

            $message=$this->makeMessages(null,$contact);
            $contact->sendMessage($contact->getCompany()->getConfig('delay_response',__('Give me a moment, I will have the answer shortly')), false);
            $this->sendCampaignMessageToWhatsApp($message);

            return true;
           
        }else{
            return false;
        }

        
    }

// funcion para contruir los mensajes de las campañas en la tabla de  messages
// tomando en cuenta los limites diarios
// y los horarios de envio

public function makeMessages($request, Contact $contact = null)
{
    if ($this->group_id == null && $this->contact_id == null && $contact == null) {
        $contacts = Contact::get();
    } elseif ($this->group_id != null) {
        $contacts = Group::findOrFail($this->group_id)->contacts()->get();
    } elseif ($this->contact_id != null) {
        $contacts = Contact::where('id', $this->contact_id)->get();
    } else {
        $contacts = collect([$contact]);
    }

    // 🔹 FILTRAR CONTACTOS CON TELÉFONO INVÁLIDO (0000000000)
    $contacts = $contacts->filter(function ($c) {
        return $c->phone && $c->phone !== '0000000000';
    })->values();

    // Si no quedan contactos válidos, salir sin hacer nada
    if ($contacts->isEmpty()) {
        return null;
    }

    $template = Template::where('id', $this->template_id)->first();
    if ($template && $template->components) {
        $template->components = $this->normalizeComponentVariablesString($template->components);
    }

    $variablesValues = json_decode($this->variables, true);
    $variables_match = json_decode($this->variables_match, true);
    $messages = [];

    // 🔹 Actualizar la cantidad de destinatarios válidos
    $this->send_to = $contacts->count();
    $this->update();

    // Parse send_time si se proporcionó
    $tzBasedDelivery = false;
    $systemRelatedDateTimeOfSend = null;

    if ($request != null && !$request->has('send_now') && $request->has('send_time') && $request->send_time != null) {
        $company = $this->company;
        config(['app.timezone' => $company->getConfig('time_zone', config('app.timezone'))]);
        $systemRelatedDateTimeOfSend = Carbon::parse($request->send_time)->tz(config('app.timezone'));
        $tzBasedDelivery = true;
    }

    // Mantener en memoria último scchuduled_at por company_id
    $lastScheduledTimes = [];




// PARA EL LIMITE
       $company = $this->company;
      
       $limitePorDia = $company?->getConfig('total_mensajes_dia', '200');      
        


// PARA EL LIMITE 




    foreach ($contacts as $key => $contact) {
        $content = $header_text = $header_image = $header_document = $header_video = $header_audio = $footer = "";
        $buttons = [];

        // === CONTROL DE LIMITE DIARIO ===
         

        $fechaEnvio = $tzBasedDelivery
            ? $systemRelatedDateTimeOfSend->copy()->startOfDay()
            : now()->startOfDay();

        while (true) {
            $quota = MessageDailyLimit::firstOrCreate(
                [
                    'company_id' => $contact->company_id,
                    'fecha' => $fechaEnvio->toDateString(),
                ],
                [
                    'total_programados' => 0,
                ]
            );

            if ($quota->total_programados < $limitePorDia) {
                break;
            }

            $fechaEnvio->addDay();
        }

        $companyId = $contact->company_id;

        if (!array_key_exists($companyId, $lastScheduledTimes)) {
            $lastValue = DB::table('messages')
                ->where('company_id', $companyId)
                ->orderByDesc('scchuduled_at')
                ->value('scchuduled_at');

            $lastScheduledTimes[$companyId] = $lastValue ? Carbon::parse($lastValue) : null;
        }

        $lastForCompany = $lastScheduledTimes[$companyId];

        if ($lastForCompany) {
            $ultimoDia = $lastForCompany->toDateString();
            $nuevoDia = $fechaEnvio->toDateString();

            if ($nuevoDia > $ultimoDia) {
                $sendTime = $lastForCompany->copy()->addHour();
                $sendTime->setDate($fechaEnvio->year, $fechaEnvio->month, $fechaEnvio->day);
            } else {
                $primerMensajeHoyValue = DB::table('messages')
                    ->where('company_id', $companyId)
                    ->whereDate('scchuduled_at', $ultimoDia)
                    ->orderBy('scchuduled_at', 'asc')
                    ->value('scchuduled_at');

                if ($primerMensajeHoyValue) {
                    $sendTime = Carbon::parse($primerMensajeHoyValue);
                } else {
                    $sendTime = $lastForCompany->copy();
                }

                $sendTime->setDate($fechaEnvio->year, $fechaEnvio->month, $fechaEnvio->day);
            }
        } else {
            $sendTime = $tzBasedDelivery
                ? $systemRelatedDateTimeOfSend->copy()
                : now();

            $sendTime->setDate($fechaEnvio->year, $fechaEnvio->month, $fechaEnvio->day);
        }

        $lastScheduledTimes[$companyId] = $sendTime->copy();

        $quota->increment('total_programados');

        if ($tzBasedDelivery) {
            try {
                $sendTimeForDb = Carbon::parse($sendTime->format('Y-m-d H:i:s'), $contact->country->timezone)
                    ->copy()
                    ->tz(config('app.timezone'))
                    ->format('Y-m-d H:i:s');
            } catch (\Throwable $th) {
                $sendTimeForDb = $sendTime->format('Y-m-d H:i:s');
            }
        } else {
            $sendTimeForDb = $sendTime->format('Y-m-d H:i:s');
        }

        // === COMPONENTES ===
        $components = json_decode($template->components, true);
        $APIComponents = [];
        foreach ($components as $keyComponent => $component) {
            $lowKey = strtolower($component['type']);

            if ($component['type'] == "HEADER" && $component['format'] == "TEXT") {
                $header_text = $component['text'];
                $component['parameters'] = [];
                if (isset($variables_match[$lowKey])) {
                    $this->setParameter($variables_match[$lowKey], $variablesValues[$lowKey], $component, $header_text, $contact);
                    unset($component['text'], $component['format'], $component['example']);
                    $APIComponents[] = $component;
                }
            } elseif ($component['type'] == "BODY") {
                $content = $component['text'];
                $component['parameters'] = [];
                if (isset($variables_match[$lowKey])) {
                    $this->setParameter($variables_match[$lowKey], $variablesValues[$lowKey], $component, $content, $contact);
                    unset($component['text'], $component['format'], $component['example']);
                    $APIComponents[] = $component;
                }
            } elseif ($component['type'] == "HEADER" && in_array($component['format'], ["DOCUMENT", "IMAGE", "VIDEO", "AUDIO"])) {
                $type = strtolower($component['format']);
                $component['parameters'] = [[
                    "type" => $type,
                    $type => ['link' => $this->media_link]
                ]];
                ${"header_" . $type} = $this->media_link;
                unset($component['format'], $component['example']);
                $APIComponents[] = $component;
            } elseif ($component['type'] == "FOOTER") {
                $footer = $component['text'];
            } elseif ($component['type'] == "BUTTONS") {
                $keyButton = 0;
                foreach ($component['buttons'] as $keyButtonFromLoop => $valueButton) {
                    if (isset($variables_match[$lowKey][$keyButton]) &&
                        (($valueButton['type'] == "URL" && stripos($valueButton['url'], "{{") !== false)
                            || ($valueButton['type'] == "COPY_CODE"))) {
                        $button = [
                            "type" => "button",
                            "sub_type" => strtolower($valueButton['type']),
                            "index" => "$keyButtonFromLoop",
                            "parameters" => []
                        ];
                        $paramType = $valueButton['type'] == "COPY_CODE" ? "coupon_code" : "text";
                        $this->setParameter($variables_match[$lowKey][$keyButton], $variablesValues[$lowKey][$keyButton], $button, $buttonName, $contact, $paramType);
                        $APIComponents[] = $button;
                        $buttons[] = $valueButton;
                        $keyButton++;
                    } else {
                        $buttons[] = $valueButton;
                    }
                }
            }
        }

        $components = $APIComponents;

        $messages[] = [
            "contact_id" => $contact->id,
            "company_id" => $contact->company_id,
            "value" => $content,
            "header_image" => $header_image,
            "header_video" => $header_video,
            "header_audio" => $header_audio,
            "header_document" => $header_document,
            "footer_text" => $footer,
            "buttons" => json_encode($buttons),
            "header_text" => $header_text,
            "is_message_by_contact" => false,
            "is_campign_messages" => true,
            "status" => 0,
            "created_at" => now()->format('Y-m-d H:i:s'),
            "scchuduled_at" => $sendTimeForDb,
            "components" => json_encode($components),
            "campaign_id" => $this->id,
        ];
    }

    if (!empty($messages)) {
        DB::table('messages')->insert($messages);
    }

    if ($contact != null) {
        return DB::table('messages')
            ->where('contact_id', $contact->id)
            ->where('campaign_id', $this->id)
            ->orderByDesc('id')
            ->first();
    }
}




    private function setParameter($variables,$values,&$component,&$content,$contact,$type="text"){
        foreach ($variables as $keyVM => $vm) { 
            $data=["type"=>$type];
            if($vm=="-2"){
                //Use static value
                $data[$type]=$values[$keyVM];
                array_push($component['parameters'],$data);
                $content=str_replace("{{".$keyVM."}}",$values[$keyVM],$content);
                
            }else if($vm=="-3"){
                //Contact extra value in runtime
                try {
                    $extraValueNeeded = $values[$keyVM]; // ex "order.id"
                    $extraValues = $contact->extra_value; //ex ["order"=>["id"=>1,"status"=>"pending"]]
                    $valueNeeded = null;

                    if (isset($extraValues)) {
                        $keys = explode('.', $extraValueNeeded);
                        $valueNeeded = $extraValues;
                        

                        foreach ($keys as $key) {
                            if (isset($valueNeeded[$key])) {
                                $valueNeeded = $valueNeeded[$key];
                            } else {
                                $valueNeeded = $values[$keyVM];
                                break;
                            }
                        }
                    }
                 

                    $data[$type] = $valueNeeded;
                    array_push($component['parameters'], $data);
                    $content = str_replace("{{" . $keyVM . "}}", $valueNeeded, $content);

                    
                } catch (\Throwable $th) {
                    //Use static value
                    $data[$type]=$values[$keyVM];
                    array_push($component['parameters'],$data);
                    $content=str_replace("{{".$keyVM."}}",$values[$keyVM]."---",$content);
                }
               
            }  else if($vm=="-1"){
                    // Expediente
                    $data[$type] = $contact->expediente;
                    array_push($component['parameters'], $data);
                    $content = str_replace("{{" . $keyVM . "}}", $contact->expediente, $content);

                }else if($vm=="0"){
                    // Contact name
                    $data[$type] = $contact->name;
                    array_push($component['parameters'], $data);
                    $content = str_replace("{{" . $keyVM . "}}", $contact->name, $content);

                }else if($vm=="1"){
                    // Contact phone
                    $data[$type] = $contact->phone;
                    array_push($component['parameters'], $data);
                    $content = str_replace("{{" . $keyVM . "}}", $contact->phone, $content);
                }
            
            
            
            else{
                //Use defined contact field
                if($contact->fields->where('id',$vm)->first()){
                    $val=$contact->fields->where('id',$vm)->first()->pivot->value;
                    $data[$type]=$val;
                    array_push($component['parameters'],$data);
                    $content=str_replace("{{".$keyVM."}}",$val,$content);
                }else{
                    $data[$type]="";
                    array_push($component['parameters'],$data);
                    $content=str_replace("{{".$keyVM."}}","",$content);
                }
            }
        }
    }
private function normalizeComponentVariablesString($componentsJson)
{
    $components = json_decode($componentsJson, true);
    foreach ($components as &$component) {
        if (isset($component['text'])) {
            // Si ya tiene variables numéricas, no hacer nada
            if (preg_match('/{{\s*\d+\s*}}/', $component['text'])) {
                continue;
            }
            // Reemplaza variables con nombre por numéricas
            preg_match_all('/{{\s*([\w]+)\s*}}/', $component['text'], $matches);
            if (!empty($matches[1])) {
                $replaceMap = [];
                foreach ($matches[1] as $idx => $name) {
                    $replaceMap['{{'.$name.'}}'] = '{{'.($idx+1).'}}';
                }
                $component['text'] = str_replace(array_keys($replaceMap), array_values($replaceMap), $component['text']);
            }
        }
    }
    return json_encode($components, JSON_UNESCAPED_UNICODE);
}
    
}
