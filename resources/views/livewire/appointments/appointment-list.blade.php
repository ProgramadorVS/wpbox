<div>

 

      
      <div class="row">
        <div class="col12 col-md-12">
            <div>
              <div>
                
               

 

 {{-- filtros --}}

                    <div class="filters-container mb-4">
                        <!-- Fila Superior - Filtros Principales -->
                        <div class="row align-items-end g-3">
                            <!-- Doctor -->
                            <div class="col-12   col-md-4">
                                <label for="doctor-filter" class="form-label   small mb-1">{{ $companyLabels['label_responsable_name_singular'] }}</label>
                                <select 
                                    wire:model.live="doctor_id" 
                                    id="doctor-filter" 
                                  class="form-select border py-2 w-100"
                                  
                                
                                >
                                    <option value="">TODOS LOS {{ $companyLabels['label_responsable_name_plural'] }}</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Fecha iNICIO-->
                            <div class="col-12   col-md-4">
                                <label for="date-filter" class="form-label  small mb-1">FECHA INICIO</label>
                                <input 
                                    type="date" 
                                    wire:model.live="fecha" 
                                    id="date-filter" 
                                    class="form-control border py-2 w-100"
                                      
                                >
                            </div>


                            <!-- Fecha FIN-->
                            <div class="col-12   col-md-4">
                                <label for="date-filter" class="form-label  small mb-1">FECHA FIN</label>
                                <input 
                                    type="date" 
                                    wire:model.live="fecha_fin" 
                                    id="date-filter" 
                                    class="form-control border py-2 w-100"
                                      
                                >
                            </div>


                            
                            <!-- Estado -->
                            <div class="col-12  col-md-4">
                                <label for="status-filter" class="form-label   small mb-1">ESTADO</label>
                                <select 
                                    wire:model.live="status_id" 
                                    id="status-filter" 
                                    class="form-select border py-2 w-100"
                                      
                                >
                                    <option value="">TODOS LOS STATUS</option>
                                    <option value="1">AGENDADAS ({{$appointmentScheduledCount}})</option>
                                    <option value="2">CONFIRMADAS ({{$appointmentConfirmCount}})</option>
                                    <option value="3">CANCELADAS ({{$appointmentCanceledCount}})</option>
                                </select>
                            </div>
                            
                            <!-- Asistencia -->
                            <div class="col-12 col-md-4">
                                <label for="asiste-filter" class="form-label small mb-1">ASISTENCIA</label>
                                <select 
                                    wire:model.live="asiste" 
                                    id="asiste-filter" 
                                    class="form-select border py-2 w-100"
                                >
                                    <option value="">TODOS</option>
                                    <option value="1">ASISTIÓ</option>
                                    <option value="0">NO ASISTIÓ</option>
                                </select>
                            </div>

                            <!-- Tipo de Cita -->
                            <div class="col-12 col-md-4">
                                <label for="tipocita-filter" class="form-label small mb-1">TIPO DE CITA</label>
                                <select 
                                    wire:model.live="tipocita" 
                                    id="tipocita-filter" 
                                    class="form-select border py-2 w-100"
                                >
                                    <option value="">TODOS</option>
                                    <option value="1">CITA</option>
                                    <option value="2">ALERGOIDE</option>
                                    <option value="3">ACUOSA</option>
                                    <option value="4">ORAL</option>
                                </select>
                            </div>
                                

                        </div>

                        <!-- Fila Inferior - Búsqueda por Paciente -->
                        <div class="row mt-3 align-items-end g-3">     
                            <div class="col-12 col-md-8">
                                <label for="contact-filter" class="form-label  small mb-1">{{ $companyLabels['label_contact_name_full'] }}</label>
                                <div class="input-group">
                                    <input 
                                        type="text" 
                                        wire:model.live.debounce.500ms="contact_name" 
                                        id="contact-filter" 
                                        class="form-control border py-2"
                                        placeholder="Escriba el nombre para filtrar..."
                                        style="min-width: 200px;"
                                    >
                                    
                                </div>
                                

                            </div>
                    <!-- Botón Limpiar -->
                            <div class="col-12 col-sm-4">
                                <button 
                                    wire:click="clearFilters" 
                                    class="btn btn-outline-secondary w-100 py-2"
                                >
                                    <i class="fas fa-times me-1"></i> LIMPIAR FILTROS
                                </button>
                            </div>
                        


                        </div>
                    </div>

 {{-- filtros --}}

              </div>

 
 
 {{-- INICIO GRID --}}
              <div  >
                @if($appointments->isEmpty())
                  <div class="alert alert-secondary text-center" role="alert">
                    No hay citas disponibles.
                  </div>
                @else
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                        <tr class="table-active">
                        <th class="text-center">#</th>
                         <th>{{ $companyLabels['label_responsable_name_singular'] }}</th>
                         <th>Fecha</th>
                         <th>Cita </th>
                          <th class="text-center">Status</th>
                           <th class="text-center">Asistió</th>
                        <th>{{ $companyLabels['label_contact_name_singular'] }}</th>

                        <th>Tipo Cita</th>

                        <th>Teléfono</th>
                       
                       
                        <th class="text-center">
                            Cita <i class="bi bi-whatsapp fs-6 ms-1 whatsapp-green"></i>
                        </th>

                        <th class="text-center">
                            Recordatorio <i class="bi bi-whatsapp fs-6 ms-1 whatsapp-green"></i>
                        </th>


                        <th>Notas</th>
                      
                        
                      </tr>
                    </thead>
                    <tbody>

                     @foreach ($appointments as $key=>$appointment)
                      <tr class="{{ $loop->odd ? '' : 'table-active1' }}">
                         

                              <td class="text-center"> {{ $key + 1 }} </td>

                                <td>{{ $appointment->doctor?->siglas ?? 'N/A' }}</td>
                               <td>{{ \Carbon\Carbon::parse($appointment->fecha)->format('d/m/Y') }}</td>
                                <td>{{ Carbon\Carbon::parse($appointment->hora)->format('h:i A') }}</td>
                                 
                               <td class="text-center">
                                    @if ($appointment->status_id == 1)
                                   <!--     <i class="material-icons bg-primary rounded-circle text-white" title="Agendada" style="font-size: 18px; padding: 4px;">event</i>  Agendada -->
                                        
                                   
                                            {{-- Inicio de la nueva condición anidada --}}
                                            @if ($appointment->contact?->expediente == "PRIMERA VEZ")
                                                <span class="badge" style="background-color: #f4c93cff;">Agendada</span>
                                            @else
                                                <span class="badge badge-primary">Agendada</span>
                                            @endif
                                            {{-- Fin de la condición anidada --}}
                                   
                                         
                                   <!-- <span class="badge" style="background-color: #007dfa3d; color: #1912e4c2; border-radius: 16px; font-size: 0.7rem; padding: 0.25rem 0.5rem;">Agendada</span> -->
                                        @elseif ($appointment->status_id == 2)
                                    <!--      <i class="material-icons bg-success rounded-circle text-white" title="Confirmada" style="font-size: 18px; padding: 4px;">event</i>  Confirmada -->
                                             <span class="badge badge-success">Confirmada</span>
                                  
                                        @elseif ($appointment->status_id == 3)
                                   <!--       <i class="material-icons bg-danger rounded-circle text-white" title="Cancelada" style="font-size: 18px; padding: 4px;">event</i>  Cancelada -->
                                            <span class="badge badge-danger">Cancelada</span>
                                        @endif
                                 
                                </td>
                                 <td class="text-center">
                                        @if ($appointment->asiste == "1")
                                                  <span class="badge badge-success">SI</span>
                                            @else
                                                  <span class="badge badge-danger">NO</span>
                                            @endif

                                 </td>
                              <td>{{ $appointment->contact?->name ?? 'N/A' }}</td>

                            <td>{{ $this->getTipoCitaLabel($appointment->tipocita) }}</td>

                             <td>{{ $appointment->contact?->phone ? substr($appointment->contact->phone, 3) : 'N/A' }}</td>
                            
                            
                                 <td class="text-center">
                            
                                            @php
                                                $estado = $this->getEstadoAgenda($appointment->whatscita_agenda);
                                            @endphp
                                            <span class="badge {{ $estado['class'] }} rounded-pill px-3 py-1 fs-6">
                                                    {{ $estado['label'] }}
                                            </span>
                                    
                                    
                                </td>     
                                
                                

                                 <td class="text-center">
                                    @php
                                        $estado = $this->getEstadoConfirma($appointment->whatscita_confirma);
                                    @endphp
                                    <span class="badge {{ $estado['class'] }} rounded-pill px-3 py-1 fs-6">
                                            {{ $estado['label'] }}
                                        </span>
                                </td> 

                                                 

                              <td>{!! Str::limit($appointment->note, 60, '...') !!}</td>
                              

                          </tr>
                          @endforeach
                    </tbody>
                  </table>
                </div>
                @endif
              </div>
 {{-- FIN GRID --}}


            </div>

 
            @unless($appointments->isEmpty())
                     {{-- Paginación --}}
     
                    <div class="d-flex justify-content-center">
                        {{  $appointments->links('vendor.pagination.bootstrap-livewire') }}
                    </div>

            @endunless
            
          </div>
      </div>

 

@section('js')
 
    
@endsection

</div>
