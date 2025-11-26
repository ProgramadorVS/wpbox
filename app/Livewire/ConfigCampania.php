<?php

namespace App\Livewire;

use Livewire\Component;
use Modules\Wpbox\Models\Campaign;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConfigCampania extends Component
{
    // Propiedades públicas para Livewire
    public $selectedAgendaCampaign = null;
    public $selectedRecordatorioCampaign = null;
// de las vacunas
    public $selectedAgendaVacunaCampaign = null;
    public $selectedRecordatorioVacunaCampaign = null;

    public $selectedCancelacionCampaign = null;
    public $selectedConfirmaCampaign = null;

    // Valores originales cargados en mount
    public $originalAgendaCampaign = null;
    public $originalRecordatorioCampaign = null;

    public $originalAgendaVacunaCampaign = null;
    public $originalRecordatorioVacunaCampaign = null;

    public $originalCancelacionCampaign = null;
    public $originalConfirmaCampaign = null;

    // Propiedades para mantener los valores anteriores en caso de error
    public $previousValues = [];
    public $errorFields = [];


    public $selectedCancelacionVacunaCampaign = null;
    public $originalCancelacionVacunaCampaign = null;

    protected function getFieldMapping($field)
    {
        $mappings = [
            'cita_agenda' => ['property' => 'selectedAgendaCampaign', 'type' => 'agenda'],
            'cita_recuerda' => ['property' => 'selectedRecordatorioCampaign', 'type' => 'recordatorio'],
            'cita_agenda_vacuna' => ['property' => 'selectedAgendaVacunaCampaign', 'type' => 'agenda_vacuna'],
            'cita_recuerda_vacuna' => ['property' => 'selectedRecordatorioVacunaCampaign', 'type' => 'recordatorio_vacuna'],
            'cita_cancela' => ['property' => 'selectedCancelacionCampaign', 'type' => 'cancelación'],
            'cita_ok' => ['property' => 'selectedConfirmaCampaign', 'type' => 'confirmación'],

            'cita_cancela_vacuna' => ['property' => 'selectedCancelacionVacunaCampaign', 'type' => 'cancelación_vacuna'],
        ];

        return $mappings[$field] ?? null;
    }

    public function mount()
    {
    // Cargar las configuraciones actuales y guardar los valores originales
    $this->originalAgendaCampaign = $this->selectedAgendaCampaign = Campaign::where('cita_agenda', 1)->value('id');
    $this->originalRecordatorioCampaign = $this->selectedRecordatorioCampaign = Campaign::where('cita_recuerda', 1)->value('id');
    
    $this->originalAgendaVacunaCampaign = $this->selectedAgendaVacunaCampaign = Campaign::where('cita_agenda_vacuna', 1)->value('id');
    $this->originalRecordatorioVacunaCampaign = $this->selectedRecordatorioVacunaCampaign = Campaign::where('cita_recuerda_vacuna', 1)->value('id');
    
    $this->originalCancelacionCampaign = $this->selectedCancelacionCampaign = Campaign::where('cita_cancela', 1)->value('id');
    $this->originalConfirmaCampaign = $this->selectedConfirmaCampaign = Campaign::where('cita_ok', 1)->value('id');

  
        $this->originalCancelacionVacunaCampaign = $this->selectedCancelacionVacunaCampaign = Campaign::where('cita_cancela_vacuna', 1)->value('id');
    }

    public function saveAgenda()
    {
        $this->saveCampaignConfig('agenda', $this->selectedAgendaCampaign, 'cita_agenda');
    }

    public function saveRecordatorio()
    {
        $this->saveCampaignConfig('recordatorio', $this->selectedRecordatorioCampaign, 'cita_recuerda');
    }



    public function saveAgendaVacuna()
    {
        $this->saveCampaignConfig('agenda_vacuna', $this->selectedAgendaCampaign, 'cita_agenda_vacuna');
    }

    public function saveRecordatorioVacuna()
    {
        $this->saveCampaignConfig('recordatorio_vacuna', $this->selectedRecordatorioCampaign, 'cita_recuerda_vacuna');
    }


    public function saveCancelacion()
    {
        $this->saveCampaignConfig('cancelación', $this->selectedCancelacionCampaign, 'cita_cancela');
    }

    public function saveConfirma()
    {
        $this->saveCampaignConfig('confirmación', $this->selectedConfirmaCampaign, 'cita_ok');
    }

    public function getCampaignStatus($field)
    {
        return Campaign::where($field, 1)->exists() ? 'ACTIVO' : 'INACTIVO';
    }

    public function getCampaignStatusClass($field)
    {
        return Campaign::where($field, 1)->exists() ? 'bg-success' : 'bg-secondary';
    }

    public function getSelectedCampaignName($campaignId)
    {
        if (!$campaignId) return 'Seleccione Campaña';
        return Campaign::find($campaignId)?->name ?? 'Seleccione Campaña';
    }


    public function saveAll()
    {
        // Guarda solo los cambios realizados en los selects respecto al valor original
        if ($this->selectedAgendaCampaign !== $this->originalAgendaCampaign) {
            $this->saveCampaignConfig('agenda', $this->selectedAgendaCampaign, 'cita_agenda');
        }
        if ($this->selectedRecordatorioCampaign !== $this->originalRecordatorioCampaign) {
            $this->saveCampaignConfig('recordatorio', $this->selectedRecordatorioCampaign, 'cita_recuerda');
        }


        if ($this->selectedAgendaVacunaCampaign !== $this->originalAgendaVacunaCampaign) {
            $this->saveCampaignConfig('agenda_vacuna', $this->selectedAgendaVacunaCampaign, 'cita_agenda_vacuna');
        }


        if ($this->selectedRecordatorioVacunaCampaign !== $this->originalRecordatorioVacunaCampaign) {
            $this->saveCampaignConfig('recordatorio_vacuna', $this->selectedRecordatorioVacunaCampaign, 'cita_recuerda_vacuna');
        }


        if ($this->selectedCancelacionCampaign !== $this->originalCancelacionCampaign) {
            $this->saveCampaignConfig('cancelación', $this->selectedCancelacionCampaign, 'cita_cancela');
        }
        if ($this->selectedConfirmaCampaign !== $this->originalConfirmaCampaign) {
            $this->saveCampaignConfig('confirmación', $this->selectedConfirmaCampaign, 'cita_ok');
        }

        if ($this->selectedCancelacionVacunaCampaign !== $this->originalCancelacionVacunaCampaign) {
            $this->saveCampaignConfig('cancelación_vacuna', $this->selectedCancelacionVacunaCampaign, 'cita_cancela_vacuna');
        }


    }


    private function saveCampaignConfig($type, $campaignId, $field)
    {
        try {
            $mapping = $this->getFieldMapping($field);
            if (!$mapping) {
                Log::error("Error en saveCampaignConfig: Mapping no encontrado para el campo {$field}");
                throw new \Exception("Error de configuración del sistema");
            }

            // Guardar el valor anterior
            $propertyName = $mapping['property'];
            $this->previousValues[$field] = $this->{$propertyName};

            // Si no hay ID, significa que queremos desactivar la campaña actual
            if (!$campaignId) {
                if ($activeCampaign = Campaign::where($field, 1)->first()) {
                    $activeCampaign->update([$field => 0]);
                    session()->flash('success', "Campaña de {$type} desactivada exitosamente");
                }
                $this->errorFields = array_diff($this->errorFields, [$field]);
                return;
            }

            // Validar que la campaña exista y sea del tipo correcto
            $campaign = Campaign::where('id', $campaignId)
                ->where('is_simple', 1)
                ->first();

            if (!$campaign) {
                $this->handleError($field, "La campaña seleccionada no existe o no es del tipo correcto");
                return;
            }

            // Activar la campaña seleccionada
            $campaign->update([$field => 1]);
            session()->flash('success', "Campaña de {$type} actualizada exitosamente");
            $this->errorFields = array_diff($this->errorFields, [$field]);

        } catch (\Exception $e) {
            $this->handleError($field, $e);
        }
    }

    private function handleError($field, $error)
    {
        $mapping = $this->getFieldMapping($field);
        
        if (!$mapping) {
            Log::error("Error en handleError: Mapping no encontrado para el campo {$field}");
            session()->flash('error', "Error interno del sistema");
            return;
        }

        $propertyName = $mapping['property'];
        
        // Restaurar el valor anterior
        $this->{$propertyName} = $this->previousValues[$field] ?? null;
        
        // Marcar el campo como con error
        $this->errorFields[] = $field;
        $this->errorFields = array_unique($this->errorFields);

        // Obtener el mensaje de error formateado
        $errorMessage = $this->getReadableErrorMessage($error);
        
        // Mostrar mensaje de error
        session()->flash('error', $errorMessage);
    }

    private function getReadableErrorMessage($error)
    {
        // Si es un string, devolverlo directamente
        if (is_string($error)) {
            if (str_contains($error, 'No se puede activar la misma campaña')) {
                return "No se puede usar la misma campaña para múltiples funciones";
            }
            return $error;
        }

        // Si estamos en ambiente de desarrollo y es una excepción, mostrar el mensaje completo
        if (config('app.debug') && method_exists($error, 'getMessage')) {
            return $error->getMessage();
        }

        // En producción, mostrar mensajes más amigables
        if ($error instanceof \Illuminate\Database\QueryException) {
            if (str_contains($error->getMessage(), 'Duplicate entry')) {
                return "Ya existe una campaña configurada para este tipo";
            }
            if (str_contains($error->getMessage(), 'Foreign key')) {
                return "La campaña seleccionada no existe o fue eliminada";
            }
            return "Error al actualizar la base de datos";
        }

        return "Ocurrió un error inesperado";
    }

    public function render()
    {
        $campaigns = Campaign::where('is_simple', 1)
            ->orderBy('name', 'asc')
            ->get();
        
        return view('livewire.config-campania', [
            'campaigns' => $campaigns
        ]);
    }
}
