<?php

namespace App\Livewire\Appointments;

use Livewire\Attributes\On;
use App\Models\Appointment;
use Modules\Contacts\Models\Contact;
use Modules\Wpbox\Models\Campaign;
use Livewire\Component;
use App\Models\Doctor;
use App\Traits\AppointmentMessageTrait;


class Update extends Component
{
    use AppointmentMessageTrait;

    public $companyLabels = [];
    public $state = [];
    public $appointment;
    public $fecha;
    public $hora;
    public $horafin;
    public $status_id;
    public $note;
    public $contact_id;
    public $doctor_id;
    public $appointmentId;
    public $contactSearch = '';
    public $contactResults = [];
    public $selectedContact = null;
    public $showContactResults = false;
    public $soloEstadoEditable = false;





#[On('setSoloEstadoEditable')]
public function setSoloEstadoEditable($value)
{
    $this->soloEstadoEditable = $value ;
}


    #[On('reset-form-editar')]
    public function resetForm()
    {
        $this->appointment = null;
        $this->fecha = '';
        $this->hora = '';
        $this->horafin = '';
        $this->status_id = 1;
        $this->note = '';
        $this->contact_id = '';
        $this->contactSearch = '';
        $this->contactResults = [];
        $this->showContactResults = false;
        $this->selectedContact = null;
        $this->resetErrorBag();
        $this->clearValidation();
    }


#[On('setDoctorIdUpdate')]
public function setDoctorIdUpdate($doctor_id)
{
        $this->doctor_id = $doctor_id;
}

    
    #[On('setEditingAppointment')]
    public function setEditingAppointment($appointmentId)
    {
        try {
            $this->mount($appointmentId); // Vuelve a cargar los datos del appointment
        } catch (\Exception $e) {
            $this->appointment = null;
            $this->dispatch('notify', type: 'error', message: 'La cita no existe o fue eliminada.');
        }
    }

    
    public function mount($appointmentId)
    {
            // Obtener labels personalizados solo una vez
        $company = auth()->user()->company;
        $this->companyLabels = [
            'label_contact_name_full' => $company?->getConfig('label_contact_name_full', 'NOMBRE DEL PACIENTE'),
            'label_contact_name_singular' => $company?->getConfig('label_contact_name_singular', 'PACIENTE'),
            'label_contact_name_plural' => $company?->getConfig('label_contact_name_plural', 'PACIENTES'),
            'label_responsable_name_full' => $company?->getConfig('label_responsable_name_full', 'NOMBRE DEL DOCTOR'),
            'label_responsable_name_singular' => $company?->getConfig('label_responsable_name_singular', 'DOCTOR'),
            'label_responsable_name_plural' => $company?->getConfig('label_responsable_name_plural', 'DOCTORES'),
        ];
        $this->appointmentId = $appointmentId;
        $appointment = Appointment::find($appointmentId);
        if (!$appointment) {
            $this->appointment = null;
            $this->fecha = null;
            $this->hora = null;
            $this->horafin = null;
            $this->status_id = null;
            $this->note = null;
            $this->contact_id = null;
            
            $this->contactSearch = '';
            //$this->dispatch('notify', type: 'error', message: 'La cita no existe o fue eliminada.');
            return;
        }
        $this->appointment = $appointment;
        $this->fecha = $appointment->fecha;
        $this->hora = $appointment->hora;
        $this->horafin = $appointment->horafin;
        $this->status_id = $appointment->status_id;
        $this->note = $appointment->note;
        $this->contact_id = $appointment->contact_id;
        $this->doctor_id = $appointment->doctor_id;
        $contact = Contact::find($appointment->contact_id);
        $this->contactSearch = $contact ? $contact->name : '';
    }


 

 


    public function selectContact($contactId)
{
    $this->contact_id = $contactId;
    $this->selectedContact = Contact::find($contactId);
    $this->state['contact_id'] = $contactId;
    $this->contactSearch = $this->selectedContact->name;
    $this->showContactResults = true;

        if ($this->selectedContact->esprimeravez == 1 && empty($this->note)) {
            $this->note = "PRIMERA VEZ ";
        }
}


public function updatedContactSearch($value)
{
    if (strlen($value) > 2) {
        $this->contactResults = Contact::where('name', 'like', '%' . $value . '%')
            ->orderBy('name')
            ->limit(100)
            ->get()
            ->toArray();

        // Siempre mostrar el listado al escribir, aunque ya haya un valor seleccionado
        $this->showContactResults = true;
    } else {
        $this->contactResults = [];
        $this->showContactResults = false;
    }
}



#[On('modificar-cita')]
public function update()
{
    $validatedData = $this->validate([
        'fecha' => 'required|date',
        'hora' => 'required',
        'horafin' => 'nullable',
        'status_id' => 'required|in:1,2,3',
        'note' => 'nullable',
        'contact_id' => 'required|exists:contacts,id',
        'doctor_id' => 'required|exists:doctores,id',
    ]);

    // Guardar el status anterior antes de actualizar
    $statusAnterior = $this->appointment->status_id;
    
    $this->appointment->update($validatedData);

    // Solo procesar cambios si realmente cambió el status
    if ($statusAnterior != $this->status_id) {
        $this->procesarCambioStatus($this->status_id);
    }

    $this->resetForm();
    $this->dispatch('close-modal-editar');
    $this->dispatch('cita-modificada');

    $this->dispatch('notify',
        type: 'success',
        message: 'Cita modificada éxitosamente'
    );
}

private function procesarCambioStatus( $statusNuevo)
{



    // se crea el mensaje de  CANCELACION  y se manda si es 3 el nuevo status
    if ($statusNuevo == 3) {
        // Si la cita se cancela, mandar mensaje de cancelación
         
        $this->mandarWhatsCancela($this->appointmentId);
    }

    // Procesar mensajes de AGENDA
    $this->actualizarMensajesAgenda($statusNuevo);
    
    // Procesar mensajes de CONFIRMACION  
    $this->actualizarMensajesConfirmacion($statusNuevo);


}

private function actualizarMensajesAgenda($statusNuevo)
{
    $messages = \Modules\Wpbox\Models\Message::where('cita_id', $this->appointment->id)
        ->where('es_cita_agenda', 1);

    if ($messages->exists()) {
        // si la cita se cancela y el estado de confirma es 0, cambiar el estado del mensaje a 8
        if ($statusNuevo == 3) {
            $messages->whereIn('status', [0, 7])->update(['status' => 8]);
        }
        // si la cita se pone agendada, cambiar el estado del mensaje a 0
        elseif ($statusNuevo == 1) {
            $messages->whereIn('status', [7, 8])->update(['status' => 0]);
        }
        // si la cita se pone confirmada entonces cambiar el estado del mensaje a 8
        elseif ($statusNuevo == 2) {
            $messages->whereIn('status', [0, 7])->update(['status' => 8]);
        }
    } else {
        // si no existe mensaje, actualizar directamente en la cita
        if ($statusNuevo == 3) {
            if (in_array($this->appointment->whatscita_agenda, [0, 7])) {
                $this->appointment->update(['whatscita_agenda' => 8]);
            }
        }
        elseif ($statusNuevo == 1) {
            if (in_array($this->appointment->whatscita_agenda, [8, 7])) {
                $this->appointment->update(['whatscita_agenda' => 7]);
            }
        }
        elseif ($statusNuevo == 2) {
            if (in_array($this->appointment->whatscita_agenda, [0, 7])) {
                $this->appointment->update(['whatscita_agenda' => 8]);
            }
        }
    }
}

private function actualizarMensajesConfirmacion($statusNuevo)
{
    $messages = \Modules\Wpbox\Models\Message::where('cita_id', $this->appointment->id)
        ->where('es_cita_confirma', 1);

    if ($messages->exists()) {
        if ($statusNuevo == 3) {
            $messages->whereIn('status', [0, 7])->update(['status' => 8]);
        }
        elseif ($statusNuevo == 1) {
            $messages->whereIn('status', [7, 8])->update(['status' => 0]);
        }
        elseif ($statusNuevo == 2) {
            $messages->whereIn('status', [0, 7])->update(['status' => 8]);
        }
    } else {
        if ($statusNuevo == 3) {
            if (in_array($this->appointment->whatscita_confirma, [0, 7])) {
                $this->appointment->update(['whatscita_confirma' => 8]);
            }
        }
        elseif ($statusNuevo == 1) {
            if (in_array($this->appointment->whatscita_confirma, [8, 7])) {
                $this->appointment->update(['whatscita_confirma' => 7]);
            }
        }
        elseif ($statusNuevo == 2) {
            if (in_array($this->appointment->whatscita_confirma, [0, 7])) {
                $this->appointment->update(['whatscita_confirma' => 8]);
            }
        }
    }
}


public function updatedHora($value)
{
    if (!empty($value)) {
        // Convertir a objeto DateTime
        $horaInicio = \Carbon\Carbon::createFromFormat('H:i', $value);
        
        // Sumar 20 minutos
        $horaFin = $horaInicio->addMinutes(20)->format('H:i');
        
        // Actualizar el modelo
        $this->horafin = $horaFin;
    }
}

    public function render()
    {
 
        // Si el campo de búsqueda tiene foco, asegúrate de mostrar el listado
        if (strlen($this->contactSearch) > 2) {
            $this->showContactResults = true;
        }

        return view('livewire.appointments.update', [
            'appointment' => $this->appointment,
            'contacts' => Contact::all(),
            'doctors' => Doctor::all(),
          
        ]);
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
                $this->dispatch('cita-creada'); // PARA CERRAR EL MODAL
                $this->dispatch('notify', type: 'error', message: 'No existe plantilla.- Configure una campaña para mensajes de CANCELACIÓN de Agenda');
                return;
            }
       
       // manda a llamar a la funcion desde un TRAIT que es como un modulo generico para tener funciones esta en 
       //app/Traits/AppointmentMessageTrait.php
        // este mensaje se manda en automatico sin cron ni nada
      
        $this->AgregarMensaje($id, $campaña_id, 3); // ES CANCELACION

 
       
        
    } catch (\Exception $e) {
        $this->dispatch('cita-creada'); // PARA CERRAR EL MODAL
        $this->dispatch('notify', type: 'error', message: 'Error al enviar el mensaje de CANCELACIÓN: ' . $e->getMessage());
    }
}


}