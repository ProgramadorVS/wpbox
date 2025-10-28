<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
 
use Illuminate\Http\Request;
 
use App\Models\Appointment;
 
 
 
 

class AppointmentsController extends Controller
{
 

    /**
     * Provide class.
     */
    private $provider = Appointment::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'appointments.';

    /**
     * View path.
     */
    private $view_path = 'appointments.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'appointments';

    /**
     * Title of this crud.
     */
    private $title = 'Cita';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'Citas';


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
            'title'          => __('crud.item_managment', ['item' => __($this->titlePlural)]),
            'iscontent'      => true,
            'action_link'    => route('dashboard'),
            'action_name'    => ' ← '. __('Dashboard') ,
             
            'item_names'     => $this->titlePlural,
            'webroute_path'  => $this->webroute_path,
            'fields'         => [],
            'custom_table'   => true,
            'parameter_name' => $this->parameter_name,
            'parameters'     => $request->query->count() !== 0,
 
            
        ],
    ]);
}


public function create()
{
    return view($this->view_path . 'create', [
        'setup' => [
            'title'          => __( 'Crear Cita'),
            'iscontent'      => true,
             'action_link'    => route($this->webroute_path . 'index'),
            'action_name'    =>  ' ← '. __('Listado de Citas'),
            'item_names'     => $this->titlePlural,
            'webroute_path'  => $this->webroute_path,
            'fields'         => [],
            'custom_form'    => true,
            'parameter_name' => $this->parameter_name,
        ],
    ]);

    
}


public function edit(Appointment $appointment)
{
    return view($this->view_path . 'edit', [
        'setup' => [
            'title'          => __('Editar Cita'),
            'iscontent'      => true,
            'action_link'    => route($this->webroute_path . 'index'),
            'action_name'    => ' ← ' . __('Listado de Citas'),
            'item_names'     => $this->titlePlural,
            'webroute_path'  => $this->webroute_path,
            'fields'         => [],
            'custom_form'    => true,
            'parameter_name' => $this->parameter_name,
            
        ],
        'appointment' => $appointment, // Para compatibilidad con vistas que esperan $appointment
    ]);
}
}