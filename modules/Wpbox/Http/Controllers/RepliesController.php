<?php

namespace Modules\Wpbox\Http\Controllers;

use Modules\Wpbox\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Wpbox\Models\Campaign;

class RepliesController extends Controller
{
    /**
     * Provide class.
     */
    private $provider = Reply::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'replies.';

    /**
     * View path.
     */
    private $view_path = 'wpbox::replies.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'reply';

    /**
     * Title of this crud.
     */
    private $title = 'Respuesta Automática';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'Respuestas Automáticas';

    private function getFields($class='col-md-4', $type='bot')
    {
        $fields=[];
        
        //Add name field
        $fields[0]=['class'=>$class, 'ftype'=>'input', 'name'=>'Name', 'id'=>'name', 'placeholder'=>'Enter name', 'required'=>true];

        //Add text field
        $fields[1]=['class'=>$class, 'ftype'=>'textarea', 'name'=>'Reply text', 'id'=>'text', 'placeholder'=>'Texto a contestar', 'required'=>true,'additionalInfo'=>__('Texto que será mandado al contacto. Se puede usar {{name}},{{phone}} y otros campos como parametros')];

        //Type
      
        $fields[2]=['class'=>$class, 'value'=>"1", 'ftype'=>'select', 'name'=>'Reply type', 'id'=>'type', 'placeholder'=>'Select reply type', 'data'=>['1'=>__('Just a quick reply'),'2'=>__('Reply bot: On exact match'),'3'=>__('Reply bot: When message contains'),'4'=>__('Reply bot: Match Exacto + Guarda Respuesta en campo (Respuesta)'),'5'=>__('Welcome reply - when client send the first message')], 'required'=>true];
        
        //Add trigger field
        $fields[3]=['class'=>$class, 'ftype'=>'input', 'name'=>'Trigger', 'id'=>'trigger', 'placeholder'=>'Teclea el Trigger del bot', 'required'=>false];

        //If type is bot
        if($type=='bot'){
            // Add header field
            $fields[4]=['class'=>$class,'additionalInfo'=>"Opcional, Encabezado", 'ftype'=>'input', 'name'=>'Header', 'id'=>'header', 'placeholder'=>'Teclea Encabezado', 'required'=>false];

            $fields[5]=['class'=>$class, 'additionalInfo'=>"Opcional, Pie de Pagina", 'ftype'=>'input', 'name'=>'Footer', 'id'=>'footer', 'placeholder'=>'Teclea pie de pagina', 'required'=>false];

            $fields[6]=['class'=>$class,'separator'=>"Opción 1: Respuesta con Botones", 'additionalInfo'=>"Opcional, Botón1 texto", 'ftype'=>'input', 'name'=>'Button1', 'id'=>'button1', 'placeholder'=>'Teclea el texto del botón 1', 'required'=>false];

            $fields[7]=['class'=>$class, 'additionalInfo'=>"Opcional, botón 1 ID", 'ftype'=>'input', 'name'=>'Botón 1 ID', 'id'=>'button1_id', 'placeholder'=>'Teclea el ID del botón 1 ', 'required'=>false];

            $fields[8]=['class'=>$class, 'additionalInfo'=>"Opcional, botón 2 text", 'ftype'=>'input', 'name'=>'Botón 2', 'id'=>'button2', 'placeholder'=>'Teclea el texto del botón 2', 'required'=>false];

            $fields[9]=['class'=>$class, 'additionalInfo'=>"Opcional, botón 2 ID", 'ftype'=>'input', 'name'=>'Botón 2 ID', 'id'=>'button2_id', 'placeholder'=>'Teclea el ID del botón 2', 'required'=>false];

            $fields[10]=['class'=>$class, 'additionalInfo'=>"Opcional, botón 3 text", 'ftype'=>'input', 'name'=>'Botón 3', 'id'=>'button3', 'placeholder'=>'Teclea el texto del botón 3', 'required'=>false];

            $fields[11]=['class'=>$class, 'additionalInfo'=>"Opcional, botón 3 ID", 'ftype'=>'input', 'name'=>'Botón 3 ID', 'id'=>'button3_id', 'placeholder'=>'Teclea el ID del botón 3', 'required'=>false];
       
            $fields[12]=['class'=>$class,'separator'=>"Opción 2: Mandar Archivo", 'additionalInfo'=>"Nombre del Archivo", 'ftype'=>'input', 'name'=>'Texto del Archivo', 'id'=>'button_name', 'placeholder'=>'Teclea el texto del botón ', 'required'=>false];

            $fields[13]=['class'=>$class, 'additionalInfo'=>"Ruta del Archivo - Link", 'ftype'=>'input', 'name'=>'Link del Archivo', 'id'=>'button_url', 'placeholder'=>'Ruta del Archivo', 'required'=>false];

        }
        //Return fields
        return $fields;
    }


    private function getFilterFields(){
        $fields=$this->getFields('col-md-3', 'qr');
        $fields[0]['required']=true;
        unset($fields[1]);
        unset($fields[2]);
        unset($fields[3]);
        return $fields;
    }

    /**
     * Auth checker functin for the crud.
     */
    private function authChecker()
    {
        $this->ownerAndClientOnly();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authChecker();

        //Check if this is Quick Reply only view, ?type=qr
        //Use request
        $isQuickReplies=request()->has('type') && request()->get('type') === 'qr';
        if($isQuickReplies){
            $items=$this->provider::where('type', 1)->orderBy('id', 'desc')->where('flow_id', null);
            $items=$items->paginate(config('settings.paginate'));
        }else{
            //Bots
            //text based bots
            $items=$this->provider::where('type', '!=', 1)->where('flow_id', null)->orderBy('id', 'desc');

            //Template based bots
            $template_bots = Campaign::orderBy('id', 'desc')->whereNull('contact_id')->where('is_bot', true);
            $items = $items->get()->merge($template_bots->get());
        }

        
        

        //Regular, bot ant template based bot
        $setup=[
            'usefilter'=>null,
            'title'=>__('Manejador Respuestas Automáticas'),
            'action_link'=>route('campaigns.create',['type'=>'bot']),
            'action_name'=>__('Create Respuesta ( Plantilla )'),
            'action_link2'=>route($this->webroute_path.'create',['type'=>"bot"]),
            'action_name2'=>__('Crear Respuesta Automática'),
            'items'=>$items,
            'item_names'=>$this->titlePlural,
            'webroute_path'=>$this->webroute_path,
            'fields'=>$this->getFields('col-md-3', $isQuickReplies?'qr':'bot'),
            'filterFields'=>$this->getFilterFields(),
            'custom_table'=>true,
            'parameter_name'=>$this->parameter_name,
            'parameters'=>count($_GET) != 0,
            'hidePaging'=>!$isQuickReplies,
        ];

        if($isQuickReplies){
            $setup['title']=__('Quick Replies management');
            $setup['action_link']=route($this->webroute_path.'create',['type'=>"reply"]);
            $setup['action_name']=__('Create new reply');
            unset($setup['action_link2']);
            unset($setup['action_name2']);
        }

        return view($this->view_path.'index', ['setup' => $setup]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authChecker();

        $isBot = request()->has('type') && request()->get('type') === 'bot';
        
        $fields = $this->getFields( 'col-md-6', ($isBot?'bot':'qr'));

        if($isBot){
            
            //Unset the 2nd field, first option
            unset($fields[2]['data'][1]);
            $fields[2]['value']=2;

            return view('general.form', ['setup' => [
                'title'=>__('crud.new_item', ['item'=>__('Respuesta Automática')]),
                'action_link'=>route($this->webroute_path.'index',['type'=>'bot']),
                'action_name'=>__('crud.back'),
                'iscontent'=>true,
                'action'=>route($this->webroute_path.'store')
            ],
            'fields'=>$fields ]);
        }else{
            unset($fields[2]['data'][3]);
            unset($fields[2]['data'][2]);
            unset($fields[2]['data'][4]);
            return view('general.form', ['setup' => [
                'title'=>__('crud.new_item', ['item'=>__('Quick Reply')]),
                'action_link'=>route($this->webroute_path.'index',['type'=>'qr']),
                'action_name'=>__('crud.back'),
                'iscontent'=>true,
                'action'=>route($this->webroute_path.'store')
            ],
            'fields'=>$fields ]);
        }
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
        
        //Create new field
        $field = $this->provider::create([
            'name' => $request->name,
            'type' => $request->type,
            'text' => $request->text,
            'trigger' => $request->trigger,
        ]);
        if($request->type!=1){
            //Bot
            $field->header = $request->header;
            $field->footer = $request->footer;
            $field->button1 = $request->button1;
            $field->button1_id = $request->button1_id;
            $field->button2 = $request->button2;
            $field->button2_id = $request->button2_id;
            $field->button3 = $request->button3;
            $field->button3_id = $request->button3_id;
            $field->button_name = $request->button_name;
            $field->button_url = $request->button_url;
        }
        $field->save();

        return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.item_has_been_added', ['item'=>__($this->title)]));
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contacts
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        $this->authChecker();

        $fields = $this->getFields('col-md-6',$reply->type==1?'qr':'bot');
        $fields[0]['value'] = $reply->name;
        $fields[1]['value'] = $reply->text;
        $fields[2]['value'] = $reply->type;
        $fields[3]['value'] = $reply->trigger;

        if($reply->type!=1){
            $fields[4]['value'] = $reply->header;
            $fields[5]['value'] = $reply->footer;
            $fields[6]['value'] = $reply->button1;
            $fields[7]['value'] = $reply->button1_id;
            $fields[8]['value'] = $reply->button2;
            $fields[9]['value'] = $reply->button2_id;
            $fields[10]['value'] = $reply->button3;
            $fields[11]['value'] = $reply->button3_id;
            $fields[12]['value'] = $reply->button_name;
            $fields[13]['value'] = $reply->button_url;
        }

        $parameter = [];
        $parameter[$this->parameter_name] = $reply->id;

        return view($this->view_path.'edit', ['setup' => [
            'title'=>__('crud.edit_item_name', ['item'=>__($this->title), 'name'=>$reply->name]),
            'action_link'=>route($this->webroute_path.'index',['type'=>($reply->type==1?'qr':'bot')]),
            'action_name'=>__('crud.back'),
            'iscontent'=>true,
            'isupdate'=>true,
            'action'=>route($this->webroute_path.'update', $parameter),
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
        $item = $this->provider::findOrFail($id);
        $item->name = $request->name;
        $item->type = $request->type;
        $item->text = $request->text;
        $item->trigger = $request->trigger;
        if($request->type!=1){
            $item->header = $request->header;
            $item->footer = $request->footer;
            $item->button1 = $request->button1;
            $item->button1_id = $request->button1_id;
            $item->button2 = $request->button2;
            $item->button2_id = $request->button2_id;
            $item->button3 = $request->button3;
            $item->button3_id = $request->button3_id;
            $item->button_name = $request->button_name;
            $item->button_url = $request->button_url;
        }
        $item->update();

        return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.item_has_been_updated', ['item'=>__($this->title)]));
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
        $item->delete();
        return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.item_has_been_removed', ['item'=>__($this->title)]));
    }
    
}
