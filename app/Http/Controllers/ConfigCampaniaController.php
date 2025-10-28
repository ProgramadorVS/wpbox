<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigCampaniaController extends Controller
{

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'campanias.';

    /**
     * View path.
     */
    private $view_path = 'campanias.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'campanias';

    /**
     * Title of this crud.
     */
    private $title = 'Configuración de Mensajes Citas';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'Configuración de Mensajes Citas';


       /**
     * Auth checker function for the crud.
     */
    private function authChecker()
    {
        $this->ownerAndStaffOnly();
    }


public function index(Request $request)
{
 
   $this->authChecker();

 
    return view($this->view_path . 'index', [
       
        'setup' => [
            'title'          =>$this->titlePlural,
            'iscontent'      => true,
           
             
            'item_names'     => $this->titlePlural,
            'webroute_path'  => $this->webroute_path,
            'fields'         => [],
            'custom_table'   => true,
            'parameter_name' => $this->parameter_name,
            'parameters'     => $request->query->count() !== 0,
 
            
        ],
    ]);
}

  
}
