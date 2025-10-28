<?php

namespace Modules\Wpbox\Http\Controllers;

use Modules\Wpbox\Models\CampaignType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;


class CampaignsTypesController extends Controller
{
    /* ───── Configuración rápida ───── */
    private $provider       = CampaignType::class;
    private $webroute_path  = 'campaigns.tiposcampa.';          // nombre de las rutas
    private $view_path      = 'wpbox::campaign_types.';           // carpeta de vistas
    private $parameter_name = 'tiposcampa';
    private $title          = 'tipo de campaña';
    private $titlePlural    = 'tipos de campaña';


    private function getFields($class='col-md-4')
    {
        $fields=[];
        
        //Add name field
        $fields[0]=['class'=>$class, 'ftype'=>'input', 'name'=>'Name', 'id'=>'name', 'placeholder'=>'Enter name', 'required'=>true];

        //Return fields
        return $fields;
    }


    private function getFilterFields(){
        $fields=$this->getFields('col-md-3');
        $fields[0]['required']=true;
        return $fields;
    }


    /**
     * Auth checker functin for the crud.
     */
    private function authChecker()
    {
        $this->ownerAndStaffOnly();
    }




    /* ───── CRUD ───── */


    public function index()
    {
        $this->authChecker();

        $items=$this->provider::orderBy('id', 'desc');
        if(isset($_GET['name'])&&strlen($_GET['name'])>1){
            $items=$items->where('name',  'like', '%'.$_GET['name'].'%');
        }
        $items=$items->paginate(config('settings.paginate'));

        return view($this->view_path.'index', ['setup' => [
            'usefilter'=>true,
            'title'=>__('crud.item_managment', ['item'=>__($this->titlePlural)]),
            'action_link'=>route($this->webroute_path.'create'),
            'action_name'=>__('crud.add_new_item', ['item'=>__($this->title)]),
            'items'=>$items,
            'item_names'=>$this->titlePlural,
            'webroute_path'=>$this->webroute_path,
            'fields'=>$this->getFields(),
            'filterFields'=>$this->getFilterFields(),
            'custom_table'=>true,
            'parameter_name'=>$this->parameter_name,
            'parameters'=>count($_GET) != 0,
            'breadcrumbs'   => [[__('Campañas'),'#'],
                                    [__('crud.item_managment',['item'=>$this->titlePlural]),'#']],
            ],
        ]);
    }



    public function create()
    {
        $this->authChecker();


        return view('general.form', ['setup' => [
            'title'=>__('crud.new_item', ['item'=>__($this->title)]),
            'action_link'=>route($this->webroute_path.'index'),
            'action_name'=>__('crud.back'),
            'iscontent'=>true,
            'action'=>route($this->webroute_path.'store'),
            'breadcrumbs' => [
                [__('Campañas'), route('campaigns.index')]
            ],
        ],
        'fields'=>$this->getFields() ]);
    }


    /** Guardar */
    public function store(Request $r)
    {
        $this->authChecker();

        $this->provider::create(['name' => $r->name,
                                 'company_id' => session('company_id')]); // si aplica
        return redirect()->route($this->webroute_path.'index')
               ->withStatus(__('crud.item_has_been_added',['item'=>$this->title]));
    }

      /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contacts
     * @return \Illuminate\Http\Response
     */
    public function edit(CampaignType $tiposcampa)
    {
        $this->authChecker();

        $fields = $this->getFields();
        $fields[0]['value'] = $tiposcampa->name;

        $parameter = [];
        $parameter[$this->parameter_name] = $tiposcampa->id;

        return view($this->view_path.'edit', ['setup' => [
            'title'=>__('crud.edit_item_name', ['item'=>__($this->title), 'name'=>$tiposcampa->name]),
            'action_link'=>route($this->webroute_path.'index'),
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

    try {
        $item = $this->provider::findOrFail($id);
        $item->delete();

        return redirect()
            ->route($this->webroute_path.'index')
            ->withStatus(__('crud.item_has_been_removed', ['item' => __($this->title)]));

    } catch (QueryException $e) {
        if ($e->getCode() == '23000') {
            return redirect()
                ->route($this->webroute_path.'index')
                ->withError('No se puede eliminar porque está relacionado con otros registros.');
        }

        return redirect()
            ->route($this->webroute_path.'index')
            ->withError('Error al intentar eliminar el registro.');
    }
}


}