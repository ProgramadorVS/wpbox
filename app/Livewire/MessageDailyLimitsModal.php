<?php
// Archivo: app/Livewire/MessageDailyLimitsModal.php

namespace App\Livewire;

use Livewire\Component;
use Modules\Wpbox\Models\MessageDailyLimit;
use App\Models\Company;

class MessageDailyLimitsModal extends Component
{

    public $limits = [];
    public $companyLabels = [];
    public $companyId;
    protected $listeners = ['openLimitsModal' => 'openModal'];

    public function mount()
    {
         $this->companyId = auth()->user()->company_id;
         $companyId = $this->companyId;
         
         $company = Company::findOrFail( $companyId);
            
            $this->companyLabels = [
                 'total_mensajes_dia' => $company?->getConfig('total_mensajes_dia', '200'),              
            ];

              
       
    }

 


    public function render()
    {
        $companyId = $this->companyId;
        
        $this->limits = MessageDailyLimit::where('company_id', $companyId)
            ->orderBy('fecha', 'desc')
            ->limit(5)
            ->get()
            ->toArray();
        return view('livewire.message-daily-limits-modal');
    }
}