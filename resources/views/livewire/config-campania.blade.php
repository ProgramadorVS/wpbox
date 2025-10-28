<div class="container-fluid">
 
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-1">
                    <div class="mb-3">
                        <h5 class="text-primary mb-3">Campaña de Agenda</h5>
                        <div class="row g-2 align-items-center">
                            <div class="col-12 col-md-8">
                                <select class="form-select border py-2 w-100 {{ in_array('cita_agenda', $errorFields) ? 'is-invalid' : '' }}" 
                                     
                                wire:model="selectedAgendaCampaign"
                                        wire:key="agenda-{{ $selectedAgendaCampaign }}-{{ in_array('cita_agenda', $errorFields) }}">
                                    <option value="">Seleccione Campaña</option>
                                    @if($selectedAgendaCampaign)
                                        <option value="{{ $selectedAgendaCampaign }}" selected>{{ $this->getSelectedCampaignName($selectedAgendaCampaign) }}</option>
                                    @endif
                                    @foreach($campaigns as $campaign)
                                        @if($campaign->id != $selectedAgendaCampaign)
                                            <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-4 text-md-end mt-2 mt-md-0">
                                <span class="badge {{ $this->getCampaignStatusClass('cita_agenda') }}">
                                    {{ $this->getCampaignStatus('cita_agenda') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-1">
                    <div class="mb-3">
                        <h5 class="text-primary mb-3">Campaña de Recordatorio</h5>
                        <div class="row g-2 align-items-center">
                            <div class="col-12 col-md-8">
                                <select class="form-select border py-2 w-100 {{ in_array('cita_recuerda', $errorFields) ? 'is-invalid' : '' }}" 
                                        wire:model="selectedRecordatorioCampaign"
                                        wire:key="recordatorio-{{ $selectedRecordatorioCampaign }}-{{ in_array('cita_recuerda', $errorFields) }}">
                                    <option value="">Seleccione Campaña</option>
                                    @if($selectedRecordatorioCampaign)
                                        <option value="{{ $selectedRecordatorioCampaign }}" selected>{{ $this->getSelectedCampaignName($selectedRecordatorioCampaign) }}</option>
                                    @endif
                                    @foreach($campaigns as $campaign)
                                        @if($campaign->id != $selectedRecordatorioCampaign)
                                            <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-4 text-md-end mt-2 mt-md-0">
                                <span class="badge {{ $this->getCampaignStatusClass('cita_recuerda') }}">
                                    {{ $this->getCampaignStatus('cita_recuerda') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-1">
                    <div class="mb-3">
                        <h5 class="text-primary mb-3">Campaña de Cancelación</h5>
                        <div class="row g-2 align-items-center">
                            <div class="col-12 col-md-8">
                                <select class="form-select border py-2 w-100 {{ in_array('cita_cancela', $errorFields) ? 'is-invalid' : '' }}" 
                                        wire:model="selectedCancelacionCampaign"
                                        wire:key="cancelacion-{{ $selectedCancelacionCampaign }}-{{ in_array('cita_cancela', $errorFields) }}">
                                    <option value="">Seleccione Campaña</option>
                                    @if($selectedCancelacionCampaign)
                                        <option value="{{ $selectedCancelacionCampaign }}" selected>{{ $this->getSelectedCampaignName($selectedCancelacionCampaign) }}</option>
                                    @endif
                                    @foreach($campaigns as $campaign)
                                        @if($campaign->id != $selectedCancelacionCampaign)
                                            <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-4 text-md-end mt-2 mt-md-0">
                                <span class="badge {{ $this->getCampaignStatusClass('cita_cancela') }}">
                                    {{ $this->getCampaignStatus('cita_cancela') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-1">
                    <div class="mb-3">
                        <h5 class="text-primary mb-3">Campaña de Confirmación</h5>
                        <div class="row g-2 align-items-center">
                            <div class="col-12 col-md-8">
                                <select class="form-select border py-2 w-100 {{ in_array('cita_ok', $errorFields) ? 'is-invalid' : '' }}" 
                                        wire:model="selectedConfirmaCampaign"
                                        wire:key="confirma-{{ $selectedConfirmaCampaign }}-{{ in_array('cita_ok', $errorFields) }}">
                                    <option value="">Seleccione Campaña</option>
                                    @if($selectedConfirmaCampaign)
                                        <option value="{{ $selectedConfirmaCampaign }}" selected>{{ $this->getSelectedCampaignName($selectedConfirmaCampaign) }}</option>
                                    @endif
                                    @foreach($campaigns as $campaign)
                                        @if($campaign->id != $selectedConfirmaCampaign)
                                            <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-4 text-md-end mt-2 mt-md-0">
                                <span class="badge {{ $this->getCampaignStatusClass('cita_ok') }}">
                                    {{ $this->getCampaignStatus('cita_ok') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-primary px-5" wire:click="saveAll">
                                Guardar
                            </button>
                        </div>
</div>
