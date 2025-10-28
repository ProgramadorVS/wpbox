<?php

namespace App\Livewire\Appointments;

 
use App\Models\Appointment;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Doctor; // Asegúrate de importar el modelo Doctor

 

class AppointmentList extends Component
{ 
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $status_id = null;
    public $doctor_id = null;
    public $asiste = null;
    public $fecha = null;
    public $fecha_fin = null;
    public $contact_name = ''; // Nuevo campo para búsqueda por nombre

    protected $queryString = ['status_id', 'doctor_id', 'fecha', 'contact_name','asiste'];  // Agregamos los nuevos parámetros

  
    public function getEstadoAgenda($whatscita_agenda)
    {
        $estados = [
            0 => ['label' => 'Mandado', 'class' => 'badge-warning'],
            1 => ['label' => 'Mandando', 'class' => 'badge-warning'],
            2 => ['label' => 'Enviado', 'class' => 'badge-dark'],
            3 => ['label' => 'Entregado', 'class' => 'badge-info '],
            4 => ['label' => 'Leido', 'class' => 'badge-success'],
            5 => ['label' => 'Error', 'class' => 'badge-danger'],
            6 => ['label' => 'Contestado', 'class' => 'badge-dark'],
            7 => ['label' => 'En Espera', 'class' => 'badge-light text-dark'],
            8 => ['label' => 'N/A', 'class' => 'badge-light text-dark'],
        ];

        return $estados[$whatscita_agenda] ?? ['label' => 'Desconocido', 'class' => 'badge bg-secondary'];
    }
 


    public function getEstadoConfirma($whatscita_confirma)
    {
        $estados = [
            0 => ['label' => 'En Espera', 'class' => 'badge-primary'],
            1 => ['label' => 'Mandando', 'class' => 'badge-warning'],
            2 => ['label' => 'Mandado', 'class' => 'badge-dark'],
            3 => ['label' => 'Entregado', 'class' => 'badge-info '],
            4 => ['label' => 'Leido', 'class' => 'badge-info'],
            5 => ['label' => 'Error', 'class' => 'badge-danger'],
            6 => ['label' => 'Contestado', 'class' => 'badge-success'],
            7 => ['label' => 'Pendiente', 'class' => 'badge-light text-dark'],
            8 => ['label' => 'N/A', 'class' => 'badge-light text-dark'],
        ];

        return $estados[$whatscita_confirma] ?? ['label' => 'Desconocido', 'class' => 'badge bg-secondary'];
    }


    public function mount()
    {
        if (!$this->fecha) {
            // Obtener el lunes de la semana actual
            $this->fecha = now()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        }
        if (!$this->fecha_fin) {
            // Obtener el domingo de la semana actual
            $this->fecha_fin = now()->endOfWeek(Carbon::SUNDAY)->format('Y-m-d');
        }
    }


    public function updated($property)
    {
        if (in_array($property, ['status_id', 'doctor_id', 'fecha','fecha_fin', 'contact_name','asiste'])) {
            $this->resetPage();
        }
    }

 
     public function clearFilters()
    {
        $this->reset(['status_id', 'doctor_id', 'fecha', 'fecha_fin','contact_name','asiste']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Appointment::with('doctor', 'contact')
            ->when($this->status_id, function ($query, $status_id) {
                return $query->where('status_id', $status_id);
            })
            ->when($this->doctor_id, function ($query, $doctor_id) {
                return $query->where('doctor_id', $doctor_id);
            })
            ->when($this->fecha && $this->fecha_fin, function ($query) {
                return $query->whereBetween('fecha', [$this->fecha, $this->fecha_fin]);
            })
            ->when($this->contact_name, function ($query, $name) {
                return $query->whereHas('contact', function($q) use ($name) {
                    $q->where('name', 'like', '%'.$name.'%');
                });
            })
            ->when(is_numeric($this->asiste), function ($query) {
                return $query->where('asiste', $this->asiste);
            })
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc');


        $data['appointments'] = $query->paginate(10);

        // Totales considerando todos los filtros excepto status
        $filteredQuery = clone $query;
        $data['appointmentCount'] = $filteredQuery->count();
        $data['appointmentScheduledCount'] = $filteredQuery->clone()->where('status_id', 1)->count();
        $data['appointmentConfirmCount'] = $filteredQuery->clone()->where('status_id', 2)->count();
        $data['appointmentCanceledCount'] = $filteredQuery->clone()->where('status_id', 3)->count();
        
        $data['doctors'] = Doctor::orderBy('name')->get();

        // Obtener la compañía actual 
        $company = auth()->user()->company ;
     
        $data['companyLabels'] = [
            'label_contact_name_full' => $company->getConfig('label_contact_name_full', 'NOMBRE DEL PACIENTE'),
            'label_contact_name_singular' => $company->getConfig('label_contact_name_singular', 'PACIENTE'),
            'label_contact_name_plural' => $company->getConfig('label_contact_name_plural', 'PACIENTES'),
            'label_responsable_name_full' => $company->getConfig('label_responsable_name_full', 'NOMBRE DEL DOCTOR'),
            'label_responsable_name_singular' => $company->getConfig('label_responsable_name_singular', 'DOCTOR'),
            'label_responsable_name_plural' => $company->getConfig('label_responsable_name_plural', 'DOCTORES'),
            // Puedes agregar más labels aquí si lo requieres
        ];
        //asi se pasa el valor en la vista {{ $companyLabels['label_contact_name_full'] }}
 
        return view('livewire.appointments.appointment-list', $data);
    }

}
