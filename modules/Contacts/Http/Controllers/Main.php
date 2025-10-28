<?php

namespace Modules\Contacts\Http\Controllers;

use Modules\Contacts\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Plans;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;
use Modules\Contacts\Exports\ContactsExport;
use Modules\Contacts\Imports\ContactsImport;
use Illuminate\Database\QueryException;
use Modules\Contacts\Models\Country;
use Modules\Contacts\Models\Field;
use Modules\Contacts\Models\Group;
 

class Main extends Controller
{
    /**
     * Provide class.
     */
    private $provider = Contact::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'contacts.';

    /**
     * View path.
     */
    private $view_path = 'contacts::contacts.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'contact';

    /**
     * Title of this crud.
     */
    private $title = 'Contacto';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'Contactos';

    private function hasAccessToAIBots(){
        $allowedPluginsPerPlan = auth()->user()->company?auth()->user()->company->getPlanAttribute()['allowedPluginsPerPlan']:[];
        if($allowedPluginsPerPlan==null||in_array("flowiseai",$allowedPluginsPerPlan)){
            return true;
        }else{
            return false;
        }
    }

    private function getFields($class='col-md-4',$getCustom=true)
    {
        $fields=[];

        //Avatar
        $fields[0]=['class'=>$class, 'ftype'=>'image', 'name'=>'Avatar', 'id'=>'avatar','style'=>'width: 200px; height:200'];
        
        //Add Expediente field
            $expedienteField = [
                'class' => $class, 
                'ftype' => 'input', 
                'name' => 'Expediente', 
                'id' => 'expediente', 
                'placeholder' => 'Captura el Expediente', 
                'required' => false
            ];


             if($getCustom){
                    if (auth()->user()->hasRole('client')) {
                        $expedienteField['value'] = 'PRIMERA VEZ';
                    
                    }
             }

            $fields[1] = $expedienteField;

        //Add name field
        $fields[2]=['class'=>$class, 'ftype'=>'input', 'name'=>'Name', 'id'=>'name', 'placeholder'=>'Enter name', 'required'=>true];

        //Add phone field
       // $fields[3]=['class'=>$class, 'ftype'=>'input','type'=>"phone", 'name'=>'Phone', 'id'=>'phone', 'placeholder'=>'Enter phone', 'required'=>true];
     
            
            $fields[3]=[
                'class'=>$class . ' phone-mask', 
                'ftype'=>'input',
                'type'=>"tel", 
                'name'=>'Phone', 
                'id'=>'phone', 
                'placeholder'=>'Teclee el Teléfono',
                
                'required'=>true,
                'maxlength'=>'13', // 521 10 dígitos
            ];

        
    //Add EMAIL field
        $fields[4]=['class'=>$class, 'ftype'=>'input','type'=>"email", 'name'=>'Email', 'id'=>'email', 'placeholder'=>'Escribe Email', 'required'=>false];


        //Groups
          if(!$getCustom){
                  $fields[5]=['class'=>$class, 'multiple'=>true, 'classselect'=>"select2init", 'ftype'=>'select', 'name'=>'Groups', 'id'=>'groups[]', 'placeholder'=>'Select group', 'data'=>Group::get()->pluck('name','id'), 'required'=>true];
            }else{
                $fields[5]=['class'=>$class, 'multiple'=>true, 'classselect'=>"select2init", 'ftype'=>'select', 'name'=>'Groups', 'id'=>'groups[]', 'placeholder'=>'Select group', 'data'=>Group::where('esauto', 0)->get()->pluck('name','id'), 'required'=>true];
       
          }
        //Country
     //  $fields[4]=['class'=>$class, 'ftype'=>'select', 'name'=>'Country', 'id'=>'country_id', 'placeholder'=>'Select country', 'data'=>Country::get()->pluck('name','id'), 'required'=>true];
  
     $company = $this->getCompany();


  

    $agent_enable=$company->getConfig('agent_enable',"false");
    if($agent_enable=="true"){
        $fields[6] = [
            'class' => $class,
            'ftype' => 'select',
            'name' => 'Agente' ,
            'id' => 'user_id',
            'placeholder' => 'Selecciona un agente',
            'data' => User::where('company_id', $company->id)->pluck('name', 'id'),
            'required' => true
        ];
    }


 //Agregar Observaciones
        $fields[7]=['class'=>$class, 'ftype'=>'input','type'=>"observaciones", 'name'=>'Observaciones', 'id'=>'observaciones', 'placeholder'=>'Teclee Observaciones', 'required'=>false];

    
    // Simple Bot reply ( los bots )
    $fields[8]=['class'=>$class, 'ftype'=>'bool', 'name'=>'Habilitar BOT normal reply', 'id'=>'enabled_bot', 'placeholder'=>'Habilitar BOT normal reply', 'required'=>false, 'value'=>true];

    // AI Bot enabled
    $fields[9]=['class'=>$class, 'ftype'=>'bool', 'name'=>'Habilitar IA BOT reply', 'id'=>'enabled_ai_bot', 'placeholder'=>'AI Bot replies enabled', 'required'=>false, 'value'=>true];
    $customFieldStart=9;

        if($getCustom){
            $customFields=Field::get()->toArray();
            $i=$customFieldStart;   
            foreach ($customFields as $filedkey => $customField) {
                $i++;
                $fields[$i]=['class'=>$class, 'ftype'=>'input', 'type'=>$customField['type'], 'name'=>__($customField['name']), 'id'=>"custom[".$customField['id']."]", 'placeholder'=>__($customField['name']), 'required'=>false];
    
            }
        }
        

        //Return fields
        return $fields;
    }


   private function getFilterFields(){
    $fields = $this->getFields('col-md-3', false);
    unset($fields[0]);

    //expediente
    $fields[1]['required'] = false;

    //name
    $fields[2]['required'] = false;

    // telefono
    $fields[3]['required'] = false;

    //email
    $fields[4]['required'] = false;

    // GRUPO
    $fields[5]['required'] = false;
    $fields[5]['multiple'] = false;
    $fields[5]['id'] = 'group';
    unset($fields[5]['multiple']);
    // Agregar opción "Sin grupo"
    $fields[5]['data'] = [ 'none' => '[SIN GRUPO]' ] + $fields[5]['data']->toArray();

     $company = $this->getCompany();
    $agent_enable=$company->getConfig('agent_enable',"false");
        if($agent_enable=="true"){
            // AGENTE
            $fields[6]['required'] = false;
            $fields[6]['multiple'] = false;
            unset($fields[6]['multiple']);

            // Agregar opción "Sin agente"
            $fields[6]['data'] = [ 'none' => '[SIN AGENTE]' ] + $fields[6]['data']->toArray();
        }




    unset($fields[7]); // OBSERVACIONES
    unset($fields[8]); // BOT NORMAL
    unset($fields[9]); // BOT IA

    return $fields;
}




    /**
     * Auth checker functin for the crud.
     */
private function authChecker($role = null)
{
    if ($role === 'owner') {
        // Si se pasa 'owner', haces algo diferente
        // Ejemplo:
        if (!auth()->user()->hasRole('owner')) {
            abort(403, 'Los contactos se agregan en el sistema principal.');
        }
    } else {
        // Si no se pasa nada, ejecutas el comportamiento normal
        $this->ownerAndClientOnly();
    }
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



     //AQUI SE OBTIENEN LISTADOS VARIOS , COMO CONTACTOS, GRUPOS, PAIS
 public function index()
{
    $this->authChecker();

    $company = $this->getCompany();

    $agent_enable=$company->getConfig('agent_enable',"false");

    // Inicia solo una vez
   $items = $this->provider::query();

    // Expediente
    if (isset($_GET['expediente']) && strlen($_GET['expediente']) > 1) {
        $items = $items->where('expediente', 'like', '%' . $_GET['expediente'] . '%');
    }

    // Nombre
    if (isset($_GET['name']) && strlen($_GET['name']) > 1) {
        $items = $items->where('name', 'like', '%' . $_GET['name'] . '%');
    }

    // Teléfono
    if (isset($_GET['phone']) && strlen($_GET['phone']) > 1) {
        $items = $items->where('phone', 'like', '%' . $_GET['phone'] . '%');
    }

    // Email
    if (isset($_GET['email']) && strlen($_GET['email']) > 1) {
        $items = $items->where('email', 'like', '%' . $_GET['email'] . '%');
    }

    // Grupos
    if (isset($_GET['group']) && strlen($_GET['group'] . "") > 0) {
        if ($_GET['group'] === 'none') {
            $items = $items->whereDoesntHave('groups');
        } else {
            $items = $items->whereHas('groups', function ($query) {
                $query->where('groups.id', $_GET['group']);
            });
        }
    }

        if( $agent_enable=="true"){

                // Agente
                if (isset($_GET['user_id']) && strlen($_GET['user_id']) > 0) {
                    if ($_GET['user_id'] === 'none') {
                        $items = $items->whereNull('user_id');
                    } else {
                        $items = $items->where('user_id', $_GET['user_id']);
                    }
                }
        }


    // Orden final (elige uno solo)
    $items = $items->orderBy('name', 'asc');

    // Exportar
    if (isset($_GET['report'])) {
        return $this->exportCSV($items->with(['fields', 'groups'])->get());
    }

    $totalItems = $items->count();

    $items = $items->paginate(config('settings.paginate'))->appends(request()->query());


    

    $users = \App\Models\User::where('company_id', $company->id)->get();

    // Verificás qué trae la variable
    //dd($users); // Esto detiene la ejecución y muestra el contenido


    return view($this->view_path . 'index', ['setup' => [
        'usefilter' => true,
        'title' => $this->titlePlural,
        'subtitle' => $totalItems == 1 ? __('1 Contact') : $totalItems . " " . __('Contacts'),
        'action_link' => route($this->webroute_path . 'create'),
        'action_name' => __('crud.add_new_item', ['item' => __($this->title)]),
        'action_link2' => route($this->webroute_path . 'groups.index'),
        'action_name2' => __('Groups'),
        'action_link3' => route($this->webroute_path . 'fields.index'),
        'action_name3' => __('Fields'),
        'action_link4' => route($this->webroute_path . 'index', ['report' => true]),
        'action_name4' => __('Export'),
        'items' => $items,
        'item_names' => $this->titlePlural,
        'webroute_path' => $this->webroute_path,
        'fields' => $this->getFields(),
        'filterFields' => $this->getFilterFields(),
        'custom_table' => true,
        'parameter_name' => $this->parameter_name,
        'parameters' => count($_GET) != 0,
        'groups' => Group::where('esauto', 0)->get(),
        'users' => $users,
        'agent_enable' => $agent_enable,
    ]]);
}

    public function exportCSV($contactsToDownload)
    {
        $items = [];
    
        // Obtener todos los campos personalizados de contacto
        $customFields = Field::get();
    
        foreach ($contactsToDownload as $contact) {
            // Inicializar el arreglo para cada contacto
            $item = [
                'Expediente' => $contact->expediente,
                'Name' => $contact->name,
               // 'Phone' => $contact->phone,
                'Phone' =>   substr($contact->phone, -10), // ← aquí ya solo mandas los 10 dígitos
                'Email' => $contact->email,
                'Observaciones' => $contact->observaciones,
            ];
    
            // Obtener los grupos del contacto
            $groups = $contact->groups()->pluck('name')->implode(', ');
    
            // Agregar los grupos al item del contacto
            $item['Groups'] = $groups;
    
            // Agregar campos personalizados al item del contacto
            foreach ($customFields as $field) {
                // Inicializar el campo personalizado
                $item[$field->name] = '';
    
                // Buscar el valor del campo personalizado para el contacto actual
                foreach ($contact->fields as $contactField) {
                    if ($field->name == $contactField->name) {
                        $item[$field->name] = $contactField->pivot->value;
                        break;
                    }
                }
            }
    
            // Agregar el contacto al arreglo de items
            $items[] = $item;
        }
    
     
  
    
        // Agregar los nombres de los campos personalizados como columnas
        foreach ($customFields as $field) {
            $columns[] = $field->name;
        }
    
        // Generar y descargar el archivo CSV usando Laravel Excel
       // return Excel::download(new ContactsExport($items, $columns), 'contacts_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV);
    
 return Excel::download(
    new ContactsExport($items, $columns),
    'contacts_' . time() . '.xlsx', // 👈 cambia .csv por .xlsx
    \Maatwebsite\Excel\Excel::XLSX  // 👈 cambia el tipo de exportación
);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // $this->authChecker('owner');


        return view($this->view_path.'edit', ['setup' => [
            'title'=>__('crud.new_item', ['item'=>__($this->title)]),
            'action_link'=>route($this->webroute_path.'index'),
            'action_name'=>__('crud.back'),
            'iscontent'=>true,
            'action'=>route($this->webroute_path.'store'),
        ],
        'fields'=>$this->getFields() ]);
    }

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function store(Request $request)
{
    $this->authChecker();
    
    try {
        //Create new contact
        $contact = $this->provider::create([
            'expediente' => $request->expediente,
            'name' => $request->name,
            'phone' => $request->phone,
            'esprimeravez' => $request->expediente === 'PRIMERA VEZ' ? 1 : 0,
        ]);
        $contact->save();

        if($request->has('avatar')){
            if(config('settings.use_s3_as_storage',false)){
                //S3
                $contact->avatar=Storage::disk('s3')->url($request->avatar->storePublicly("uploads/".$contact->company_id."/contacts",'s3'));
            }else{
                $contact->avatar=Storage::disk('public_media_upload')->url($request->avatar->store(null,'public_media_upload'));
            }

            $contact->update();
        }

        // Attaching groups to the contact
        $contact->groups()->attach($request->groups);

        if(isset($request->custom)){
            $this->syncCustomFieldsToContact($request->custom,$contact);
        }

        return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.item_has_been_added', ['item'=>__($this->title)]));
        
    } catch (\Illuminate\Database\QueryException $e) {
        // Captura errores de base de datos (llave única, foreign key, etc.)
        
        // Código 23000 es para violación de integridad (llave única/duplicada)
        if ($e->getCode() == 23000) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['name' => 'El Nombre del Contacto ya existe en el sistema.']);
        }
        
        // Otros errores de base de datos
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Error al guardar: ' . $e->getMessage()]);
            
    } catch (\Exception $e) {
        // Captura cualquier otro error general
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Ocurrió un error inesperado: ' . $e->getMessage()]);
    }
}
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contacts
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        $this->authChecker();

        $company = $this->getCompany();
       $agent_enable=$company->getConfig('agent_enable',"false");

        $fields = $this->getFields();
        $fields[0]['value'] = $contact->avatar;
        $fields[1]['value'] = $contact->expediente;
        $fields[2]['value'] = $contact->name;
        $fields[3]['value'] = $contact->phone;
        $fields[4]['value'] = $contact->email;
        $fields[5]['multipleselected'] = $contact->groups->pluck('id')->toArray();
     
        if($agent_enable=="true"){
          $fields[6]['value'] = $contact->user_id;
        }

        $fields[7]['value'] = $contact->observaciones;

        $fields[8]['value'] = $contact->enabled_bot.""=="1"; // BOT NORMAL

        $fields[9]['value'] = $contact->enabled_ai_bot.""=="1";
        


        $customFieldsValues=$contact->fields->toArray();
        foreach ($customFieldsValues as $key => $fieldWithPivot) {
            foreach ( $fields as $key => &$formField) {
               if($formField['id']=="custom[".$fieldWithPivot['id']."]"){
                $formField['value']=$fieldWithPivot['pivot']['value'];
               }
            }
        }


        $parameter = [];
        $parameter[$this->parameter_name] = $contact->id;


      

        return view($this->view_path.'edit', ['setup' => [
            'title'=>__('crud.edit_item_name', ['item'=>__($this->title), 'name'=>$contact->name]),
            'action_link'=>route($this->webroute_path.'index'),
            'action_name'=>__('crud.back'),
            'iscontent'=>true,
            'isupdate'=>true,
            'action'=>route($this->webroute_path.'update', $parameter),
            'agent_enable'=>$agent_enable,
        ],
        'fields'=>$fields, ]);
    }

   


/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \App\Contact  $contacts
 * @return \Illuminate\Http\Response
 */

public function update(Request $request, $id)
{
    $this->authChecker();
    
    try {
        $item = $this->provider::findOrFail($id);
        $item->expediente = $request->expediente;
        $item->name = $request->name;
        $item->phone = $request->phone;
        $item->email = $request->email;
        //$item->country_id = $request->country_id;
        $item->user_id = $request->user_id;

        $item->observaciones = $request->observaciones;
        $item->enabled_bot = $request->enabled_bot=="true";

        if($this->hasAccessToAIBots()){
            $item->enabled_ai_bot = $request->enabled_ai_bot=="true";
        }

        if($request->has('avatar')){
            if(config('settings.use_s3_as_storage',false)){
                //S3
                $item->avatar=Storage::disk('s3')->url($request->avatar->storePublicly("uploads/".$item->company_id."/contacts",'s3'));
            }else{
                $item->avatar=Storage::disk('public_media_upload')->url($request->avatar->store(null,'public_media_upload'));
            }
        }

        $item->update();

        if(isset($request->custom)){
            $this->syncCustomFieldsToContact($request->custom,$item);
        }

        // Attaching groups to the contact
        $item->groups()->sync($request->groups);
        $item->update();

        return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.item_has_been_updated', ['item'=>__($this->title)]));
        
    } catch (\Illuminate\Database\QueryException $e) {
        // Captura errores de base de datos (llave única, foreign key, etc.)
        
        // Código 23000 es para violación de integridad (llave única/duplicada)
        if ($e->getCode() == 23000) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['name' => 'El Nombre ya existe en el sistema.']);
        }
        
        // Otros errores de base de datos
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
            
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Si no encuentra el registro
        return redirect()->route($this->webroute_path.'index')
            ->withErrors(['error' => 'El registro no fue encontrado.']);
            
    } catch (\Exception $e) {
        // Captura cualquier otro error general
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Ocurrió un error inesperado: ' . $e->getMessage()]);
    }
}






    public function syncCustomFieldsToContact($fields,$contact){
        $contact->fields()->sync([]);
        foreach ($fields as $key => $value) {
            if($value){
                $contact->fields()->attach($key, ['value' => $value]);
            }
          
        }
        $contact->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contacts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authChecker();
        $item = $this->provider::findOrFail($id);
        $item->forceDelete();
        return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.item_has_been_removed', ['item'=>__($this->title)]));
    }






    public function bulkremove($ids)
    {
        $this->authChecker();
        $ids = explode(",", $ids);
        $this->provider::destroy($ids);

        // Return a JSON response
        return response()->json([
            'status' => 'success',
            'message' => __('crud.items_have_been_removed', ['item' => __($this->titlePlural)])
        ], 200);
    }



public function removeagent($ids)
{
    $this->authChecker();

    $ids = explode(",", $ids);

    foreach ($ids as $contactId) {
        $contact = Contact::find($contactId);
        if ($contact) {
            $contact->user_id = null;
            $contact->save();
        }
    }

    return response()->json([
        'status' => 'success',
        'message' => __('Se removió el agente de los contactos correctamente.')
    ], 200);
}



  public function assigntoagent($ids, Request $request)
    {
        $this->authChecker();

        $ids = explode(",", $ids);
        $user = User::find($request->get('user_id'));

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => __('No user selected')
            ], 404);
        }

        // Aquí asumo que tienes relación en User: public function contacts() { return $this->hasMany(Contact::class); }
        foreach ($ids as $contactId) {
          $contact = Contact::find($contactId);
            if ($contact) {
                $contact->user_id = $user->id;
                $contact->save();
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => __('Se asignaron los contactos al agente correctamente.')
        ], 200);
    }

    public function assigntogroup($ids)
    {
        $this->authChecker();
        $ids = explode(",", $ids);
        $group = Group::find($_GET['group_id']);

        if (!$group) {
            // Group not found, return an error response
            return response()->json([
                'status' => 'error',
                'message' => __('No group selected')
            ], 404);
        }

        $group->contacts()->syncWithoutDetaching($ids);

        // Return a JSON response
        return response()->json([
            'status' => 'success',
            'message' => __('crud.items_has_been_updated', ['item' => __($this->titlePlural)])
        ], 200);
    }

    public function removefromgroup($ids)
    {
        $this->authChecker();
        $ids = explode(",", $ids);
        $group = Group::find($_GET['group_id']);

        if (!$group) {
            // Group not found, return an error response
            return response()->json([
                'status' => 'error',
                'message' => __('No group selected')
            ], 404);
        }

        $group->contacts()->detach($ids);

        // Return a JSON response
        return response()->json([
            'status' => 'success',
            'message' => __('crud.items_has_been_updated', ['item' => __($this->titlePlural)])
        ], 200);
    }

    public function importindex(){
        $groups=Group::pluck('name','id');
        return view("contacts::".$this->webroute_path.'import',['groups'=>$groups]);
    }

    public function import(Request $request){
       
      // $lastContact=$this->provider::orderBy('id', 'desc')->first();
       Excel::import(new ContactsImport,$request->csv);

       return redirect()->route($this->webroute_path.'index')->withStatus(__('Contactos importados'));
    }
    
// FUNCION PARA CAMBIAR EL STATUS DEL BOT NORMAL DESDE EL CHAT
    public function toggleEnabledBot(Request $request, $id) {
        $contact = Contact::findOrFail($id);
        $contact->enabled_bot = $request->input('enabled_bot');
        $contact->save();
    
        return response()->json(['message' => 'Status actualizado con éxito.']);
    }

// FUNCION PARA CAMBIAR EL GRUPO DEL CONTACTO DESDE EL CHAT
public function toggleCambiarGrupo(Request $request, $id) {
    $contact = Contact::findOrFail($id);

    $group_id = $request->input('group_id');

    $contact->groups()->sync($group_id);

    //$contact->save();

    return response()->json(['message' => 'Grupo Actualizado con éxito.']);
}

// FUNCION PARA CAMBIAR LAS OBSERVACIONES  DESDE EL CHAT
    public function toggleCambiarObservacion(Request $request, $id) {
       $contact = Contact::findOrFail($id);
    $contact->observaciones = $request->input('observaciones');
    $contact->save();

    return response()->json(['message' => true, 'msg' => 'Observación actualizada']);
    }


}
