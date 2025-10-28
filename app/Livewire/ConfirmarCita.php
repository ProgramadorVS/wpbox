<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Company;
use App\Models\Appointment;
use Livewire\Attributes\On;
use Modules\Wpbox\Models\Message;
use Modules\Wpbox\Models\Campaign;
use App\Traits\AppointmentMessageTrait;

class ConfirmarCita extends Component
{

    use AppointmentMessageTrait;

    public $token;
    public $cita;
    public $estado = 'pendiente'; // pendiente, confirmada, cancelada
    public $mensaje = '';
    public $loading = false;
    public $companyLabels = [];
    public  $appointment;


    public function mount($token)
    {
         $this->token =   $token  ;
         $this->cargarDatosCita();
    }

    public function cargarDatosCita()
    {
        try {

            $token = $this->token;

            $this->appointment = Appointment::where('citacodigo', $token)->first();

            $company = Company::findOrFail( $this->appointment->company_id);
            
            $this->companyLabels = [
                'label_contact_name_full' => $company?->getConfig('label_contact_name_full', 'NOMBRE DEL PACIENTE'),
                'label_contact_name_singular' => $company?->getConfig('label_contact_name_singular', 'PACIENTE'),
                'label_contact_name_plural' => $company?->getConfig('label_contact_name_plural', 'PACIENTES'),
                'label_responsable_name_full' => $company?->getConfig('label_responsable_name_full', 'NOMBRE DEL DOCTOR'),
                'label_responsable_name_singular' => $company?->getConfig('label_responsable_name_singular', 'DOCTOR'),
                'label_responsable_name_plural' => $company?->getConfig('label_responsable_name_plural', 'DOCTORES'),
                'label_pie_pagina_confirma_cita' => $company?->getConfig('label_pie_pagina_confirma_cita', 'Si tienes alguna pregunta, por favor contáctanos'),
                'label_pie_pagina_empresa' => $company?->getConfig('label_pie_pagina_empresa', 'Tu Empresa. Todos los derechos reservados.'),
            ];




            $this->cita = [
                'id' =>  $this->appointment->id,
                'paciente' =>  $this->appointment->contact->name,
                'fecha' =>  $this->appointment->fecha,
                'hora' =>  $this->appointment->hora,
                'doctor' =>  $this->appointment->doctor->name,
                'status_id' =>  $this->appointment->status_id,
                'company_id' =>  $this->appointment->company_id,
            ];
           
       // Combinar fecha y hora para crear un DateTime completo
            $fechaHoraCita = \Carbon\Carbon::parse($this->cita['fecha'] . ' ' . $this->cita['hora']);  


            // Verificar si la fecha y hora ya pasaron
            if ($fechaHoraCita->lt(now())) {
                        $this->estado = 'expirada';
                        $this->mensaje = 'Esta cita ya expiró. Por favor, contacta para agendar una nueva. ' .
                        $this->companyLabels['label_pie_pagina_confirma_cita'] . ' ' ; 
            } else {

                        $fecha=  \Carbon\Carbon::parse( $this->cita['fecha'])->locale('es')->translatedFormat('l j \d\e F \d\e Y');
                        
                    // 2 es confirmada , 3 es cancelada
                        if ($this->cita['status_id'] == 2) {
                            $this->estado = 'confirmada';
                                        $this->mensaje = '¡Cita confirmada exitosamente! Te esperamos el ' . 
                                        $fecha . ' a las ' . $this->cita['hora'] .  ' con el ' . 
                                        $this->companyLabels['label_responsable_name_singular'] . ' ' .
                                        $this->cita['doctor'] . '.' ;
                                    
                                    
                        } elseif ($this->cita['status_id'] == 3) {
                            $this->estado = 'cancelada';
                            $this->mensaje = 'Cita ya cancelada. ' ;
                            
                        }

                    }



        } catch (\Exception $e) {
           
            $this->cita = null;
        }
    }

  
    public function confirmarCita()
    {
        $this->loading = true;
        
       
    try { 
            // Actualizar en la tabla de citas 
            // status_id=2 
            // por usuario=1

            $this->appointment->update([
                'status_id' => 2,
                'porusuario' => 1,
                'porusuariofecha' => now()
            ]);


            // cambiar el status de los mensajes a contestado
              Message::where('cita_id',  $this->appointment->id )
                ->where('es_cita_confirma', 1)
                ->update([
                    'status' => 6,
                    'updated_at' => now(),
                    // otros campos que quieras actualizar
                ]);
          
          $fecha=  \Carbon\Carbon::parse( $this->cita['fecha'])->locale('es')->translatedFormat('l j \d\e F \d\e Y');
            
            $this->estado = 'confirmada';
            $this->mensaje = '¡Cita confirmada exitosamente! Te esperamos el ' . 
                            $fecha . ' a las ' . $this->cita['hora'] .  ' con el ' . 
                            $this->companyLabels['label_responsable_name_singular'] . ' ' .
                            $this->cita['doctor'] . '.' ;
                            
              // aqui mando mensaje de whats al cliente para que le diga que ok

                $this->mandarWhatsOk($this->appointment->id);

                // fin del mensaje
          
          
        } catch (\Exception $e) {
           
            $this->mensaje = 'Hubo un error al confirmar tu cita. Por favor, contacta con nosotros.';
        } finally {
            $this->loading = false;
        }
    }

    public function cancelarCita()
    {
        $this->loading = true;
        
         try {
            
             // Actualizar en la tabla de citas 
            // status_id=3  CANCELADO
            // por usuario=1

            $this->appointment->update([
                'status_id' => 3,
                'porusuario' => 1,
                'porusuariofecha' => now()
            ]);
                       
            
           // cambiar el status de los mensajes a contestado
              Message::where('cita_id',  $this->appointment->id )
                ->where('es_cita_confirma', 1)
                ->update([
                    'status' => 6,
                    'updated_at' => now(),
                    // otros campos que quieras actualizar
                ]);


                // aqui mando mensaje de whats al cliente para que le diga que se canceló

                $this->mandarWhatsCancela($this->appointment->id);

                // fin del mensaje

            $this->estado = 'cancelada';
            $mensaje = 'Cita cancelada correctamente. Si necesitas reagendar, contáctanos.';
            $this->mensaje = $mensaje;
            
           
        
            
        } catch (\Exception $e) {
         
            $this->mensaje = 'Hubo un error al cancelar tu cita. Por favor, contacta con nosotros.';
        } finally {
            $this->loading = false;
        }
    }





// PARA MANDAR MENSAJE
//dando clic en el boton de whats
// FUNCION QUE SE MANDA DESDE LA VISTA PARA MANDAR MENSAJE ( SE AGREGA EN LA TABLA )

    public function mandarWhatsCancela($id)
    {           
      try {

            // AQUI PARA AGREGAR EL MENSAJE DE AGENDADO      
            // validacion de que existan las plantillas y campañas automaricas
            if (Campaign::hasCitaCancela()) {
                $campaña_id  = Campaign::getCitaCancelaIdSafe();
                // Proceder con la lógica
            } else {
                // No hay campaña configurada
                
                $this->dispatch('notify', type: 'error', message: 'No existe plantilla.- Configure una campaña para mensajes de CANCELACIÓN de Agenda');
                
            }
       
       // manda a llamar a la funcion desde un TRAIT que es como un modulo generico para tener funciones esta en 
       //app/Traits/AppointmentMessageTrait.php
        // este mensaje se manda en automatico sin cron ni nada
      
        $this->AgregarMensaje($id, $campaña_id, 3); // ES CANCELACION

 
       
        
    } catch (\Exception $e) {
       
        $this->dispatch('notify', type: 'error', message: 'Error al enviar el mensaje de CANCELACIÓN por WHATSAPP: ' . $e->getMessage());
    }
}



// PARA MANDAR MENSAJE
//dando clic en el boton de whats
// FUNCION QUE SE MANDA DESDE LA VISTA PARA MANDAR MENSAJE ( SE AGREGA EN LA TABLA )

    public function mandarWhatsOk($id)
    {           
      try {

            // AQUI PARA AGREGAR EL MENSAJE DE AGENDADO      
            // validacion de que existan las plantillas y campañas automaricas
            if (Campaign::hasCitaOk()) {
                $campaña_id  = Campaign::getCitaOkIdSafe();
                // Proceder con la lógica
            } else {
                // No hay campaña configurada
                
                $this->dispatch('notify', type: 'error', message: 'No existe plantilla.- Configure una campaña para mensajes de OK de Agenda');
                
            }
       
       // manda a llamar a la funcion desde un TRAIT que es como un modulo generico para tener funciones esta en 
       //app/Traits/AppointmentMessageTrait.php
        // este mensaje se manda en automatico sin cron ni nada
      
        $this->AgregarMensaje($id, $campaña_id, 4); // ES OK

 
       
        
    } catch (\Exception $e) {
       
        $this->dispatch('notify', type: 'error', message: 'Error al enviar el mensaje de CANCELACIÓN por WHATSAPP: ' . $e->getMessage());
    }
}




// Nuevo método que escucha el evento del SweetAlert
    #[On('ejecutar-accion')]
    public function ejecutarAccion($accion)
    {
        if ($accion === 'confirmar') {
            $this->confirmarCita();
        } elseif ($accion === 'cancelar') {
            $this->cancelarCita();
        }
    }

    public function render()
    {
       
        return view('livewire.confirmar-cita' );
    }


    
}