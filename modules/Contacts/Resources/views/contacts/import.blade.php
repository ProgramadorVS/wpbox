@extends('layouts.app', ['title' =>  __("Importar Contactos CSV") ])


@section('content')
    <div class="header  pb-8 pt-5 pt-md-8">
    </div>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __("Importar Contactos CSV") }}</h3>
                  <br>
                                    Se debe de tomar el archivo CSV guardado en formato CSV UTF-8, los telefonos con 10 caracteres.
                                
                            </div>
                            
                               
                        </div>
                       
                    </div>

                    <div class="col-12">
                        @include('partials.flash')
                    </div>

                   
                       <div class="card-body">
                            <form action="{{ route('contacts.import.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @include('partials.input',['additionalInfo'=>"Encabezados Expediente, telefono,nombre,grupo,agente, ( OJO con el campo Observaciones: Si no se pone no se modifica, si se pone sobreescribe [puede ser nulo para limpiar]) y los que se crearan ( MINUSCULAS )",'class'=>'col-md-4','name'=>"CSV file",'id'=>'csv','type'=>'file','placeholder'=>"",'required'=>true,'accept'=>".csv"])
                            
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success ml-3 mt-2" >{{ __('Importar contactos')}}</button>
                                </div>
                                
                            </form>
                        </div>
                   
                    
     
         


                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
