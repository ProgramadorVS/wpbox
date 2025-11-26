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
        'status_id' => 1, // Valor por defecto para 'Agendada'
        'tipocita' => 1 // Valor por defecto para 'CITA'
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

    // $horaInicio = \Carbon\Carbon::createFromFormat('H:i', $hora);
    // $this->state['horafin'] = $horaInicio->copy()->addMinutes(20)->format('H:i');
        if ($hora) {
                $carbonHora = \Carbon\Carbon::createFromFormat('H:i', $hora);

                // 1. Calcular hora fin (+20 min)
                $this->state['horafin'] = $carbonHora->copy()->addMinutes(20)->format('H:i');

                // 2. Asignar tipo de cita basado en la hora (0-23)
                $this->state['tipocita'] = match ($carbonHora->hour) {
                    14 => 2, // 14:00 - 14:59 -> Alergoide
                    15 => 3, // 15:00 - 15:59 -> Acuosa
                    16 => 4, // 16:00 - 16:59 -> Oral
                    default => 1, // Cualquier otra hora -> Normal
                };
            }
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
   // $this->state['tipocita'] = 1; // Resetear a su valor por defecto YA NO SE USA PORQUE SE PUSO AL CLIC DEL CALENDARIO ALGO MAS RAPIDO
    $this->state['status_id'] = 1; // Valor por defecto

    $this->contactSearch = '';
    $this->contactResults = [];
    $this->showContactResults = false;
    $this->selectedContact = null;
    $this->resetErrorBag();
    $this->clearValidation();

    // Emitir un evento para actualizar el texto del botón
   // $this->dispatch('updateButtonText', ['text' => 'CREAR CITA NORMAL']);// Resetear a su valor por defecto YA NO SE USA PORQUE SE PUSO AL CLIC DEL CALENDARIO ALGO MAS RAPIDO
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
    $this->state['tipocita'] = 1;

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
            'tipocita' => 'required|in:1,2,3,4',
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
            'tipocita.required' => 'Debe seleccionar un tipo de cita.',
        ]);


            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $this->addError('state.datos', $error);
                }
                return;
            }


// switch ($this->state['tipocita']) {
    
//     case 2: // ALERGOIDE
//         $this->state['hora'] = '14:00';
//         $this->state['horafin'] = '14:20';
//         break;
//     case 3: // ACUOSA
//         $this->state['hora'] = '15:00';
//         $this->state['horafin'] = '15:20';
//         break;
//     case 4: // ORAL
//         $this->state['hora'] = '16:00';
//         $this->state['horafin'] = '16:20';
//         break;
//     default:
         
//         break;
// }

//PROCESO PARA PONER LAS VACUNAS EN EL HORARIO INDICADO CON EL CICLO DE 3 CITAS
// 1. Definimos las horas base por tipo de cita en un array para evitar múltiples 'case'
$baseHours = [
    2 => '14:00', // Alergoide
    3 => '15:00', // Acuosa
    4 => '16:00', // Oral
];

// Solo procedemos si el tipo seleccionado está en nuestra configuración (ignora tipo 1)
if (isset($baseHours[$this->state['tipocita']])) {

    // Validar que tengamos fecha antes de consultar
    if (empty($this->state['fecha'])) {
        // Opcional: Manejar error o asignar fecha hoy por defecto
        return; 
    }

    // 2. Contamos cuántas citas de ESTE tipo existen ya en ESA fecha
    $count = Appointment::whereDate('fecha', $this->state['fecha'])
                ->where('tipocita', $this->state['tipocita'])
                ->count();

    // 3. Lógica del Ciclo (Módulo 3)
    // El operador % 3 hará esto:
    // Si hay 0 citas: 0 % 3 = 0  -> Sumar 0 min
    // Si hay 1 cita:  1 % 3 = 1  -> Sumar 20 min
    // Si hay 2 citas: 2 % 3 = 2  -> Sumar 40 min
    // Si hay 3 citas: 3 % 3 = 0  -> Sumar 0 min (Reinicia el ciclo)
    $slotIndex = $count % 3; 
    $minutesToAdd = $slotIndex * 20;

    // 4. Calculamos la hora exacta
    $horaBase = Carbon::createFromFormat('H:i', $baseHours[$this->state['tipocita']]);
    
    $horaInicio = $horaBase->copy()->addMinutes($minutesToAdd);
    $horaFin = $horaInicio->copy()->addMinutes(20);

    // 5. Asignamos al estado
    $this->state['hora'] = $horaInicio->format('H:i');
    $this->state['horafin'] = $horaFin->format('H:i');
}






 // si la cita es de tipo vacuna se asigna hora fija y no se valida duplicidad
      if ($this->state['tipocita'] > 1) {

                    // Validar conflicto de citas solo de la MISMA
                $exists = Appointment::where('doctor_id', $this->state['doctor_id'])
                    ->where('fecha', $this->state['fecha'])
                     
                    ->where('contact_id', $this->state['contact_id'])
                    ->where('tipocita', $this->state['tipocita'])   
                    ->exists();

                if ($exists) {
                       
                         // se sale si encuentra un duplicado ( por si  se manda 2 veces el codigo)
                        return;
                }

        }// si la cita es normal si se valida duplicidad
        else {
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
//dando clic en el boton de whats, pasando el id de la cita
// FUNCION QUE SE MANDA DESDE LA VISTA PARA MANDAR MENSAJE ( SE AGREGA EN LA TABLA )
    #[On('mandar-whats')]
    public function mandarWhats($id)
    {       
        
        // OBTENGO EL tipocita de LA CITA donde 
        //1 es normal y lo demas es vacuna
        // entonces si es normal checo si existe la plantilla con hasCitaAgenda
        // si es vacuna checo si existe la plantilla con hasCitaVacuna

         $tipocita = Appointment::where('id', $id)->value('tipocita');

      try {
        if ($tipocita == 1) {
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
         }else{

             if (Campaign::hasCitaVacuna()) {
                        $campaña_id  = Campaign::getCitaAgendaVacunaIdSafe();
                        // Proceder con la lógica
                    } else {
                        // No hay campaña configurada
                        $this->dispatch('cita-creada'); // PARA CERRAR EL MODAL
                        $this->dispatch('notify', type: 'error', message: 'No existe plantilla.- Configure una campaña para mensajes de Aviso de Vacuna');
                        return;
                    }

                    
                // aqui para agregar el RECORDATORIO
                    if (Campaign::hasCitaRecuerdaVacuna()) {
                        $campaña_Recorda_id  = Campaign::getCitaAgendaVacunaIdSafe();
                        // Proceder con la lógica
                    } else {
                        // No hay campaña configurada
                        $this->dispatch('cita-creada'); // PARA CERRAR EL MODAL
                        $this->dispatch('notify', type: 'error', message: 'No existe plantilla.- Configure una campaña para mensajes de Recordatorio de Cita');
                        return;
                    }
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
