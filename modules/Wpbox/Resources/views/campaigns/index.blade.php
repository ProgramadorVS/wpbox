
 @extends('general.index', $setup)

 @section('head')
 
     <style>
            .modal {
                    display: none;
                    position: fixed;
                    z-index: 10;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.5);
                    animation: fadeIn 0.3s ease;
                }
                
                .modal-content {
                    background-color: white;
                    margin: 40px auto 0 auto;
                    padding: 30px;
                    border-radius: 12px;
                    width: 90%;
                    max-width: 700px;
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                    animation: slideIn 0.3s ease;
                    position: relative;
                    max-height: calc(80vh + 100px);
                    overflow-y: auto;
                }

                   .close2 {
                   
                    position: absolute;
                    top: 15px;
                    right: 20px;
                    transition: color 0.2s;
                }
                .close {
                    color: #aaa;
                    position: absolute;
                    top: 15px;
                    right: 20px;
                    font-size: 28px;
                    font-weight: bold;
                    cursor: pointer;
                    transition: color 0.2s;
                }
                
                .close:hover {
                    color: #333;
                }
                
                .modal-title {
                    font-size: 1.8rem;
                    color: #1E293B;
                    margin-bottom: 20px;
                    padding-bottom: 10px;
                    border-bottom: 2px solid #E2E8F0;
                }
                
                .modal-detail {
                    margin-bottom: 15px;
                    display: flex;
                }
                
                .modal-detail label {
                    font-weight: 600;
                    min-width: 100px;
                    color: #475569;
                }
                
                .modal-detail span {
                    color: #334155;
                }
            
            /* Ajusta el padding para que la "x" no se empalme con el texto */
            
            .campaign-card {
    
                background-color: #f5faf5; /* verde claro */
            }
         

         
            .badge-group-wrap {
                font-size: 0.85em;
                padding: 0.3em 0.6em;
            }
            .campaign-date {
                font-size: 0.85em;
                color: #888;
                display: block;
                margin-top: 0.5em;
            }
            .badge-group-wrap {
                font-size: 0.75em;           /* Un poco más grande */
                padding: 0.35em 1em;         /* Más espacio horizontal */
                white-space: normal !important;
                word-break: break-word;
                display: inline-block;
                max-width: 100%;
                min-width: 120px;            /* Opcional: mínimo ancho */
            }


            .loading-modal {
                position: fixed;
                top:0; left:0; right:0; bottom:0;
                background-color: transparent;
                z-index: 1050;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                gap: 10px;
                color: white;
                font-weight: bold;
                font-size: 1.2rem;
            }

            .loading-modal img {
                width: 100px;
                height: 100px;
            }


             /* Responsive */
        @media (max-width: 768px) {
 
            
            .modal-content {
                width: 95%;
                padding: 20px;
            }
        }
     </style>
 @endsection

 

@section('cardbody')

        <div class="card   shadow-sm mb-3">
            <div class="card-body">


                    Total de mensajes diarios permitidos: <b>{{ $companyLabels['total_mensajes_dia'] }} </b>
                            <!-- Modal Limites -->
                            <div id="LimitsModal" class="modal">
                                <div class="modal-content">
                                    <span class="close" id="closeLimitsModal">&times;</span>
                                    <br>
                                    <livewire:message-daily-limits-modal />      
                                </div>
                            </div>
            
            

                                @if(auth()->user()->hasRole('staff'))
                                    <span></span>
                                @else
                                
                                    <div class="row mt-4">
                                            <!-- 📅 Día anterior -->
                                            <div class="col-lg-4 col-md-6 col-12 mb-4">
                                                <div class="card shadow h-100">
                                                    <div class="card-header text-center fw-bold">
                                                        📆 Mensajes Día anterior: {{ $setup['fecha_ayer'] }}
                                                    </div>
                                                    <div class="card-body p-2">
                                                        <table class="table table-bordered table-sm text-center">
                                                            <thead class="table">
                                                                <tr>
                                                                    <th>Hora</th>
                                                                    <th>Mensajes Mandados</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($setup['tablaHorasAyer'] as $fila)
                                                                    <tr>
                                                                        <td>{{ str_pad($fila['hora'], 2, '0', STR_PAD_LEFT) }}:00</td>
                                                                        <td>{{ $fila['cantidad'] }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                <tr class="fw-bold">
                                                                    <td>Total</td>
                                                                    <td>{{ $setup['totales']['ayer'] }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 📅 Día actual -->
                                            <div class="col-lg-4 col-md-6 col-12 mb-4">
                                                <div class="card shadow h-100">
                                                    <div class="card-header text-center fw-bold">
                                                        📆 Mensajes Día actual: {{ $setup['fecha_hoy'] }}
                                                    </div>
                                                    <div class="card-body p-2">
                                                        <table class="table table-bordered table-sm text-center">
                                                            <thead class="table">
                                                                <tr>
                                                                    <th>Hora</th>
                                                                    <th>Mensajes Mandados</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($setup['tablaHorasHoy'] as $fila)
                                                                    <tr>
                                                                        <td>{{ str_pad($fila['hora'], 2, '0', STR_PAD_LEFT) }}:00</td>
                                                                        <td>{{ $fila['cantidad'] }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                <tr class="fw-bold">
                                                                    <td>Total</td>
                                                                    <td>{{ $setup['totales']['hoy_mandados'] }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 🔘 Botones -->
                                            <div class="col-lg-4 col-md-12 col-12 mb-4">
                                            <div class="d-flex flex-column h-100 justify-content-center" style="gap: 2rem;">
                                                    <button 
                                                        onclick="Livewire.dispatch('openLimitsModal')"
                                                        type="button"
                                                        class="btn btn-dark btn-lg w-100">
                                                        📊 Ver Límites Diarios
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="btn btn-success btn-lg w-100"
                                                        onclick="confirmSend()">
                                                        &rarr; Enviar Mensajes Pendientes &larr;
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- 📅FIN -->

                                @endif
                        </div>
        </div>        
  
 @livewire('campaigns-live-index')   
         
@endsection






@push('js')



<script>
        document.addEventListener('DOMContentLoaded', function () {
            var limitsModal = document.getElementById('LimitsModal');
            var closeLimitsBtn = document.getElementById('closeLimitsModal');

            // Abrir el modal al recibir el evento de Livewire
            Livewire.on('openLimitsModal', function () {
                limitsModal.style.display = 'block';
            });

            // Cerrar el modal al hacer clic en la "x"
            closeLimitsBtn.onclick = function () {
                limitsModal.style.display = 'none';
            };

            // Cerrar el modal al hacer clic fuera del contenido del modal
            window.onclick = function (event) {
                if (event.target == limitsModal) {
                    limitsModal.style.display = 'none';
                }
            };
        });
    </script>

 

   <script>
        function confirmSend() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se enviarán todos los mensajes pendientes programados",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, enviar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var w = 500;
                    var h = 400;
                    var left = (screen.width/2)-(w/2);
                    var top = (screen.height/2)-(h/2);
                    window.open(
                        '{{ route('wpbox.sendscheduled') }}',
                        'popup',
                        'width=' + w + ',height=' + h + ',top=' + top + ',left=' + left + ',scrollbars=yes,resizable=yes'
                    );
                }
            });
        }
    </script> 
@endpush
 