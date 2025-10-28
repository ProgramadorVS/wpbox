@extends('general.index', $setup)
@section('contenttop')
<div class="card-body">
    <div class="row">
        <div class="col-12">

            <!-- Groups modal GRUPOS-->
            <div class="modal fade" id="move-to-group-modal" tabindex="-1" role="dialog" aria-labelledby="moveToGroupModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="moveToGroupModalLabel">{{ __('Asignar Grupo') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @foreach ($setup['groups'] as $group)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group" id="group-{{ $group->id }}" value="{{ $group->id }}">
                                    <label class="form-check-label" for="group-{{ $group->id }}">
                                        {{ $group->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar') }}</button>
                            <button type="button" class="btn btn-green" id="move-to-group-confirm">{{ __('Agregar') }}</button>
                        </div>
                    </div>
                </div>
            </div>
             <!-- Groups modal BORRAR GRUPO -->
            <div class="modal fade" id="remove-from-group-modal" tabindex="-1" role="dialog" aria-labelledby="removeFromGroupModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="removeFromGroupModalLabel">{{ __('Eliminar del Grupo') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @foreach ($setup['groups'] as $group)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="groupremove" id="group-{{ $group->id }}" value="{{ $group->id }}">
                                    <label class="form-check-label" for="group-{{ $group->id }}">
                                        {{ $group->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar') }}</button>
                            <button type="button" class="btn btn-green" id="remove-from-group-confirm">{{ __('Eliminar') }}</button>
                        </div>
                    </div>
                </div>
            </div>
  
  
            @if($setup['agent_enable']=="true")
             <!-- Groups modal AGENTES -->
                    <div class="modal fade" id="move-to-agent-modal" tabindex="-1" role="dialog" aria-labelledby="moveToAgentModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="moveToAgentModalLabel">{{ __('Asignar Agente') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @foreach ($setup['users'] as $user)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="user" id="user-{{ $user->id }}" value="{{ $user->id }}">
                                            <label class="form-check-label" for="user-{{ $user->id }}">
                                                {{ $user->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar') }}</button>
                                    <button type="button" class="btn btn-green" id="move-to-agent-confirm">{{ __('Agregar') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>

          
                    <!-- Groups modal BORRAR agent -->
                    <div class="modal fade" id="remove-from-agent-modal" tabindex="-1" role="dialog" aria-labelledby="removeFromAgentModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="removeFromAgentModalLabel">{{ __('Eliminar el Agente') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <p>{{ __('¿Estás seguro que deseas eliminar el agente de los contactos seleccionados?') }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar') }}</button>
                                    <button type="button" class="btn btn-danger" id="remove-from-agent-confirm">{{ __('Eliminar') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
            @endif
 
            <!-- Bulk action button, initially hidden -->
            <div class="btn-group" id="bulk-action-button" style="display: none;">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ni ni-archive-2"></i>
                    {{ __('Acción Masiva') }}
                </button>
                <div class="dropdown-menu">
                     @if(!auth()->user()->hasRole('client'))
                            <a class="dropdown-item" href="#" id="move-to-agent">{{ __('Asignar Agente') }}</a>
                            <a class="dropdown-item" href="#" id="remove-from-agent">{{ __('Borrar Agente') }}</a>
                            <a class="dropdown-item" href="#" id="delete-selected">{{ __('Borrar Selección') }}</a>
                    @endif
                            <a class="dropdown-item" href="#" id="move-to-group">{{ __('Asignar Grupo') }}</a>
                            <a class="dropdown-item" href="#" id="remove-from-group">{{ __('Borrar Grupo') }}</a>
                 
                </div>
            </div>

 
            <div class="col-12 mt-3">
                <span id="selected-count"></span>
            </div>
            
        </div>
    </div>
</div>
    
@endsection
@section('thead')
 <th class="text-center">
        <input type="checkbox" id="select-all">
    </th>
    <th class="text-center">#</th>
     <th>{{ __('Expediente') }}</th>
    <th>{{ __('Name') }}</th>
    <th>{{ __('Phone') }}</th>
   {{--   <th>{{ __('Email') }}</th>--}}
    <th>{{ __('Groups') }}</th>
   @if($setup['agent_enable']=="true")
        <th>{{ __('Agente') }}</th>
    @endif
        <th>{{ __('crud.actions') }}</th>
     


@endsection
@section('tbody')
    @foreach ($setup['items'] as $item)
       <tr class="{{ $loop->odd ? '' : 'table-active' }}">
            <td class="text-center">
                <input type="checkbox" class="select-item" value="{{ $item->id }}">
            </td>
            <td class="text-center">
                {{ $loop->iteration + ($setup['items']->currentPage() - 1) * $setup['items']->perPage() }}
            </td>
              <td>{{ $item->expediente }}</td>
             <td>{{ $item->name }}</td>
            <td>{{ substr($item->phone, 3) }}</td>
           
             {{-- <td>{{ $item->email }}</td>--}}
            <td>
                @foreach ($item->groups as $group)
                    <a href="/contacts/contacts?group={{ $group->id }}" class="badge badge-success">{{ $group->name }}</a>
                @endforeach
            </td>

           @if($setup['agent_enable']=="true")
            <!-- AGENTE -->
                    <td><span class="badge badge-info">{{ $item->user->name ?? 'Sin asignar' }}</span></td>
                  
            @endif

                  <td>
                <!-- CHAT -->
                @if(!auth()->user()->hasRole('client'))
                    <a href="{{ route('campaigns.create',['contact_id'=>$item->id]) }}" class="btn btn-outline-success btn-sm">
                        <span class="btn-inner--icon"><i class="ni ni-chat-round"></i></span>
                    </a>
                @endif


                @if(!auth()->user()->hasRole('client') || ($item->expediente == 'PRIMERA VEZ'))
                        <!-- EDIT -->
                        <a href="{{ route('contacts.edit',['contact'=>$item->id]) }}" class="btn btn-green btn-sm">
                            <i class="ni ni-ruler-pencil"></i>
                        </a>

                        <!-- DELETE -->
                    
                            <a href="#" 
                                class="btn btn-danger btn-sm eliminar-registro" 
                                data-id="{{ $item->id }}" 
                                data-url="{{ route('contacts.delete', ['contact' => $item->id]) }}">
                                <i class="ni ni-fat-remove"></i>
                            </a>
                @endif
                    </td>
                  
            
        </tr> 
    @endforeach
@endsection



@section('js')
 {{-- para poner la mascara en el telefono --}}

    @include('contacts::contacts.scripts')
    <!-- para la mascara de telefono -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.phone-mask').forEach(function(phoneInput) {
                
                phoneInput.addEventListener('input', function(e) {
                    // Solo permite números y limita a 13 dígitos
                    let value = e.target.value.replace(/\D/g, '');
                    
                    // Limita a 13 caracteres
                    if(value.length > 13) {
                        value = value.substring(0, 13);
                    }
                    
                    e.target.value = value;
                });
                
                // Previene pegar texto no numérico
                phoneInput.addEventListener('paste', function(e) {
                    setTimeout(() => {
                        e.target.value = e.target.value.replace(/\D/g, '').substring(0, 13);
                    }, 0);
                });
            });
        });
        </script>

        
@endsection