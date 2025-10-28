{{-- Archivo: resources/views/livewire/message-daily-limits-modal.blade.php --}}

<div>
  
    {{-- Modal Backdrop --}}
    <div>
       <div>
           
                {{-- Header --}}
               
                    <h5 class="modal-title">
                        📊 Límites Diarios de Mensajes
                    </h5>
                   
       Total de mensajes diarios permitidos: <b>{{ $companyLabels['total_mensajes_dia'] }} </b>
<br>
                {{-- Body --}}
                <div  >
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th class="text-center">Total Programados</th>
                                    <th class="text-center">Mensajes disponibles</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($limits as $limit)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($limit['fecha'])->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <strong>{{ $limit['total_programados'] }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <strong>{{ (int)$companyLabels['total_mensajes_dia'] - (int)$limit['total_programados'] }}</strong>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $totalMensajesDia = (int) $companyLabels['total_mensajes_dia'];
                                            $umbralCasiLleno = $totalMensajesDia * 0.75;
                                        @endphp
                                        @if($limit['total_programados'] >= $totalMensajesDia)
                                            <span class="badge badge-danger">
                                                🔴 Lleno
                                            </span>
                                        @elseif($limit['total_programados'] >= $umbralCasiLleno)
                                            <span class="badge badge-warning">
                                                🟡 Casi lleno
                                            </span>
                                        @else
                                            <span class="badge badge-success">
                                                🟢 Disponible
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        <em>No hay registros de límites diarios</em>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

     
  
        </div>
    </div>
 
</div>