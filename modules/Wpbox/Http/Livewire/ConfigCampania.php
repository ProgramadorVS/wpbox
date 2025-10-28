<?php

namespace App\Modules\Wpbox\Http\Livewire;

use Livewire\Component;
use App\Models\Company; 
use Modules\Wpbox\Models\Campaign; 

class ConfigCampania extends Component
{
    public $company;
    public $campania;
    
    // IDs de templates seleccionados
    public $selectedCitaAgenda = null;
    public $selectedCitaRecuerda = null;
    public $selectedCitaCancela = null;
    public $selectedCitaOk = null;
    
    // Estados actuales (1 o 0)
    public $citaAgendaActive = 0;
    public $citaRecuerdaActive = 0;
    public $citaCancelaActive = 0;
    public $citaOkActive = 0;

    public function mount($companyId = null)
    {
        // Si no se pasa companyId, usar el de la sesión
        $companyId = $companyId ?? auth()->user()->company_id;
        
        $this->company = Company::find($companyId);
        
        
        $this->campania = Campaign::where('company_id', $companyId)->get();
        
        // Cargar estados actuales de la campaña
        $this->citaAgendaActive = $this->campania->cita_agenda ?? 0;
        $this->citaRecuerdaActive = $this->campania->cita_recuerda ?? 0;
        $this->citaCancelaActive =$this->campania->cita_cancela ?? 0;
        $this->citaOkActive = $this->campania->cita_ok ?? 0;
        
    
    }


    public function render()
    {
        return view('modules.wpbox.livewire.config-campania');
    }
}