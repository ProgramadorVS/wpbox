<?php

namespace App\Livewire\Appointments;

use Livewire\Attributes\On;
use App\Models\Appointment;

use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use App\Models\Doctor;
use Carbon\Carbon;
use Modules\Contacts\Models\Contact;
use Modules\Wpbox\Models\Campaign;
use App\Traits\AppointmentMessageTrait;
 

class Create extends Component
{
    use AppointmentMessageTrait;

 public $companyLabels = [];
       public $state = [
        'doctor_id' => '',
        'contact_id' => '',
        'fecha' => '',
        'hora' => '',
        'horafin' => '',
        'note' => '',
        'status_id' => 1 // Valor por defecto
    ];

    public $doctor_id = null;
    public $contactSearch = '';
    public $contactResults = [];
    public $showContactResults = false;
    public $selectedContact = null;
     
 
 

// cuando se le da clic en el calendario
#[On('setSlotDateTime')]
public function setSlotDateTime($fecha = null, $hora = null)
{
    $this->state['fecha'] = $fecha;
    $this->state['hora']  = $hora;

    $horaInicio = \Carbon\Carbon::createFromFormat('H:i', $hora);
    $this->state['horafin'] = $horaInicio->copy()->addMinutes(20)->format('H:i');

}


#[On('eliminar-cita')]
public function eliminarCita($id = null)
{
    
    if ($id) {
            try {
                $cita = Appointment::findOrFail($id);
                $cita->delete();
                   $this->dispatch('cita-creada');
                $this->dispatch('notify', type: 'success', message: 'Cita eliminada correctamente.');
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() == '23000') {
                       $this->dispatch('cita-creada');
                    $this->dispatch('notify', type: 'error', message: 'No se puede eliminar la cita porque tiene mensajes relacionados.');
                } else {
                       $this->dispatch('cita-creada');
                    $this->dispatch('notify', type: 'error', message: 'Error al eliminar la cita.');
                }
            } catch (\Exception $e) {
                   $this->dispatch('cita-creada');
                $this->dispatch('notify', type: 'error', message: 'Error al eliminar la cita.');
            }
    }
}


// cuando se cierra el calendario se tiene que limpiar los controles
#[On('reset-form')]
public function resetForm()
{
    $this->state['contact_id'] = '';
    $this->state['note'] = '';
    $this->state['status_id'] = 1; // Valor por defecto

    $this->contactSearch = '';
    $this->contactResults = [];
    $this->showContactResults = false;
    $this->selectedContact = null;
    $this->resetErrorBag();
    $this->clearValidation();
}


// cuando cambia el campo de hora para agregar 20 min
public function updatedStateHora($value)
{
    if (!empty($value)) {
        // Convertir a objeto DateTime
        $horaInicio = \Carbon\Carbon::createFromFormat('H:i', $value);

        // Sumar 20 minutos
        $horaFin = $horaInicio->addMinutes(20)->format('H:i');

        // Actualizar el modelo
        $this->state['horafin'] = $horaFin;
    }
}

// evento load por primera vez
public function mount($fecha = null, $hora = null)
{
    $this->state['doctor_id'] = Doctor::first()->id ?? null;

    if ($fecha) $this->state['fecha'] = $fecha;
    if ($hora) $this->state['hora'] = $hora;

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
}

#[On('setDoctorId')]
public function setDoctorId($doctor_id)
{
        $this->state['doctor_id'] = $doctor_id;
}

//cuando se cambia el paciente
public function updatedContactSearch($value)
{
    $value = trim($value);
    
    if (strlen($value) > 2) {
        $this->contactResults = Contact::where('name', 'like', '%' . $value . '%')
            ->orderBy('name')
            ->limit(100)
            ->get()
            ->toArray();

        $this->showContactResults = count($this->contactResults) > 0;
    } else {
        $this->contactResults = [];
        $this->showContactResults = false;
    }
}

public function selectContact($contactId)
{
    $this->selectedContact = Contact::find($contactId);
    $this->state['contact_id'] = $contactId;
    $this->contactSearch = $this->selectedContact->name;
    $this->showContactResults = false;

    if ($this->selectedContact->esprimeravez == 1) {
        $this->state['note'] = "PRIMERA VEZ " . $this->state['note']  ;
    }
   
}


    public function clearContact()
    {
        $this->state['contact_id'] = '';
        $this->selectedContact = null;
        $this->contactSearch = '';
    }

#[On('crear-cita')]
    public function create()
    {

      
        // Validación manual con mensajes personalizados
        $validator = Validator::make($this->state, [
            'doctor_id' => 'required',
            'contact_id' => 'required|exists:contacts,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'horafin' => 'required',
            'note' => 'nullable',
        ], [
            // Mensajes personalizados
            'doctor_id.required' => 'El campo Doctor es obligatorio.',
            'contact_id.required' => 'El campo Paciente es obligatorio.',
            'contact_id.exists' => 'El paciente seleccionado no es válido.',
            'fecha.required' => 'El campo Fecha es obligatorio.',
            'fecha.date' => 'La fecha debe tener un formato válido.',
            'hora.required' => 'El campo Hora de inicio es obligatorio.',
            'horafin.required' => 'El campo Hora de fin es obligatorio.',
        ]);


            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $this->addError('state.datos', $error);
                }
                return;
            }


        // if ($validator->fails()) {
        //      $this->addError('state.datos', 'Por favor complete todos los campos requeridos..');
        //    // sale abajo ya no sirve $this->dispatch('notify', type: 'error', message: 'Por favor complete todos los campos requeridos.');
        //     return;
        // }

        // Validar conflicto de citas
        $exists = Appointment::where('doctor_id', $this->state['doctor_id'])
            ->where('fecha', $this->state['fecha'])
            ->where('hora', $this->state['hora'])
            ->where('status_id', '<>', 3) // cancelado
            ->exists();

        if ($exists) {
                $this->addError('state.hora', 'Ya existe una cita agendada para este doctor a esa hora.');
          // sale abajo ya no sirve       $this->dispatch('notify', type: 'error', message: 'Ya existe una cita agendada para este doctor a esa hora.');
                return;
        }

        Appointment::create($this->state);

    $this->dispatch('cita-creada');

        $this->dispatch('notify',
        type: 'success',
        message: 'Cita creada exitosamente'
         );

 




    }


public function render()
{
    $data = [
      //  'contacts' => Contact::orderBy('name', 'asc')->get(),
        'doctors' => Doctor::orderBy('name')->get()
    ];

    return view('livewire.appointments.create', $data);
}


// PARA MANDAR MENSAJE
//dando clic en el boton de whats
// FUNCION QUE SE MANDA DESDE LA VISTA PARA MANDAR MENSAJE ( SE AGREGA EN LA TABLA )
    #[On('mandar-whats')]
    public function mandarWhats($id)
    {           
      try {

            // AQUI PARA AGREGAR EL MENSAJE DE AGENDADO      
            // validacion de que existan las plantillas y campañas automaricas
            if (Campaign::hasCitaAgenda()) {
                $campaña_id  = Campaign::getCitaAgendaIdSafe();
                // Proceder con la lógica
            } else {
                // No hay campaña configurada
                $this->dispatch('cita-creada'); // PARA CERRAR EL MODAL
                $this->dispatch('notify', type: 'error', message: 'No existe plantilla.- Configure una campaña para mensajes de Aviso de Agenda');
                return;
            }



         // aqui para agregar el RECORDATORIO
            if (Campaign::hasCitaRecuerda()) {
                $campaña_Recorda_id  = Campaign::getCitaRecuerdaIdSafe();
                // Proceder con la lógica
            } else {
                // No hay campaña configurada
                $this->dispatch('cita-creada'); // PARA CERRAR EL MODAL
                $this->dispatch('notify', type: 'error', message: 'No existe plantilla.- Configure una campaña para mensajes de Recordatorio de Cita');
                return;
            }
            // fin de la validación

       
       // manda a llamar a la funcion desde un TRAIT que es como un modulo generico para tener funciones esta en 
       //app/Traits/AppointmentMessageTrait.php
        // este mensaje se manda en automatico sin cron ni nada
        $this->AgregarMensaje($id, $campaña_id, 1); // de agenda

        //este se cambia por un cron que debe de estar en el server por cada hora que apunta a sendSchuduledMessagesConfirm
        $this->AgregarMensaje($id, $campaña_Recorda_id, 2);  // de recordatorio
           


     $this->dispatch('cita-creada'); // PARA CERRAR EL MODAL

        $this->dispatch('notify',
        type: 'success',
        message: 'El mensaje ha sido enviado.'
        );



       
        
    } catch (\Exception $e) {
        $this->dispatch('cita-creada'); // PARA CERRAR EL MODAL
        $this->dispatch('notify', type: 'error', message: 'Error al enviar el mensaje: ' . $e->getMessage());
    }
}





}
