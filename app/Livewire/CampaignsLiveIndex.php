<?php

namespace App\Livewire;
 
use Livewire\Component;
use Livewire\WithPagination;
 use Livewire\Attributes\On;
use Modules\Contacts\Models\Contact;
use Modules\Contacts\Models\Group;
use Modules\Wpbox\Models\Campaign;
use Modules\Wpbox\Models\CampaignType;
use Illuminate\Support\Facades\DB;
use Modules\Wpbox\Models\Message;
use App\Models\Company;

class CampaignsLiveIndex extends Component
{
    use WithPagination;

    public $name = '';
    public $type = null;
    public array $selectedCampaigns = [];
 
    public $groups = [];
    public $grupo_id = '';
    public $cron=0; // para saber si es automatico o no , si es 1 entonces se ejecuta en el cron 
 
    public $campaignTypes = [];
  
 
    public function toggleCron($id)
    {
        $campaign = \Modules\Wpbox\Models\Campaign::findOrFail($id);
        $campaign->cron = $campaign->cron == 1 ? 0 : 1;
        $campaign->save();
        $this->dispatch('notify', type: 'success', message: $campaign->cron == 1 ? 'Envío automático activado.' : 'Envío automático pausado.');
        // Forzar recarga de campañas
        $this->resetPage();
    }
 


    // esto solo se ejecuta una vez al cargar el componente
    // y no se vuelve a ejecutar al cambiar los filtros
    // por eso es ideal para cargar datos que no cambian
public function mount()
{
         
 // Última campaña creada diferente a las automaticas
    $lastCampaign = \Modules\Wpbox\Models\Campaign::where('is_simple', 0)
    ->latest()
    ->first();

    // Si existe, establece el tipo
    if ($lastCampaign) {
        $this->type = $lastCampaign->idtipocampaña;
    }


         $this->campaignTypes = CampaignType::orderBy('name')->pluck('name', 'id');
}


 public function render()
{
    $companyId = auth()->user()->company_id;
    $items = Campaign::query()
        ->leftJoin('wa_campaings_tipo as t', 't.id', '=', 'wa_campaings.idtipocampaña')
        ->with(['grupos' => fn ($q) => $q->withoutGlobalScopes(), 'type'])
        ->where('wa_campaings.company_id', $companyId)
        ->whereNull('contact_id')
        ->where(['is_bot' => false, 'is_api' => false])
        ->where('wa_campaings.is_simple', '!=', 1) // 👈 EXCLUIR is_simple=1
        ->when(strlen($this->name) > 1, fn ($q) => $q->where('wa_campaings.name', 'like', "%{$this->name}%"))
        ->when($this->type, fn ($q) => $q->where('wa_campaings.idtipocampaña', $this->type))
        ->orderBy('wa_campaings.created_at', 'desc')
        ->select('wa_campaings.*')
        ->paginate(10);
        
    $this->actualizarMensajesContestadosDeTodasLasCampañas($items);
    
    $allCampaigns = Campaign::query()
        ->where('is_simple', '!=', 1) // 👈 TAMBIÉN EXCLUIR AQUÍ
        ->when($this->type, fn ($q) => $q->where('idtipocampaña', $this->type))
        ->orderBy('name')
        ->get();
        
    //$this->groups = Group::withCount('contacts')->orderBy('name')->get();

        $this->groups = Group::withCount(['contacts' => function($query) {
            $query->where('phone', '!=', '0000000000');
        }])
        ->orderBy('name')
        ->get();

    
    return view('livewire.campaigns-live-index', [
        'setup' => [
            'title'          => __('crud.item_managment', ['item' => __('Campañas')]),
            'iscontent'      => true,
            'action_link'    => route('campaigns.create'),
            'action_name'    => __('Send new campaign') . ' 📢',
            'items'          => $items,
            'item_names'     => 'Campañas',
            'webroute_path'  => 'campaigns.',
            'fields'         => [],
            'custom_table'   => true,
            'parameter_name' => 'campaigns',
            'parameters'     => $this->name || $this->type,
            'allCampaigns'   => $allCampaigns,
        ],
    ]);
}


public function updatedType()
{
    $this->selectedCampaigns = []; // 👈 Limpia los checks al cambiar tipo

   

}




public function filterByName()
{
    // Solo para redibujar, ya que el render ya filtra por $name y $type
    // Si quisieras redireccionar, podrías usar redirect()->route(), pero no es necesario
}
 



public function exportMultiple()
{
    if (empty($this->selectedCampaigns)) {
 
        $this->dispatch('notify', type: 'error', message: 'Selecciona al menos una campaña.');
        return;
    }

 
    return redirect()->route('campaigns.reportMulti', [
        'campaigns' => $this->selectedCampaigns
    ]);
   
}


#[On('eliminar-errores')]
public function borrarErrores($id)
{
       $campaignId = $id;
    DB::transaction(function () use ($campaignId) {
        DB::table('messages')
            ->where('campaign_id', $campaignId)
            ->where('is_campign_messages', 1)
            ->where('status', 5)
            ->update([
                'status'     => 0,
                'error'      => '',
                'updated_at' => now(),
                'mandado_at' => null,
            ]);

        DB::table('wa_campaings')
            ->where('id', $campaignId)
            ->update([
                'sended_to' => DB::raw('sended_to - con_error'),
                'con_error' => 0,
            ]);
    });
        $this->dispatch('notify', type: 'success', message: 'Errores borrados, mensajes restablecidos y contador ajustado');
 
}

#[On('eliminar-campaña')]
public function eliminarCampaña($id)
{
    $campaign = Campaign::findOrFail($id);
    $campaign->delete();

 
        $this->dispatch('notify', type: 'success', message: 'Campaña eliminada correctamente.');
            // Opcional: reiniciar paginación o datos
          //  $this->resetPage();
}
   


// Maneja el limite de mensajes por dia
//inserta a mas contactos a la campaña siempre y cuando no se haya enviado

public function continuarCampañaAgrega($id)
{
    if (!$this->grupo_id) {
        $this->dispatch('notify', type: 'error', message: 'Debes seleccionar un grupo.');
        return;
    }

    $campaign = \Modules\Wpbox\Models\Campaign::findOrFail($id);
    $group = \Modules\Contacts\Models\Group::findOrFail($this->grupo_id);

    $template = \Modules\Wpbox\Models\Template::find($campaign->template_id);
    if ($template && $template->components) {
        $template->components = $this->normalizeComponentVariablesString($template->components);
    }

    $variablesValues = json_decode($campaign->variables, true);
    $variables_match = json_decode($campaign->variables_match, true);

    //$contacts = $group->contacts()->get();
    $contacts = $group->contacts()->where('phone', '!=', '0000000')->get();
    
    
    $messages = [];

    // 🔹 Mantener en memoria el último scheduled_at por company_id
    $lastScheduledTimes = [];


// PARA EL LIMITE
  
       $company=  Company::findOrFail(auth()->user()->company_id);
       $limitePorDia = $company?->getConfig('total_mensajes_dia', '200');      
 
// PARA EL LIMITE 
 

    foreach ($contacts as $contact) {
        $exists = \Modules\Wpbox\Models\Message::where('campaign_id', $campaign->id)
            ->where('contact_id', $contact->id)
            ->exists();

        if ($exists) {
            continue;
        }

        // === CONTROL DE LIMITE DIARIO ===
        $fechaEnvio = now()->startOfDay();

        while (true) {
            $quota = \Modules\Wpbox\Models\MessageDailyLimit::firstOrCreate(
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

            $fechaEnvio->addDay(); // pasa al siguiente día
        }

        $companyId = $contact->company_id;

        if (!array_key_exists($companyId, $lastScheduledTimes)) {
            $lastValue = DB::table('messages')
                ->where('company_id', $companyId)
                ->orderByDesc('scchuduled_at')
                ->value('scchuduled_at');

            $lastScheduledTimes[$companyId] = $lastValue ? \Carbon\Carbon::parse($lastValue) : null;
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
                    $sendTime = \Carbon\Carbon::parse($primerMensajeHoyValue);
                } else {
                    $sendTime = $lastForCompany->copy();
                }

                $sendTime->setDate($fechaEnvio->year, $fechaEnvio->month, $fechaEnvio->day);
            }
        } else {
            $sendTime = now();
            $sendTime->setDate($fechaEnvio->year, $fechaEnvio->month, $fechaEnvio->day);
        }

        $lastScheduledTimes[$companyId] = $sendTime->copy();
        $quota->increment('total_programados');

        $sendTimeForDb = $sendTime->format('Y-m-d H:i:s');

        // === COMPONENTES ===
        $content = $header_text = $header_image = $header_document = $header_video = $header_audio = $footer = "";
        $buttons = [];
        $APIComponents = [];
        $components = json_decode($template->components, true);

        foreach ($components as $component) {
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
                    $type => ['link' => $campaign->media_link]
                ]];
                ${"header_" . $type} = $campaign->media_link;
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
                        $buttonName = "";
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
            "created_at" => now(),
            "scchuduled_at" => $sendTimeForDb, // ✅ fecha calculada con control de límite
            "components" => json_encode($APIComponents),
            "campaign_id" => $campaign->id,
        ];
    }

    if (!empty($messages)) {
        \Modules\Wpbox\Models\Message::insert($messages);
    }

    $totalEnviados = \Modules\Wpbox\Models\Message::where('campaign_id', $campaign->id)
        ->where('is_campign_messages', true)
        ->count();
    $campaign->send_to = $totalEnviados;
    $campaign->save();

    \Modules\Wpbox\Models\CampaignDetalle::firstOrCreate([
        'campaign_id' => $campaign->id,
        'group_id' => $group->id,
    ]);

    $this->dispatch('notify', type: 'success', message: 'Mensajes creados a contactos nuevos.');
}






 
// Ya no se usa, la cambié por la funcion que 
// maneja el limite de mensajes por dia
//inserta a mas contactos a la campaña siempre y cuando no se haya enviado
public function continuarCampañaAgregaOLD($id)
{


 
        if (!$this->grupo_id) {
            $this->dispatch('notify', type: 'error', message: 'Debes seleccionar un grupo.');
            return;
        }
 

    // Ya tienes la campaña
    $campaign = \Modules\Wpbox\Models\Campaign::findOrFail($id);

    // Y el grupo seleccionado por Livewire
    $group = \Modules\Contacts\Models\Group::findOrFail($this->grupo_id);

    $template = \Modules\Wpbox\Models\Template::find($campaign->template_id);
    if ($template && $template->components) {
        $template->components = $this->normalizeComponentVariablesString($template->components);
    }

    $variablesValues = json_decode($campaign->variables, true);
    $variables_match = json_decode($campaign->variables_match, true);

// 2) Toma todos los contacts_id del grupo seleccionado
    $contacts = $group->contacts()->get();
    $messages = [];

   // 3) Inserta en la tabla de messages uno por uno, solo si no existe ya ese mensaje
    foreach ($contacts as $contact) {
        $exists = \Modules\Wpbox\Models\Message::where('campaign_id', $campaign->id)
            ->where('contact_id', $contact->id)
            ->exists();

        if ($exists) {
            continue;// Salta este contacto si ya tiene mensaje
        }

        $content = "";
        $header_text = "";
        $header_image = "";
        $header_document = "";
        $header_video = "";
        $header_audio = "";
        $footer = "";
        $buttons = [];
        $APIComponents = [];

        $components = json_decode($template->components, true);
        foreach ($components as $component) {
            $lowKey = strtolower($component['type']);

             $lowKey = strtolower($component['type']);

            if ($component['type'] == "HEADER" && $component['format'] == "TEXT") {
                $header_text = $component['text'];
                $component['parameters'] = [];
                if (isset($variables_match[$lowKey])) {
                    $this->setParameter($variables_match[$lowKey], $variablesValues[$lowKey], $component, $header_text, $contact);
                    unset($component['text'], $component['format'], $component['example']);
                    array_push($APIComponents, $component);
                }
            } else if ($component['type'] == "BODY") {
                $content = $component['text'];
                $component['parameters'] = [];
                if (isset($variables_match[$lowKey])) {
                    $this->setParameter($variables_match[$lowKey], $variablesValues[$lowKey], $component, $content, $contact);
                    unset($component['text'], $component['format'], $component['example']);
                    array_push($APIComponents, $component);
                }
            } else if ($component['type'] == "HEADER" && $component['format'] == "DOCUMENT") {
                $component['parameters'] = [[
                    "type" => "document",
                    "document" => ['link' => $campaign->media_link]
                ]];
                $header_document = $campaign->media_link;
                unset($component['format'], $component['example']);
                array_push($APIComponents, $component);
            } else if ($component['type'] == "HEADER" && $component['format'] == "IMAGE") {
                $component['parameters'] = [[
                    "type" => "image",
                    "image" => ['link' => $campaign->media_link]
                ]];
                $header_image = $campaign->media_link;
                unset($component['format'], $component['example']);
                array_push($APIComponents, $component);
            } else if ($component['type'] == "HEADER" && $component['format'] == "VIDEO") {
                $component['parameters'] = [[
                    "type" => "video",
                    "video" => ['link' => $campaign->media_link]
                ]];
                $header_video = $campaign->media_link;
                unset($component['format'], $component['example']);
                array_push($APIComponents, $component);
            } else if ($component['type'] == "HEADER" && $component['format'] == "AUDIO") {
                $component['parameters'] = [[
                    "type" => "audio",
                    "audio" => ['link' => $campaign->media_link]
                ]];
                $header_audio = $campaign->media_link;
                unset($component['format'], $component['example']);
                array_push($APIComponents, $component);
            } else if ($component['type'] == "FOOTER") {
                $footer = $component['text'];
            } else if ($component['type'] == "BUTTONS") {
                $keyButton = 0;
                foreach ($component['buttons'] as $keyButtonFromLoop => $valueButton) {
                    if (isset($variables_match[$lowKey][$keyButton]) && (($valueButton['type'] == "URL" && stripos($valueButton['url'], "{{") !== false) || ($valueButton['type'] == "COPY_CODE"))) {
                        $buttonName = "";
                        $button = [
                            "type" => "button",
                            "sub_type" => strtolower($valueButton['type']),
                            "index" => $keyButtonFromLoop . "",
                            "parameters" => []
                        ];
                        $paramType = $valueButton['type'] == "COPY_CODE" ? "coupon_code" : "text";
                        $this->setParameter($variables_match[$lowKey][$keyButton], $variablesValues[$lowKey][$keyButton], $button, $buttonName, $contact, $paramType);
                        array_push($APIComponents, $button);
                        array_push($buttons, $valueButton);
                        $keyButton++;
                    } else {
                        array_push($buttons, $valueButton);
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
            "created_at" => now(),
            "scchuduled_at" => now(),
            "components" => json_encode($components),
            "campaign_id" => $campaign->id,
        ];
    }

    if (!empty($messages)) {
        \Modules\Wpbox\Models\Message::insert($messages);
    }

    $totalEnviados = \Modules\Wpbox\Models\Message::where('campaign_id', $campaign->id)
        ->where('is_campign_messages', true)
        ->count();
    $campaign->send_to = $totalEnviados;
    $campaign->save();

    \Modules\Wpbox\Models\CampaignDetalle::firstOrCreate([
        'campaign_id' => $campaign->id,
        'group_id' => $group->id,
    ]);

    $this->dispatch('notify', type: 'success', message: 'Mensajes creados a contactos nuevos.');
 
}





// para que sirve la funcion de arriba  continuarCampañaAgrega
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
// para que sirve la funcion de arriba  continuarCampañaAgrega
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




// PONE STATUS A PENDIENTE A LOS MENSAJES QUE NO HAN CONTESTADO
public function continuarCampaña($id)
{
    $campaign = Campaign::findOrFail($id);

    // 1. Obtén los mensajes a modificar
    $mensajes = Message::where('campaign_id', $campaign->id)
        ->where('status', '<>', 6)
        ->get();

    // 2. Calcula los contadores a decrementar
    $delivered = $mensajes->whereIn('status', [2,3])->count(); // 2: MANDADO, 3: ENTREGADO
    $read = $mensajes->where('status', 4)->count(); // 4: LEIDO
    $error = $mensajes->where('status', 5)->count(); // 5: ERROR
    $total = $read + $error + $delivered;

    // 3. Resta los valores a la campaña
    $campaign->sended_to    = max(0, $campaign->sended_to - $total);
    $campaign->delivered_to = max(0, $campaign->delivered_to - $delivered);
    $campaign->read_by      = max(0, $campaign->read_by - $read);
    $campaign->save();

    // 4. Actualiza los mensajes
 
    Message::where('campaign_id', $campaign->id)
    ->where('status', '<>', 6)
    ->update([
        'status' => 0,
        'mandado_at' => null,       
    ]);

    // 5. Notifica con SweetAlert
    $this->dispatch('notify', type: 'success', message: 'Mensajes reiniciados. Ahora puedes enviarlos a los que no hay contestado');

    // 6. Opcional: forzar render
  //  $this->render(); // si es necesario que se actualicen los datos visibles
}



private function actualizarMensajesContestadosDeTodasLasCampañas($campañas)
{
 

    foreach ($campañas as $campaña) {
        $mensajesCampaña = Message::where('is_campign_messages', 1)
            ->where('campaign_id', $campaña->id)
            ->get();

        // foreach ($mensajesCampaña as $mensaje) {
        //     $respuesta = Message::where('contact_id', $mensaje->contact_id)
        //         ->where('is_campign_messages', 0)
        //         ->where('is_message_by_contact', 1)
        //         ->where('id', '>', $mensaje->id)
        //         ->exists();

        //     if ($respuesta) {
        //         $mensaje->status = 6;
        //         $mensaje->save();
        //     }
        // }

        // Opcional: guardar cuántos contestaron por campaña
        $campaña->contestado_por = Message::where('campaign_id', $campaña->id)
            ->where('status', 6)
            ->distinct('contact_id')
            ->count('contact_id');

        // Guardar cuantos están en cola (status = 1)
        $campaña->sending_to = Message::where('campaign_id', $campaña->id)
            ->where('status', 1)
            ->count();

        $campaña->save();
    }
}
}
