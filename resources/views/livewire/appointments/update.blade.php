<div>
  
  

<div >
   

    <div class="row justify-content-center">
        <div class="col-12 col-lg-12">
            <form wire:submit.prevent="update">


                <!-- Campo DOCTOR -->
                <div class="row mb-3 mb-md-4">
                    <div class="col-12">
                        <label for="doctor-filter" class="form-label small mb-1">{{ $companyLabels['label_responsable_name_singular'] }}</label>
                        <select 
                            wire:model="doctor_id" 
                            id="doctor-filter" 
                            class="form-select border py-2 w-100 @if($soloEstadoEditable) border-danger @endif"
                            @if($soloEstadoEditable) disabled @endif
                        >
                            <option value="" selected disabled>Selecciona {{ $companyLabels['label_responsable_name_singular'] }}</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>



                <!-- Campo Paciente -->
                <div class="row mb-3 mb-md-4" x-data="{ open: false }" x-on:click.away="open = false">
                    <div class="col-12">
                        <label for="contact-search" class="form-label small mb-1">{{ $companyLabels['label_contact_name_singular'] }}</label>
                        <div class="position-relative">
                            <input 
                                type="text" 
                                id="contact-search" 
                                class="form-control border py-2 w-100 @if($soloEstadoEditable) border-danger @endif"
                                placeholder="Buscar nombre..."
                                wire:model.live.debounce.300ms="contactSearch"
                                x-on:focus="open = true"
                                x-on:input="open = true"
                                autocomplete="off"
                                required
                                @if($soloEstadoEditable) disabled @endif
                            >
                            <!-- Resultados de búsqueda -->
                            <div x-show="open && $wire.contactResults.length" 
                                class="position-absolute w-100 bg-white shadow-lg rounded mt-1" 
                                style="max-height: 300px; overflow-y: auto; z-index: 9999;">
                                 @foreach($contactResults as $contact)
                                    <div wire:click="selectContact({{ $contact['id'] }})" 
                                        class="px-3 py-2 hover-bg-light cursor-pointer"
                                        x-on:click="open = false" style="color: #000;">
                                        {{ $contact['name'] }}
                                        @if($contact['esprimeravez'] == 1)
                                            <span class="badge badge-info ml-2">Primera vez</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @error('contact_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>


                <!-- Campos Fecha y Hora -->
                <div class="row mb-3 mb-md-4">
                    <div class="col-12">
                        <div class="row">
                            <!-- Fecha -->
                            <div class="col-12 col-md-4 mb-3 mb-md-0">
                                <label for="fecha" class="form-label small mb-1">FECHA</label>
                                <input 
                                    type="date" 
                                    id="fecha" 
                                    class="form-control border py-2 w-100 @if($soloEstadoEditable) border-danger @endif" 
                                    wire:model="fecha"
                                    @if($soloEstadoEditable) disabled @endif
                                >
                                @error('fecha')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Hora Inicio -->
                            <div class="col-12 col-md-4 mb-3 mb-md-0">
                                <label for="hora" class="form-label small mb-1">HORA INICIO</label>
                                <input 
                                    type="time" 
                                    id="hora" 
                                    class="form-control border py-2 w-100 @if($soloEstadoEditable) border-danger @endif" 
                                    wire:model.live="hora"
                                    @if($soloEstadoEditable) disabled @endif
                                >
                                @error('hora')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Hora Fin (automática) -->
                            <div class="col-12 col-md-4 mb-3 mb-md-0">
                                <label for="horafin" class="form-label small mb-1">HORA FIN</label>
                                <input 
                                    type="time" 
                                    
                                    id="horafin" 
                                    class="form-control border py-2 w-100" 
                                    wire:model.live="horafin"
                                    readonly
                                >
                                @error('horafin')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Campo Estado -->
                <div class="row mb-3 mb-md-4">
                    <div class="col-12">
                        <label for="status_id" class="form-label small mb-1">ESTADO</label>
                        <select 
                            class="form-control border py-2 w-100" 
                            wire:model="status_id"
                        >
                            <option value="" selected disabled>Seleccione...</option>
                            <option value="1">AGENDADA</option>
                            <option value="2">CONFIRMADA</option>
                            <option value="3">CANCELADA</option>
                        </select>
                        @error('status_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Campo Notas -->
                <div class="row mb-3 mb-md-4">
                    <div class="col-12">
                        <label for="note" class="form-label small mb-1">NOTAS</label>
                        <textarea 
                            id="note" 
                            class="form-control border py-2 w-100" 
                            rows="3" 
                            wire:model="note"
                            
                        ></textarea>
                        @error('note')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <button
                            wire:click="$dispatch('modificar-cita')"
                            class="btn btn-rose btn-sm btn-md@md btn-lg@lg btn-success"
                            title="Crear cita"
                            wire:loading.attr="disabled"
                        >
                         <i class="bi bi-pencil-square"></i>
                            ACTUALIZAR CITA
                        </button>
                        <button 
                            type="button" 
                            id="closeEditarModal2" 
                            class="btn btn-secondary"
                        >
                         <i class="bi bi-x-circle"></i>
                            Cerrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


</div>

    @section('js')
        <script>
            Livewire.on('confirm', () => {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Desea actualizar la cita?",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, proceder',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('modificar-cita');
                    }
                });
            });
        </script>     
    @endsection
</div>
