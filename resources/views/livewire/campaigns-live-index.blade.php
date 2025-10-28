


<div>

    <div class="card   shadow-sm mb-3">
      <div class="card-body">
            <div class="mb-4">

            
                <div class="row g-3">
                    <div class="col-12">
                        <label for="type-select" class="form-label mb-1  ">
                            Seleccione el tipo de campaña a filtrar
                        </label>

                
                            
                            <select wire:model.live="type" class="form-control">
                                <option value="">[Todos]</option>
                                @foreach($campaignTypes as $id => $nombre)
                                    <option value="{{ $id }}">{{ $nombre }}</option>
                                @endforeach
                            </select>


                    </div>
                </div>
            </div>

        {{-- Loading modal --}}
            <div wire:loading.flex  wire:target="type, toggleCron,filterByName,exportMultiple,borrarErrores,eliminarCampaña,continuarCampaña,continuarCampañaAgrega"  class="loading-modal">
                <img src="/archivos/Loading_2.gif"  >
               
            </div>
        {{-- Loading modal --}}

          <div class="card mb-4 shadow-sm">
                <div class="card-header bg-secondary">
                    <h3 class="mb-0 text-black">Reporte Múltiple de Campañas</h3>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="exportMultiple" class="mb-0" id="multi-report-form">
                    
                        @if(request()->filled('type'))
                            <input type="hidden" name="type" value="{{ request('type') }}">
                        @endif

                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-8">
                    
                                
                                {{-- INICIO CHECK BOXES PARA IMPRIMIR --}} 
                                <div>
                                    <h4 class="mb-2">Selecciona campañas para exportar:</h4>
                                    <div class="row">
                                        @foreach ($setup['allCampaigns'] as $campaign)
                                            <div class="col-md-4 mb-3">
                                                <div class="form-check ">
                                                    <input 
                                                        type="checkbox" 
                                                        class="form-check-input" 
                                                       
                                                        id="campaign-{{ $campaign->id }}" 
                                                        value="{{ $campaign->id }}"
                                                        wire:model="selectedCampaigns"
                                                    >
                                                    <label class="form-check-label" for="campaign-{{ $campaign->id }}">
                                                        {{ $campaign->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{-- FIN CHECK BOXES PARA IMPRIMIR --}} 
                            
                            </div>

                            {{-- Inputs hidden para enviar al backend --}}
                            @foreach ($selectedCampaigns as $id)
                                <input type="hidden" name="campaigns[]" value="{{ $id }}">
                            @endforeach

                            <div class="col-12 col-md-4 text-md-end">
                                <button type="submit"
                                        class="btn btn-success w-100 w-md-auto mt-3 mt-md-0"
                                        wire:loading.attr="disabled">
                                    Descargar Reporte&nbsp;Múltiple
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
      </div>
    </div>

<hr>
 
        {{-- ③ Filtro por nombre (ahora con Livewire) --}}
                <form wire:submit.prevent="filterByName" class="row g-3 mb-4">
                    <div class="col-md-8 col-12">
                        <input
                            type="text"
                            wire:model.defer="name"
                            placeholder="Buscar campaña por nombre…"
                            class="form-control"
                        >
                    </div>

                    <div class="col-md-2 col-6">
                        <button class="btn btn-primary w-100" type="submit">Filtrar</button>
                    </div>

                    @if(strlen($name) > 0)
                        <div class="col-md-2 col-6">
                            <button type="button" class="btn btn-outline-secondary w-100" wire:click="$set('name', '')">
                                Limpiar
                            </button>
                        </div>
                    @endif
                </form>





         


 
            @foreach ($setup['items'] as $item)


                    <div class="card campaign-card shadow-sm mb-3">
                        <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        
                                        {{-- Botón izquierda --}}
                                        @if($item->cron == 0)
                                            <button
                                                wire:click="toggleCron({{ $item->id }})"
                                                class="btn btn-danger btn-sm"
                                                title="Activa el envío automático de la campaña"
                                            >
                                                <i class="ni ni-send me-1"></i> Activa Envío Automático
                                            </button>
                                        @else
                                            <button
                                                wire:click="toggleCron({{ $item->id }})"
                                                class="btn btn-success btn-sm"
                                                title="Pausa el envío automático de la campaña"
                                            >
                                                <i class="ni ni-button-pause me-1"></i> Pausar Envío Automático
                                            </button>
                                        @endif

                                        {{-- Botón derecha --}}
                                        <a href="{{ route('campaigns.show', $item->id) }}" 
                                        class="btn btn-green btn-sm">
                                            <i class="ni ni-bold-right me-1"></i> Ver campaña
                                        </a>

                                    </div>

                            {{-- Aquí va tu contenido del infobox --}}
                            @include('wpbox::campaigns.infoboxes', $item)

                           

                             <!-- Acciones de campaña -->
                                <div class="row mt-2">

                              <!-- Botón Borrar errores -->

                                        <div class="col-6 col-md-auto mb-2">
                                             <button
                                            wire:click.prevent="$dispatch('confirm-borrarerrores', { id: {{ $item->id }} })"
                                             class="btn btn-warning btn-sm"
                                            title="Limpia errores y restablece mensajes fallidos, para ser mandados nuevamente"
                                            wire:loading.attr="disabled"
                                          
                                        >
                                            <i class="ni ni-fat-remove"></i> Borrar errores  
                                        </button>
                                        </div>
                                    
                                     @if($item->is_simple == 0)
                                                <div class="col-12 col-md-auto mb-2">
                                                <!-- Botón Eliminar campaña -->
                                                    <button
                                                        wire:click.prevent="$dispatch('confirm-delete', { id: {{ $item->id }} })"
                                                        class="btn btn-danger btn-sm"
                                                        wire:loading.attr="disabled"
                                                        wire:target="eliminarCampaña"
                                                    >
                                                       <i class="ni ni-fat-delete"></i>  Eliminar campaña
                                                    </button>
                                                </div>          
                                    
                                        <div class="col-12 col-md-auto mb-2">
                                                <button type="button"
                                                        class="btn btn-dark btn-sm"
                                                        title="Mandar mensajes a contactos nuevos del grupo seleccionado"
                                                        data-toggle="modal"
                                                        data-target="#continuarModal2-{{ $item->id }}">
                                                    <i class="ni ni-send"></i> Mandar a nuevos contactos
                                                </button>
                                        </div>
                      
                                        <div class="col-12 col-md-auto mb-2">
                                            <button type="button"
                                                    class="btn btn-primary btn-sm"
                                                    title="Cambiar STATUS de mensajes a Pendiente, para que se puedan enviar nuevamente los que no han contestado"
                                                    data-toggle="modal"
                                                    data-target="#continuarModal-{{ $item->id }}">
                                            <i class="ni ni-check-bold"></i>  Cambia status a Pendiente
                                            </button>
                                        </div>
                  
                                     @endif




                                </div>

                        </div>
                    </div>
                
            @if(auth()->user()->hasRole('staff'))
                        <span></span>
                        @else
                               


                        
                            <!-- INICIO Modal 1 -->
                            <div class="modal fade" id="continuarModal-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="continuarModalLabel-{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                     
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="continuarModalLabel-{{ $item->id }}">Campaña: {{ $item->name }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mt-3 mb-3">
                                                                <label class="font-weight-bold">SOLO PARA CAMPAÑAS QUE REQUIERAN RESPUESTA. Cambiar el status de Pendiente a todos los que no han Contestado, para posterior ejecutar el botón - Enviar Mensajes Pendientes-</label>

                                                                
                                                        </div>

                                                        
                                                 </div>



                                                    <div class="modal-footer">
                                                    

                                                       <button
                                                            wire:click="continuarCampaña({{ $item->id }})"
                                                            type="button"
                                                            class="btn btn-success"
                                                            data-dismiss="modal"
                                                        >
                                                            Cambia Status a Pendiente
                                                        </button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            
                                 </div>
                             </div>
                             <!-- FIN Modal -->
           




                            <!-- INICIO Modal 2 -->
                            <div class="modal fade" id="continuarModal2-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="continuarModal2Label-{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                     
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="continuarModal2Label-{{ $item->id }}">Campaña: {{ $item->name }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mt-3 mb-3">
                                                                <label class="font-weight-bold">Mandar mensajes a los contactos que no se han mandado ( nuevos ), despues se deberá de presionar el botón - Enviar Mensajes Pendientes-</label>
 
                                                        </div>

                                                         
                                                                <div id="grupoSelectContainer-{{ $item->id }}">
                                                                   <select wire:model="grupo_id" name="group_id" class="form-control" required>
                                                                    <option value="">Selecciona un grupo</option>
                                                                    @foreach($groups as $group)
                                                                        <option value="{{ $group->id }}">
                                                                            {{ $group->name }} ({{ $group->contacts_count }} contactos)
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                                   
                                                           
                                                                   
                                                                </div>
                                                             
                                                 </div>



                                                    <div class="modal-footer">
                                                       

                                                       <button
                                                            wire:click="continuarCampañaAgrega({{ $item->id }})"
                                                            type="button"
                                                            class="btn btn-success"
                                                            data-dismiss="modal"
                                                        >
                                                            Mandar a nuevos contactos
                                                        </button>
                                                         <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            
                                 </div>
                             </div>
                             <!-- FIN Modal2 -->




                     @endif
                <hr/>
            @endforeach


            {{-- Paginación --}}
     
            <div class="d-flex justify-content-center">
                {{ $setup['items']->links('vendor.pagination.bootstrap-livewire') }}
            </div>
 

            @if (count($setup['items'])==0)
                <div style="display: flex; justify-content: center; width:100%;">
                    <div style="text-align: center">
                        <p style="text-align: center;"> 
                            {{ __('There are no campaigns, send your first one!')}}

                        </p>
                    <p style="text-align: center;"> 
                        <img style="max-height: 200px" src="{{  asset('uploads/default/wpbox/inbox.png') }}" />
                    </p>
                    
                    </div>
                
                </div>
            @endif
      
@section('js')

        
 


    <script>
            Livewire.on('confirm-delete', ({ id }) => {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción eliminará la campaña.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                   
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('eliminar-campaña', { id });
                    }
                });
            });
        </script>          
 

    <script>
            Livewire.on('confirm-borrarerrores', ({ id }) => {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción eliminará los errores.",
                    icon: 'info',
                     
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, proceder',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('eliminar-errores', { id });
                    }
                });
            });
        </script>          
 



<script>
    // INICIO PARA EL MULTIREPORTE 
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('multi-report-form');

        form.addEventListener('submit', function (e) {
            const selected = @this.get('selectedCampaigns');

            // Limpia inputs previos
            document.querySelectorAll('input[name="campaigns[]"]').forEach(e => e.remove());

            selected.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'campaigns[]';
                input.value = id;
                form.appendChild(input);
            });
        });
    });
    // FIN PARA EL MULTIREPORTE 
</script>

@endsection
   
</div>
