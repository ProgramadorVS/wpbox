<div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="card-custom">
                <!-- Logo de la empresa -->
                <div class="logo-container">
                    <!-- Reemplaza con tu logo real -->
                  
                   
                    @if($cita !== null)
                             @php
                                if (!empty($cita['company_id'])) {
                                    $logo = env('LOGO_URL' . $cita['company_id'], env('LOGO_URL', '/uploads/settings/logo.jpg'));
                                } else {
                                    $logo = env('LOGO_URL', '/uploads/settings/logo.jpg');
                                }
                            @endphp

                         <img src="{{ $logo }}"  class="logo"  >

                    @endif
                   
                </div>

                <div class="card-body px-4 pb-4">
                    @if($cita === null || $estado === 'expirada') 
                        <!-- Enlace inválido o cita no encontrada -->
                        <div class="text-center fade-in">
                            <div class="mb-4">
                                <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                            </div>
                            <h4 class="text-dark mb-3">Enlace no válido</h4>
                            <p class="text-muted">
                                El enlace que utilizaste no es válido o ha expirado. 
                                <br><br>
                                
                            </p>
                           
                        </div>
                    
                    @elseif($estado === 'pendiente' )
                        <!-- Estado inicial - mostrar información y botones -->
                        <div class="fade-in">
                            <div class="text-center mb-4">
                                <h5 class="text-dark fw-bold mb-2">Confirmación de Cita</h3>
                                <p class="text-muted">
                                    Por favor, confirma o cancela tu cita utilizando los botones de abajo.
                                </p>
                            </div>

                            <!-- Información de la cita -->
                            <div class="cita-info">
                                <div class="row">
                                     <div class="col-sm-6 mb-2">
                                        <strong>{{ Str::title($companyLabels['label_contact_name_singular']) }}</strong><br>
                                        <span class="text-muted">{{ $cita['paciente'] }}</span>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <strong>{{ Str::title($companyLabels['label_responsable_name_singular']) }}</strong><br>
                                        <span class="text-muted">{{ $cita['doctor'] }}</span>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <strong>Fecha:</strong><br>
                                      <span class="text-muted">
                                        {{ ucfirst(\Carbon\Carbon::parse($cita['fecha'])->locale('es')->translatedFormat('l d \d\e F \d\e Y')) }}
                                    </span>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <strong>Hora:</strong><br>
                                        <span class="text-muted">{{ $cita['hora'] }}</span>
                                    </div>
                                    
                                </div>
               
                            </div>
 {{-- wire:click="$dispatch('confirm-cita', { accion: 'confirmar' })" --}}
                            <!-- Botones de acción -->
                            <div class="d-grid gap-3 mt-4">
                                <button
                                        type="button"
                                        onclick="confirmarCitaLivewire('confirmar')"
                                        class="btn btn-confirm btn-lg"
                                        wire:loading.attr="disabled"
                                        
                                    >
                             
                                    @if($loading)
                                        <span class="spinner-border spinner-border-sm me-2"></span>
                                        Procesando...
                                    @else
                                        Confirmar Cita
                                    @endif
                                </button>

                                <button
                                        type="button"
                                        onclick="confirmarCitaLivewire('cancelar')"
                                         class="btn btn-cancel btn-lg"
                                        wire:loading.attr="disabled"
                                       
                                    >
                                    @if($loading)
                                        <span class="spinner-border spinner-border-sm me-2"></span>
                                        Procesando...
                                    @else
                                        Cancelar Cita
                                    @endif
                                </button>


                            </div>
                            
                            <div class=" mt-4">
                                <small class="text-muted"> 
                                  {!! $companyLabels['label_pie_pagina_confirma_cita'] !!}
                                   
                                </small>
                            </div>
                        </div>

                    @elseif($estado === 'confirmada')
                        <!-- Cita confirmada -->
                        <div class="text-center fade-in">
                            <div class="mb-4">
                                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                            </div>
                            <h4 class="text-success fw-bold mb-3">¡Cita Confirmada!</h4>

                        </div>
                        <div class="alert alert-success alert-custom">
                                <i class="fas fa-info-circle me-2"></i>
                                {{ $mensaje }}
                            </div>

                    @elseif($estado === 'cancelada')
                        <!-- Cita cancelada -->
                        <div class="text-center fade-in">
                            <div class="mb-4">
                                <i class="fas fa-times-circle text-danger" style="font-size: 4rem;"></i>
                            </div>
                            <h4 class="text-danger fw-bold mb-3">Cita Cancelada</h4>
             
                        </div>

                        <div class="alert alert-info alert-custom">
                                <i class="fas fa-info-circle me-2"></i>
                                {{ $mensaje }}  {!! $companyLabels['label_pie_pagina_confirma_cita']  !!}
                            </div>
                    @endif

                    @if($mensaje && $estado === 'pendiente')
                        <!-- Mensaje de error -->
                        <div class="alert alert-danger alert-custom mt-3 fade-in">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ $mensaje }}
                        </div>
                    @endif
                </div>
            </div>
        @if($cita !== null)
            <!-- Footer -->
            <div class="text-center mt-4">
                <p class="text-black-50 small">
                    © {{ date('Y') }}   {{ $companyLabels['label_pie_pagina_empresa'] }} 
                </p>
            </div>

        @endif
                </div>
            </div>
        </div>
 
 @push('js')
    <script>
            function confirmarCitaLivewire(accion) {
                Swal.fire({
                    title: accion === 'confirmar' ? '¿Confirmar cita?' : '¿Cancelar cita?',
                    text: accion === 'confirmar' ? '¿Estás seguro de confirmar tu cita?' : '¿Estás seguro de cancelar tu cita?',
                    icon: accion === 'confirmar' ? 'question' : 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí',
                    cancelButtonText: 'No',
                    confirmButtonColor: '#28a745', // verde Bootstrap
                    cancelButtonColor: '#6c757d'   // gris Bootstrap
                }).then((result) => {
                    if (result.isConfirmed) {
                
                       @this.call('ejecutarAccion', accion);
                    }
                });
            }
    </script>
@endpush