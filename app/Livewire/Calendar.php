<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;
 

class Calendar extends Component 
    // Este método se ejecuta automáticamente cuando cambia state.doctor_id
{
     public $companyLabels = [];
    // Note: toggle-asiste handled via plain JS/fetch now, not via Livewire listener.

     public function mount()
    {
            // Obtener labels personalizados solo una vez
        // Si no hay sesión activa, redirigimos al login para evitar errores al acceder a auth()->user()
        if (!auth()->check()) {
            // En Livewire, redirigir desde mount se hace con redirect()->route()
            redirect()->route('login');
            return;
        }

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
    public function render()
    {
        return view('livewire.calendar' );
    }

    





}