<?php

namespace Modules\Wpbox\Http\Controllers;

use App\Models\Company;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Contacts\Models\Group;
use Modules\Contacts\Models\Contact;
use Modules\Contacts\Models\Field;
use Modules\Wpbox\Models\Campaign;
use Modules\Wpbox\Models\Message;
use Modules\Wpbox\Models\Template;
use Modules\Wpbox\Models\CampaignType;
use Modules\Wpbox\Traits\Whatsapp;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use App\Jobs\EnviarMensajeWhatsappJob;
use App\Models\Appointment;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
class CampaignsController extends Controller
{
    use Whatsapp;

    /**
     * Provide class.
     */
    private $provider = Campaign::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'campaigns.';

    /**
     * View path.
     */
    private $view_path = 'wpbox::campaigns.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'campaigns';

    /**
     * Title of this crud.
     */
    private $title = 'Campaña';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'Campañas';


   


public function index(Request $request)
{
    // ─────────────────────────────────────────────────────────────
    // 1️⃣  Tareas previas
    // ─────────────────────────────────────────────────────────────
    //$this->actualizarMensajesContestadosDeTodasLasCampañas(); ya se hace en el livewire
    $this->authChecker();

    $company   = $this->getCompany();
    $companyId = $company->id;




// PARA EL LIMITE

      
        $companyLabels = [
            'total_mensajes_dia' => $company?->getConfig('total_mensajes_dia', '200'),       
        ];


// PARA EL LIMITE 




    // 🛠️  Actualizar mensajes “atascados”
    DB::table('messages')
        ->where('company_id', $companyId)
        ->where('is_campign_messages', 1)          // ← mantiene typo original
        ->where(function ($q) {
            $q->where('status', 0)                 // pendientes
              ->orWhere(fn ($q2) => $q2
                    ->where('status', 5)
                    ->where('error', 'Spam Rate limit hit'));
        })
        ->update([
           
            'created_at' => now(),              
            'error'         => null,
        ]);

    // 🚦  Verificaciones de configuración
    if ($company->getConfig('whatsapp_webhook_verified', 'no') !== 'yes' ||
        $company->getConfig('whatsapp_settings_done',  'no') !== 'yes') {
        return redirect()->route('whatsapp.setup');
    }

 
      
    // ─────────────────────────────────────────────────────────────
    // 3️⃣  Log de acceso (si está logueado)
    // ─────────────────────────────────────────────────────────────
   // if (Auth::check()) {
    //    DB::table('logs')->insert([
    //        'user_id'    => Auth::id(),
    //        'ip_address' => $request->ip(),
   //         'actividad'  => 'visit_campaigns',
   //     ]);
   // }

   

// ─────────────────────────────────────────────────────────────
// 5️⃣  Reportes “Ayer” y “Hoy” por hora con campos distintos
// ─────────────────────────────────────────────────────────────
$ayer = now()->subDay()->startOfDay();
$hoy  = now()->startOfDay();

$mensajesPorHora = function ($fecha, $campoFecha) use ($companyId) {
    return DB::table('messages')
        ->selectRaw("HOUR($campoFecha) as hora, COUNT(*) as cantidad")
        ->whereDate($campoFecha, $fecha)
        ->where('company_id', $companyId)
        ->where('is_campign_messages', 1)
        ->whereNotIn('status', [0, 1, 5])
        ->groupBy(DB::raw("HOUR($campoFecha)"))
        ->orderBy('hora')
        ->pluck('cantidad', 'hora');
};

$tablaHorasAyer = $mensajesPorHora($ayer, 'created_at')->map(
    fn ($cantidad, $hora) => compact('hora', 'cantidad')
)->values();

$tablaHorasHoy = $mensajesPorHora($hoy, 'mandado_at')->map(
    fn ($cantidad, $hora) => compact('hora', 'cantidad')
)->values();

$totales = [
    'ayer'         => $tablaHorasAyer->sum('cantidad'),
    'hoy_mandados' => $tablaHorasHoy->sum('cantidad'),
];




 

    // ─────────────────────────────────────────────────────────────
    // 6️⃣  Render de la vista
    // ─────────────────────────────────────────────────────────────



    return view($this->view_path . 'index', [
       
        'setup' => [
            'title'          => __('crud.item_managment', ['item' => __($this->titlePlural)]),
            'iscontent'      => true,
            'action_link'    => route($this->webroute_path . 'create'),
            'action_name'    => __('Send new campaign') . ' 📢',
             
            'item_names'     => $this->titlePlural,
            'webroute_path'  => $this->webroute_path,
            'fields'         => [],
            'custom_table'   => true,
            'parameter_name' => $this->parameter_name,
            'parameters'     => $request->query->count() !== 0,
            
            // Reportes
            'tablaHorasAyer' => $tablaHorasAyer,
            'tablaHorasHoy'  => $tablaHorasHoy,
            'totales'        => $totales,
            'fecha_ayer'     => $ayer->toDateString(),
            'fecha_hoy'      => $hoy->toDateString(),
        ],
         'companyLabels'=> $companyLabels,
    ]);
}



private function actualizarMensajesContestadosDeTodasLasCampañas()
{
    $campañas = Campaign::all();

    foreach ($campañas as $campaña) {
        $mensajesCampaña = Message::where('is_campign_messages', 1)
            ->where('campaign_id', $campaña->id)
            ->get();

        foreach ($mensajesCampaña as $mensaje) {
            $respuesta = Message::where('contact_id', $mensaje->contact_id)
                ->where('is_campign_messages', 0)
                ->where('is_message_by_contact', 1)
                ->where('id', '>', $mensaje->id)
                ->exists();

            if ($respuesta) {
                $mensaje->status = 6;
                $mensaje->save();
            }
        }

        // Opcional: guardar cuántos contestaron por campaña
        $campaña->contestado_por = Message::where('campaign_id', $campaña->id)
            ->where('status', 6)
            ->distinct('contact_id')
            ->count('contact_id');

        $campaña->save();
    }
}



  public function show(Campaign $campaign)
{
    // Asegúrate de cargar la relación 'grupos'
        $campaign->load(['grupos' => function($q) {
        $q->withoutGlobalScopes();
        }]);

    //Get countries we have send to
    $contact_ids = $campaign->messages()->select(['contact_id'])->pluck('contact_id')->toArray();
    $countriesCount = DB::table('contacts')
        ->join('countries', 'contacts.country_id', '=', 'countries.id')
        ->selectRaw('count(contacts.id) as number_of_messages, country_id, countries.name, countries.lat, countries.lng')
        ->whereIn('contacts.id', $contact_ids)
        ->groupBy('contacts.country_id')
        ->get()->toArray();

    // Obtén todos los mensajes con el contacto relacionado
    $messages = $campaign->messages()->with('contact')->get()
        ->sortBy(function ($msg) {
            return $msg->contact->name ?? '';
        })->values();

    // Pagina manualmente el resultado ordenado
    $page = request('page', 1);
    $perPage = config('settings.paginate');
    $items = $messages->slice(($page - 1) * $perPage, $perPage)->all();

    $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
        $items,
        $messages->count(),
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    $dataToSend = [
        'total_contacts' => \Modules\Contacts\Models\Contact::count(),
        'item' => $campaign,
        'setup' => [
            'countriesCount' => $countriesCount,
            'title' => __('Campaign') . " " . $campaign->name,
            'action_link' => route($this->webroute_path . 'index'),
            'action_name' => "📢 " . __('Back'),
            'items' => $paginated,
            'item_names' => $this->titlePlural,
            'webroute_path' => $this->webroute_path,
            'fields' => [],
            'custom_table' => true,
            'parameter_name' => $this->parameter_name,
            'parameters' => count($_GET) != 0
        ]
    ];

    if ($campaign->is_bot) {
        $dataToSend['setup']['title'] = __('Bot') . " " . $campaign->name;
        $dataToSend['setup']['action_name'] = __('Back to bots') . " 🤖";
        $dataToSend['setup']['action_link'] = route('replies.index', ['type' => 'bot']);
    } else if ($campaign->is_api) {
        $dataToSend['setup']['title'] = __('API') . " " . $campaign->name;
        $dataToSend['setup']['action_name'] = __('Back to Api');
        $dataToSend['setup']['action_link'] = route('wpbox.api.index', ['type' => 'api']);
    } else {
        //Regular campaign
        //If there is at least 1 pending message, show action to pause campaign
        $pendingMessages = $campaign->messages()->where('status', 0)->count();
        if ($pendingMessages > 0 && $campaign->is_active) {
            $dataToSend['setup']['action_link2'] = route($this->webroute_path . 'pause', $campaign->id);
            $dataToSend['setup']['action_name2'] = "⏸️ " . __('Pausar Campaña');
        } else if ($pendingMessages > 0) {
            $dataToSend['setup']['action_link2'] = route($this->webroute_path . 'resume', $campaign->id);
            $dataToSend['setup']['action_name2'] = "▶️ " . __('Resume Campaña');
        }

        $dataToSend['setup']['action_link3'] = route($this->webroute_path . 'report', $campaign->id);
        $dataToSend['setup']['action_name3'] = "📊 " . __('Download report');
    }

    return view($this->view_path . 'show', $dataToSend);
}

    /**
     * Auth checker function for the crud.
     */
    private function authChecker()
    {
        $this->ownerAndStaffOnly();
    }


public function create(Request $request)
{
    // 1. Templates
    $templates = [];
    foreach (Template::where('status', 'APPROVED')->orderBy('name')->get() as $key => $template) {
        $templates[$template->id] = $template->name . " - " . $template->language;
    }
    if (sizeof($templates) == 0) {
        try {
            $this->loadTemplatesFromWhatsApp();
            foreach (Template::where('status', 'APPROVED')->orderBy('name')->get() as $key => $template) {
                $templates[$template->id] = $template->name . " - " . $template->language;
            }
        } catch (\Throwable $th) {}
    }
    if (sizeof($templates) == 0) {
        return redirect()->route('templates.index')->withStatus(__('por favor crea un template primero'));
    }

    // 2. Groups
    // $groups = Group::orderBy('name')->pluck('name', 'id');
    // $groups[0] = __("Send to all contacts");
        $groups = Group::withCount(['contacts as contacts_count' => function ($query) {
                $query->where('phone', '<>', '0000000000');
            }])
            ->orderBy('name')
            ->get()
            ->mapWithKeys(function ($group) {
                return [
                    $group->id => "{$group->name} ({$group->contacts_count})"
                ];
            })
            ->prepend(__('Mandar a todos los contactos'), 0);

    // Tipo de campaña
    $tipocampaña = CampaignType::orderBy('name')->pluck('name', 'id');


    // 3. Selected Template & Variables
    $selectedTemplate = null;
    $variables = null;
    if (isset($_GET['template_id'])) {
        $selectedTemplate = Template::where('id', $_GET['template_id'])->first();
        $variables = $this->componentToVariablesList($selectedTemplate);
    }

    // 4. API Campaign Maker
    $isApiCampaignMaker = $request->has('type') && $request->type === 'api';

 $isSimple = $request->has('type') && $request->type === 'simple'; 

    // 5. Contact Fields
    $contactFields = [];
    if ($isApiCampaignMaker) {
        $contactFields[-3] = __('Use API defined value');
    }

   
    $contactFields[-2] = __('Selecciona Campo');
    $contactFields[-1] = __('Expediente');
    $contactFields[0] = __('Nombre del Contacto');
    $contactFields[1] = __('Teléfono del Contacto');

// aqui se hace la seleccion si es isSimple=true o no
//si es true entonces se muestran los campos de la cita tambien despues de los del contacto
    if ($isSimple) {

        $company = auth()->user()->company ?? null;

                $companyLabels = [
                    'label_contact_name_full' => $company?->getConfig('label_contact_name_full', 'NOMBRE DEL PACIENTE'),
                    'label_contact_name_singular' => $company?->getConfig('label_contact_name_singular', 'PACIENTE'),
                    'label_contact_name_plural' => $company?->getConfig('label_contact_name_plural', 'PACIENTES'),
                    'label_responsable_name_full' => $company?->getConfig('label_responsable_name_full', 'NOMBRE DEL DOCTOR'),
                    'label_responsable_name_singular' => $company?->getConfig('label_responsable_name_singular', 'DOCTOR'),
                    'label_responsable_name_plural' => $company?->getConfig('label_responsable_name_plural', 'DOCTORES'),
                ];



        $contactFields[-7] = __('Codigo de Cita');
        $contactFields[-6] = Str::title($companyLabels['label_responsable_name_full']);
        $contactFields[-4] = __('Fecha de Cita');
        $contactFields[-5] = __('Hora de Cita');
    } 


    // los campos extras
  foreach (Field::pluck('name', 'id') as $key => $value) {
                $contactFields[$key] = $value;
   }
    // fin de lo nuevo

  


    // 6. Selected Contacts
    $selectedContacts = isset($_GET['group_id'])
        ? (
            $_GET['group_id'] . "" == "0"
                ? Contact::where('phone', '<>', '0000000000')->count()
                : Group::findOrFail($_GET['group_id'])
                    ->contacts()
                    ->where('phone', '<>', '0000000000')
                    ->count()
        )
        : "";

    // 7. Contacts
    $contacts = Contact::pluck('name', 'id');

    // 8. Selected Template Components
  $selectedTemplateComponents = $selectedTemplate
    ? $this->normalizeComponentVariables(json_decode($selectedTemplate->components, true))
    : null;

    // 9. isBot
    $isBot = $request->has('type') && $request->type === 'bot';

    // 10. isAPI
    $isAPI = $isApiCampaignMaker;


   

    // 11. Junta todo en un array
    $data = [
        'selectedContacts' => $selectedContacts,
        'selectedTemplate' => $selectedTemplate,
        'selectedTemplateComponents' => $selectedTemplateComponents,
        'contactFields' => $contactFields,
        'variables' => $variables,
        'groups' => $groups,
        'contacts' => $contacts,
        'templates' => $templates,
        'isBot' => $isBot,
        'isAPI' => $isAPI,
        'isSimple' => $isSimple, // Para campañas simples
        'tipocampaña' => $tipocampaña,
    ];

    // 12. Retorna la vista
    return view($this->view_path . 'create', $data);
}




// guarda la campaña
public function store(Request $request) {  
        //Create the campaign
// Asigna cada valor a una variable antes de crear el array
$name = $request->has('name') ? $request->name : "template_message_" . now();
$timestamp_for_delivery = $request->has('send_now') ? null : $request->send_time;
$variables = $request->has('paramvalues') ? json_encode($request->paramvalues) : "";
$variables_match = json_encode($request->parammatch);
$template_id = $request->template_id;
$group_id = ($request->group_id . "" == "0") ? null : $request->group_id;
$contact_id = $request->contact_id;
$total_contacts = Contact::count();
$tipocampaña = $request->has('tipo') ? $request->tipo : 1; // Default to 1 if not set
$isBot = $request->has('type') && $request->type === 'bot';
$isAPI = $request->has('type') && $request->type === 'api';
$isSimple = $request->has('type') && $request->type === 'simple'; // Para campañas citas

// Junta todo en un array
$data = [
    'name' => $name,
    'timestamp_for_delivery' => $timestamp_for_delivery,
    'variables' => $variables,
    'variables_match' => $variables_match,
    'template_id' => $template_id,
    'group_id' => $group_id,
    'contact_id' => $contact_id,
    'total_contacts' => $total_contacts,
    'idtipocampaña' => $tipocampaña,
    'is_bot' => $isBot,
    'is_api' => $isAPI,
    'is_simple' => $isSimple, // Para campañas citas
];

// Crea la campaña
$campaign = $this->provider::create($data);

// Ahora guarda los grupos en la tabla de detalles
$groupIds = is_array($request->group_id) ? $request->group_id : [$request->group_id];
foreach ($groupIds as $groupId) {
    if ($groupId && $groupId !== "0") {
        $exists = \Modules\Wpbox\Models\CampaignDetalle::where('campaign_id', $campaign->id)
            ->where('group_id', $groupId)
            ->exists();
        if (!$exists) {
            \Modules\Wpbox\Models\CampaignDetalle::create([
                'campaign_id' => $campaign->id,
                'group_id' => $groupId,
            ]);
        }
    }
}




        //Check if type is bot
        $isBot=$request->has('type') && $request->type === 'bot';
        if($isBot) {
            $campaign->is_bot = true;
            $campaign->bot_type= $request->reply_type;
            $campaign->trigger= $request->trigger;
            $campaign->save();
        }

        $isAPI=$request->has('type') && $request->type === 'api';
        if($isAPI) {
            $campaign->is_api = true;
            $campaign->save();
        }

// esta es para la citas de aviso y confirmacion
        $isSimple=$request->has('type') && $request->type === 'simple';
        if($isSimple) {
            $campaign->is_simple = true;
            $campaign->save();
        }



        if ($request->hasFile('pdf')) {
            $campaign->media_link = $this->saveDocument(
                "",
                $request->pdf,
            );
            $campaign->update();
        }
        if ($request->hasFile('imageupload')) {
            $campaign->media_link = $this->saveDocument(
                "",
                $request->imageupload,
            );
            $campaign->update();
        }

 
         if($isBot) {
            //Bot campaign
            return redirect()->route('replies.index',['type'=>'bot'])->withStatus(__('Se ha creado la respuesta con Plantilla.'));
         } else if($isAPI) {
            //API campaign
            return redirect()->route('wpbox.api.index',['type'=>'api'])->withStatus(__('You have created new API Campaigns.'));
         }else if($isSimple) {
            //Simple campaign
             return redirect()->route($this->webroute_path.'index')->withStatus(__('Mensaje Cita creado correctamente.'));
         }
         else{
            //Regular campaign
            //Make the actual messages
            $campaign->makeMessages($request);

            if($request->has('contact_id')){
                return redirect()->route('chat.index')->withStatus(__('Mensaje será mandado en breve.'));
            }else{
                return redirect()->route($this->webroute_path.'index')->withStatus(__('Campaña lista para ser mandada'));
            }
         }
        

       
    
    }


// EJECUTAR COLA PARA MANDAR MENSAJES PENDIENTES, SE EJECUTA DESDE EL CRON
//    */5 * * * * curl -s https://movil.alever.mx/ejecutar-cola
// ese cron se pone en el server
public function ejecutarCola()
{
    Artisan::call('queue:work --stop-when-empty');
    $output = Artisan::output();

    return "<pre>Cola procesada. Resultado:\n" . $output . "</pre>";
}


// FUNCION PARA MANDAR LOS MENSAJES POR WHATS APP QUE SEAN 0 Y SSCHUDLED_AT < NOW
// SE EJECUTA MANUALMENTE
//se pone en miniscula en el cron https://movil.alever.mx/webhook/wpbox/sendschuduledmessages
public function sendSchuduledMessages()
{
    $company = $this->getCompany();
    $tipoEnvio = $company->getConfig('tipo_envio_campaña', 'normal');

    $query = Message::where(function ($query) {
            $query->where('status', 0)
                  ->where('scchuduled_at', '<', Carbon::now());
        })
        ->orWhere(function ($query) {
            $query->where('status', 5)
                  ->where('error', 'like', '%Spam Rate limit hit%')
                  ->where('scchuduled_at', '<', Carbon::now());
        })
        ->whereIn('campaign_id', function ($query) {
            $query->select('id')
                  ->from('wa_campaings')
                  ->where('is_active', true);
        });

    // Limitar solo si es envío normal
    if ($tipoEnvio === 'normal') {
        $query->limit(50); // puedes ajustar si deseas otro valor
    }

    $messagesToBeSend = $query->get();

    $resultados = [];
    foreach ($messagesToBeSend as $index => $message) {

      // Actualizar estado y preparar resultado
        $message->status = 1;
        $message->created_at = now();
        $message->save();

        if ($tipoEnvio === 'normal') {
            $sendResult = $this->sendCampaignMessageToWhatsApp($message);// se mandan en automatico
        } else {
            Bus::dispatch(new EnviarMensajeWhatsappJob($message)); // se ponen en cola y se ejecutan por un cron en el server 
        }

  

        $contador = $index + 1;
        $textoEnvio = $tipoEnvio === 'normal' 
            ? 'mandado normal' 
            : 'puesto en Job para el cron';

        $resultados[] = "[$contador] Mensaje ID {$message->id} $textoEnvio.";
    }

    if (empty($resultados)) {
        $resultados[] = "No hay mensajes para procesar.";
    }

    return response()->make(
        "<h3>Resultados de mensajes procesados:</h3><ul><li>" .
        implode("</li><li>", $resultados) .
        "</li></ul>"
    );
}



//FUNCION IGUAL A LA DE ARRIBA PERO SOLO PARA LAS CONFIRMACIONES DE CITAS
//SE MANDA A LLAMAR CON UN CRON CADA 5 MINUTOS
//0 * * * * curl -s "https://movil.alever.mx/webhook/wpbox/sendschuduledmessagesConfirm" > /dev/null 2>&1
//

//Explicación:
//0 → el minuto exacto (en este caso, el minuto 0 de la hora).
//* en la segunda posición → todas las horas.
//Los otros * → todos los días, todos los meses, todos los días de la semana.
//⏰ Eso significa que se ejecutará una vez cada hora en punto (ej. 01:00, 02:00, 03:00, etc.).
// despues de esto debemos esperar el CRON que ejecuta el mandado de mensajes
public function sendSchuduledMessagesConfirm()
{
    
    $companies = Company::all(); // o mejor: solo las activas
    $resultados = [];

    foreach ($companies as $company) {
        $tipoEnvio = $company->getConfig('tipo_envio_campaña', 'normal');

                $query = Message::where('es_cita_confirma', 1)
                    ->where(function ($q) {
                        $q->where(function ($sub) {
                                $sub->where('status', 0)
                                    ->where('scchuduled_at', '<', Carbon::now());
                            })
                        ->orWhere(function ($sub) {
                                $sub->where('status', 5)
                                    ->where('error', 'like', '%Spam Rate limit hit%')
                                    ->where('scchuduled_at', '<', Carbon::now());
                            });
                    })
                    ->whereIn('campaign_id', function ($q) use ($company) {
                        $q->select('id')
                        ->from('wa_campaings')
                        ->where('is_active', true)
                        ->where('company_id', $company->id);
                    });




        if ($tipoEnvio === 'normal') {
            $query->limit(50);
        }

        $messagesToBeSend = $query->get();



        foreach ($messagesToBeSend as $index => $message) {


            $message->status = 1;
            $message->created_at = now();
            $message->save();


            if ($tipoEnvio === 'normal') {
                $this->sendCampaignMessageToWhatsApp($message);
            } else {
                Bus::dispatch(new EnviarMensajeWhatsappJob($message));
            }

           

            $contador = $index + 1;
            $textoEnvio = $tipoEnvio === 'normal' 
                ? 'mandado normal' 
                : 'puesto en Job para el cron';

            $resultados[] = "[Empresa {$company->id}] [$contador] Mensaje ID {$message->id} $textoEnvio.";
        }
    }

     if (empty($resultados)) {
         $resultados[] = "No hay mensajes para procesar.";
    }

    
     return response()->make(
       "<h3>Resultados de mensajes procesados:</h3><ul><li>" .
       implode("</li><li>", $resultados) .
       "</li></ul>"
     );
}





// FUNCION PARA MANDAR LOS MENSAJES POR WHATS APP QUE SEAN 0 Y SSCHUDLED_AT < NOW
public function sendSchuduledMessagesCita($id)
{
  
      $citaId = (int)$id;
   
            $message = Message::where('status', 0)
            ->where('cita_id', $citaId)
            ->where('es_cita_agenda', 1)
            ->first();

            $sendResult = $this->sendCampaignMessageToWhatsApp($message);// se mandan en automatico

        // Actualizar estado y preparar resultado
        $message->status = 1;
        $message->created_at = now();
        $message->mandado_at = now();
        $message->save();

 
}



// FUNCION PARA MANDAR EL MENSAJE DE CANCELACION DE CITAS 
 
public function sendSchuduledMessagesCitaCancelada($id)
{
  
      $citaId = (int)$id;
//VALIDACION
// primero revisamos que si tenga un mensaje mandado por whats
// de lo contrario no se manda el de cancelacion
        $cita = Appointment::where('id', $citaId)
            ->whereNotIn('whatscita_agenda', [7, 8])
            ->first();

        // Si no encuentra la cita, salir
        if (!$cita) {
            return; // o return false; o throw exception según tu necesidad
        }
// FIN DE LA VALIDACION



   
            $message = Message::where('status', 0)
            ->where('cita_id', $citaId)
            ->where('es_cita_cancela', 1)
            ->first();

            $sendResult = $this->sendCampaignMessageToWhatsApp($message);// se mandan en automatico

        // Actualizar estado y preparar resultado
        $message->status = 1;
        $message->created_at = now();
        $message->mandado_at = now();
        $message->save();

 
}


// FUNCION PARA MANDAR EL MENSAJE DE OK DE CITAS  DESPUES QUE EL USUARIO CONFIRME
 
public function sendSchuduledMessagesCitaOk($id)
{
  
      $citaId = (int)$id;
//VALIDACION
// primero revisamos que si tenga un mensaje mandado por whats
// de lo contrario no se manda el mensaje
        $cita = Appointment::where('id', $citaId)
            ->whereNotIn('whatscita_agenda', [7, 8])
            ->first();

        // Si no encuentra la cita, salir
        if (!$cita) {
            return; // o return false; o throw exception según tu necesidad
        }
// FIN DE LA VALIDACION



   
            $message = Message::where('status', 0)
            ->where('cita_id', $citaId)
            ->where('es_cita_ok', 1)
            ->first();

            $sendResult = $this->sendCampaignMessageToWhatsApp($message);// se mandan en automatico

        // Actualizar estado y preparar resultado
        $message->status = 1;
        $message->created_at = now();
        $message->mandado_at = now();
        $message->save();

 
}






    //Delete campaign, only if type is BOT
    public function destroy(Campaign $campaign){
        if($campaign->is_bot || $campaign->is_api){
            $campaign->delete();
            //Redirect based on campaign type
            if($campaign->is_api){
                return redirect()->route('wpbox.api.index',['type'=>'api'])->withStatus(__('API Campaign deleted'));
            }
            return redirect()->route('replies.index',['type'=>'bot'])->withStatus(__('Bot borrado'));
        }else{
            return redirect()->route($this->webroute_path.'index')->withStatus(__('You can only delete bot campaigns'));
        }
    }

    //Activate bot
    public function activateBot(Campaign $campaign){
        $campaign->is_bot_active=true;
        $campaign->save();
        return redirect()->route('replies.index',['type'=>'bot'])->withStatus(__('Bot activated'));
    }

    //Deactivate bot
    public function deactivateBot(Campaign $campaign){
        $campaign->is_bot_active=false;
        $campaign->save();
        return redirect()->route('replies.index',['type'=>'bot'])->withStatus(__('Bot deactivated'));
    }

    //Pause campaign
    public function pause(Campaign $campaign){
        $campaign->is_active=false;
        $campaign->save();
        return redirect()->route($this->webroute_path.'show',$campaign)->withStatus(__('Campaign paused'));
    }

    //Resume campaign
    public function resume(Campaign $campaign){
        $campaign->is_active=true;
        $campaign->save();
        return redirect()->route($this->webroute_path.'show',$campaign)->withStatus(__('Campaign resumed'));
    }






public function report(Campaign $campaign)
{

 // Registrar la descarga en la tabla sessions
    if (Auth::check()) {
        DB::table('logs')->insert([
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
            'actividad' => 'descarga_reporte_campaña_' . $campaign->name,
            
        ]);
    }


    $timestamp = now()->format('Y-m-d_H-i-s');
    $filename = "Reporte_Campaña_{$campaign->name}_{$timestamp}.xlsx";

        // 1️⃣ Encabezados base
        $headers = [
        'Campaña', 'Expediente','Nombre', 'Telefono', 'Status', 'Respuesta',
        'Observaciones', 'Mandado en', 'Error', 'Grupo'
    ];

        /* 2️⃣ Solo campos marcados para el reporte
        ───────────────────────────────────────── */
        $extraFields = Field::where('mostrarenreporte', 1)
                            ->pluck('name')
                            ->toArray();

        $headers = array_merge($headers, $extraFields);

    $rows = [];

    foreach ($campaign->messages as $message) {
        // Status traducido
       


        switch ($message->status) {
    case 0:
        $status = 'PENDIENTE DE MANDAR';
        break;
    case 1:
        $status = 'ERROR AL MANDAR (NO ES WHATSAPP)';
        break;
    case 2:
        $status = 'MANDADO';
        break;
    case 3:
        $status = 'ENTREGADO';
        break;
    case 4:
        $status = 'LEIDO';
        break;
    case 5:
        $status = 'ERROR';
        break;
    case 6:
        $status = 'CONTESTADO'; // SE EJECUTA UN PROCESO PARA  BUSCAR EN LA TABLA DE MENSAJES SI HAY MENSAJES DE ESE USUARIO POSTERIOR AL MENSAJE DE CAMPAÑA
        break;
    default:
        $status = 'Desconocido';
}

        $contact = $message->contact;

         $row = [
            
            $campaign->name,                     // ← nueva columna
           
            //$contact->phone,
            $contact->expediente,
            $contact->name,
            substr($contact->phone, -10), // ← aquí ya solo mandas los 10 dígitos
            $status,
            $message->respuesta,
            $contact->observaciones,
            $message->scheduled_at ?? $message->created_at,
            $message->error,
            $contact->groups()->pluck('name')->implode(','),
        ];

        foreach ($extraFields as $field) {
            $value = $contact->fields()->where('name', $field)->value('value');
            $row[] = $value ?? '';
        }

        $rows[] = $row;
    }

    // Exportar usando Laravel Excel directamente desde una clase anónima
    return Excel::download(new class($rows, $headers) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
        protected $rows;
        protected $headers;

        public function __construct(array $rows, array $headers)
        {
            $this->rows = $rows;
            $this->headers = $headers;
        }

        public function collection()
        {
            return collect($this->rows);
        }

        public function headings(): array
        {
            return $this->headers;
        }
    }, $filename, ExcelFormat::XLSX);
}

 


public function reportMulti(Request $request)
{
    $campaignIds = $request->input('campaigns', []);
    if (empty($campaignIds)) {
        return back()->with('error', 'Selecciona al menos una campaña.');
    }

    $campaigns = Campaign::with(['messages.contact', 'messages'])->whereIn('id', $campaignIds)->get();
 
 

            $headers = [
            'Campaña', 'Expediente','Nombre', 'Telefono', 'Status',
            'Respuesta', 'Observaciones', 'Mandado en',
            'Error', 'Grupo'
        ];

        /* Solo los campos que deben mostrarse en el reporte */
        $extraFields = Field::where('mostrarenreporte', 1)
                            ->pluck('name')
                            ->toArray();

        $headers = array_merge($headers, $extraFields);

    $rows = [];

    foreach ($campaigns as $campaign) {
        foreach ($campaign->messages as $message) {
            $contact = $message->contact;
            if (!$contact) continue;

            // Status traducido (puedes extraer esto a una función si lo usas mucho)
            switch ($message->status) {
                case 0: $status = 'PENDIENTE DE MANDAR'; break;
                case 1: $status = 'ERROR AL MANDAR (NO ES WHATSAPP)'; break;
                case 2: $status = 'MANDADO'; break;
                case 3: $status = 'ENTREGADO'; break;
                case 4: $status = 'LEIDO'; break;
                case 5: $status = 'ERROR'; break;
                case 6: $status = 'CONTESTADO'; break;
                default: $status = 'Desconocido';
            }

            $row = [
                $campaign->name,
                $contact->expediente,
                $contact->name,
                //$contact->phone,
                 substr($contact->phone, -10), // ← aquí ya solo mandas los 10 dígitos
                $status,
                $message->respuesta,
                $contact->observaciones,
                $message->scheduled_at ?? $message->created_at,
                $message->error,
                $contact->groups()->pluck('name')->implode(','),
            ];

            foreach ($extraFields as $field) {
                $value = $contact->fields()->where('name', $field)->value('value');
                $row[] = $value ?? '';
            }

            $rows[] = $row;
        }
    }

    $timestamp = now()->format('Y-m-d_H-i-s');
    $filename = "Reporte_Campaña_Multi_{$timestamp}.xlsx";

    return Excel::download(new class($rows, $headers) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
        protected $rows;
        protected $headers;

        public function __construct(array $rows, array $headers)
        {
            $this->rows = $rows;
            $this->headers = $headers;
        }

        public function collection()
        {
            return collect($this->rows);
        }

        public function headings(): array
        {
            return $this->headers;
        }
    }, $filename, ExcelFormat::XLSX);
}




//funcion que detecta variables numericas y de texto en los componentes del template
private function componentToVariablesList($template){
    $jsonData = json_decode($template->components, true);

    $variables = [];
    foreach ($jsonData as $item) {

        if($item['type']=="HEADER" && $item['format']=="TEXT"){
            // Detecta variables numéricas y de texto
            preg_match_all('/{{\s*([\w]+)\s*}}/', $item['text'], $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $id) {
                    $exampleValue = "";
                    try {
                        // Si es numérico, busca en el ejemplo, si no, deja vacío o busca por nombre si tienes ejemplos nombrados
                        if (is_numeric($id)) {
                            $exampleValue = $item['example']['header_text'][$id - 1] ?? '';
                        }
                    } catch (\Throwable $th) {}
                    $variables['header'][] = ['id' => $id, 'exampleValue' => $exampleValue];
                }
            }
        } else if($item['type']=="HEADER" && $item['format']=="DOCUMENT"){
            $variables['document']=true;
        } else if($item['type']=="HEADER" && $item['format']=="IMAGE"){
            $variables['image']=true;
        } else if($item['type']=="HEADER" && $item['format']=="VIDEO"){
            $variables['video']=true;
        } else if($item['type']=="BODY"){
            // Detecta variables numéricas y de texto
         $varTextCounter = 1;

            preg_match_all('/{{\s*([\w]+)\s*}}/', $item['text'], $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $id) {
                    $exampleValue = "";
                    $finalId = $id;
                    try {
                        if (is_numeric($id)) {
                            $exampleValue = $item['example']['body_text'][0][$id - 1] ?? '';
                            $finalId = (int)$id;
                        } else {
                            // Asigna el consecutivo y usa el nombre como exampleValue
                            $exampleValue = $id;
                            $finalId = $varTextCounter++;
                        }
                    } catch (\Throwable $th) {}
                    $variables['body'][] = ['id' => $finalId, 'exampleValue' => $exampleValue];
                }
            }
        } else if($item['type']=="BUTTONS"){
            foreach ($item['buttons'] as $keyBtn => $button) {
                if($button['type']=="URL"){
                    preg_match_all('/{{\s*([\w]+)\s*}}/', $button['url'], $matches);
                    if (!empty($matches[1])) {
                        foreach ($matches[1] as $id) {
                            $exampleValue = "";
                            try {
                                if (is_numeric($id)) {
                                    $exampleValue = $button['url'];
                                    $exampleValue = str_replace("{{{$id}}}", "", $exampleValue );
                                }
                            } catch (\Throwable $th) {}
                            $variables['buttons'][$id][] = [
                                'id' => $id,
                                'exampleValue' => $exampleValue,
                                'type' => $button['type'],
                                'text' => $button['text']
                            ];
                        }
                    }
                }
                if($button['type']=="COPY_CODE"){
                    $exampleValue = $button['example'][0] ?? '';
                    $variables['buttons'][$keyBtn][] = [
                        'id' => $keyBtn,
                        'exampleValue' => $exampleValue,
                        'type' => $button['type'],
                        'text' => $button['text']
                    ];
                }
            }
        }
    }
    return $variables;
}





private function normalizeComponentVariables($components)
{
    foreach ($components as &$component) {
        if (isset($component['text'])) {
            // Detecta si ya tiene variables numéricas
            if (preg_match('/{{\s*\d+\s*}}/', $component['text'])) {
                // Ya tiene variables numéricas, no hacer nada
                continue;
            }
            // Reemplaza variables con nombre por numéricas
            $varNames = [];
            preg_match_all('/{{\s*([\w]+)\s*}}/', $component['text'], $matches);
            if (!empty($matches[1])) {
                $varNames = $matches[1];
                $replaceMap = [];
                foreach ($varNames as $idx => $name) {
                    $replaceMap['{{'.$name.'}}'] = '{{'.($idx+1).'}}';
                }
                $component['text'] = str_replace(array_keys($replaceMap), array_values($replaceMap), $component['text']);
            }
        }
    }
    return $components;
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
 
    
}