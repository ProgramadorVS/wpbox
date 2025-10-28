<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        @yield('title')
        <title>{{ config('app.name', 'Site') }}</title>

         <!-- Fonts -->
         <link rel="preconnect" href="https://fonts.bunny.net">
         <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


        
        <!-- Icons -->
        <link href="{{ asset('vendor/argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link type="text/css" href="{{ asset('vendor/argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('vendor') }}/jasny/css/jasny-bootstrap.min.css">
   

        @yield('head')

        @include('layouts.rtl')

        <!-- Custom CSS defined by admin -->
        <link type="text/css" href="{{ asset('byadmin') }}/back.css" rel="stylesheet">

        <!-- Select2  -->
        <link type="text/css" href="{{ asset('vendor') }}/select2/select2.min.css" rel="stylesheet">

        <!-- Custom CSS defined by user -->
        <link type="text/css" href="{{ asset('custom') }}/css/custom.css?id={{ config('version.version')}}" rel="stylesheet">

        <!-- Flags -->
        <link type="text/css" href="{{ asset('vendor') }}/flag-icons/css/flag-icons.min.css" rel="stylesheet" />

        <!-- Bootstap VUE -->
        <link type="text/css" href="{{ asset('vendor') }}/vue/bootstrap-vue.css" rel="stylesheet" />

      
        <style>
            .swal2-small-text .swal2-title {
                font-size: 1rem !important; /* Título más pequeño */
            }

            .swal2-small-text .swal2-html-container {
                font-size: 0.9rem !important; /* Texto del contenido */
            }

            .swal2-small-text .swal2-confirm {
                font-size: 0.9rem !important; /* Botón */
            }
/* para los margenes de los lados del card */
            .main-content .container-fluid {
                padding-right: 20px !important;
                padding-left: 20px !important;
            }
            .navbar-brand-img 
            {
                max-width: 100% !important;
                max-height: 10rem !important;
            }


            /* para los botones verdes */
.btn-green {
    background-color: #4caf50 !important;
    border-color: #4caf50 !important;
    color: #ffffff !important; /* texto blanco */
}

.btn-green:hover,
.btn-green:focus,
.btn-green:active {
    background-color: #43a047 !important;
    border-color: #388e3c !important;
    color: #ffffff !important; /* mantener texto blanco */
}
/* =======fin para los botones verdes =====*/


/* ====== para el usuario en el topbar ====== */

/* Contenedor principal con fondo y borde - MÁS COMPACTO */
.user-profile-box {
    padding: 6px 10px !important;
    background: #e8f5e9 !important;
    border: 1px solid #c8e6c9 !important;
    border-radius: 6px !important;
    display: inline-flex !important;
    width: auto !important;
    gap: 8px !important;
}

/* Avatar con iniciales - MÁS PEQUEÑO */
.avatar-circle {
    width: 34px !important;
    height: 34px !important;
    border-radius: 50% !important;
    background: linear-gradient(135deg, #43a047 0%, #66bb6a 100%) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12) !important;
}

.avatar-initials {
    color: #ffffff !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
}

/* Media body sin margin extra */
.user-profile-box .media-body {
    margin-left: 0 !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
}

/* Ajustes para el texto - MÁS PEQUEÑO */
.user-profile-box .media-body .text-sm {
    line-height: 1.2 !important;
    color: #2d3748 !important;
    font-size: 13px !important;
    margin-bottom: 1px !important;
}

.user-profile-box .media-body .text-xs {
    font-size: 10px !important;
    color: #4a5568 !important;
    line-height: 1.2 !important;
}

/* ==== fin para el usuario en el topbar ==== */


 /* === INICIO DE OVERRIDES === */
.card.card-stats {
    background: var(--white) !important;
    border-radius: 15px !important;
    box-shadow: var(--shadow-light, 0 2px 8px rgba(0,0,0,0.1)) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: flex-start !important;
    padding: 15px 10px !important;
    gap: 10px !important;
    transition: all 0.3s ease !important;
    position: relative !important;
    overflow: hidden !important;
    border: none !important;
    flex-direction: row !important;
}

.card.card-stats::before {
    content: '' !important;
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 4px !important;
    height: 100% !important;
    background: linear-gradient(to bottom, var(--primary-green, #4caf50), var(--light-green, #81c784)) !important;
}

.card.card-stats:hover {
    transform: translateY(-5px) !important;
    box-shadow: var(--shadow-medium, 0 4px 12px rgba(0,0,0,0.15)) !important;
}

/* Ícono a la izquierda */
.card.card-stats .icon {
    flex-shrink: 0 !important;
    width: 45px !important;
    height: 45px !important;
    border-radius: 12px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 22px !important;
    background: rgba(76, 175, 80, 0.1) !important;
    color: #4caf50 !important;
    box-shadow: none !important;
    margin-right: 8px !important;
}

/* Contenido de texto */
.card.card-stats .card-body {
    padding: 0 !important;
    flex: 1 !important;
    min-width: 0 !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: stretch !important; /* Hace que los hijos ocupen todo el ancho */
}

.card.card-stats .card-body .row {
    display: flex !important;
    align-items: center !important;
    justify-content:  !important;
    margin: 0 !important;
}

.card.card-stats .col {
    padding: 0 !important;
}

.card.card-stats .col-auto {
    order: -1 !important;
    padding: 0 !important;
}

/* Título y valor */
.card.card-stats .card-title {
    font-size: 12px !important;
    color: var(--gray-dark, #555) !important;
    opacity: 0.8 !important;
    margin-bottom: 5px !important;
    text-align: left !important;
    line-height: 1.2 !important;
    word-break: break-word !important;
}

.card.card-stats .h2 {
    font-size: 24px !important;
    font-weight: 700 !important;
    color: var(--gray-dark, #333) !important;
    margin-bottom: 5px !important;
    text-align: center !important;
}

/* Subtexto centrado - SIMPLIFICADO */
.card.card-stats p.text-sm {
    font-size: 11px !important;
    color: var(--gray-dark, #666) !important;
    margin: 8px 0 0 0 !important;
    padding: 0 !important;
    text-align: left !important;
    width: 100% !important;
}

.card.card-stats p.text-sm span {
    font-weight: 600 !important;
    padding: 2px 6px !important;
    border-radius: 12px !important;
    display: inline-block !important;
}

.card.card-stats p.text-sm .text-success {
    background: rgba(76, 175, 80, 0.1) !important;
    color: #4caf50 !important;
}

.card.card-stats p.text-sm .text-danger {
    background: rgba(244, 67, 54, 0.1) !important;
    color: #f44336 !important;
}

/* === FIN DE OVERRIDES === */

/* PARA LOS MENUS */


/* Enlaces del menú */
.navbar-nav .nav-link {
    border-radius: 8px !important;
    transition: all 0.3s ease !important;
}

/* Hover: verde suave de fondo, texto e ícono verdes */
.navbar-nav .nav-link:hover {
    background-color: rgba(76, 175, 80, 0.15) !important; /* verde suave translúcido */
    color: #4caf50 !important; /* texto verde */
}

/* Íconos también verdes en hover */
.navbar-nav .nav-link:hover i {
    color: #4caf50 !important;
}

/* Enlace activo: un poco más fuerte pero sin exagerar */
.navbar-nav .nav-link.active {
    background-color: rgba(76, 175, 80, 0.25) !important;
    color: #4caf50 !important;
}

.navbar-nav .nav-link.active i {
    color: #4caf50 !important;
}


/* FIN PARA LOS MENUS */


            /* 🔻 En pantallas móviles (menores a 768px) */
            @media (max-width: 768px) {
                .navbar-brand-img {
                    max-height: 6rem !important;
                }
            }



        </style>

 

      @livewireStyles

    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('admin.navbars.sidebar')
        @endauth

        <div class="main-content">
            @include('admin.navbars.navbar')
            @yield('content')
        </div>

        @guest()
           
        @endguest

            <!-- Commented because navtabs includes same script -->
           

            @yield('topjs')
    
            <script>
                var t="<?php echo 'translations'.App::getLocale() ?>";
               window.translations = {!! Cache::get('translations'.App::getLocale(),"[]") !!};
               
               
            </script>
            
            <!-- Navtabs -->
            <script src="{{ asset('vendor') }}/jquery/jquery.min.js" type="text/javascript"></script>
            <script src="{{ asset('vendor/argon') }}/js/popper.min.js" type="text/javascript"></script>
            

            <script src="{{ asset('vendor/argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    
            <!-- Nouslider -->
            <script src="{{ asset('vendor/argon') }}/vendor/nouislider/distribute/nouislider.min.js" type="text/javascript"></script>
    
            <!-- Latest compiled and minified JavaScript -->
            <script src="{{ asset('vendor') }}/jasny/js/jasny-bootstrap.min.js"></script>
    
   
            <!-- All in one -->
            <script src="{{ asset('custom') }}/js/js.js?id={{ config('version.version')}}"></script>

            <!-- Notify JS -->
            <script src="{{ asset('custom') }}/js/notify.min.js"></script>
    
            <!-- Argon JS -->
            <script src="{{ asset('vendor/argon') }}/js/argon.js?v=1.0.0"></script>

    
    
            <script>
                var ONESIGNAL_APP_ID = "{{ config('settings.onesignal_app_id') }}";
                var USER_ID = '{{  auth()->user()&&auth()->user()?auth()->user()->id:"" }}';
                var PUSHER_APP_KEY = "{{ config('broadcasting.connections.pusher.key') }}";
               
                var PUSHER_APP_CLUSTER = "{{ config('broadcasting.connections.pusher.options.cluster') }}";
            </script>
            @if (auth()->user()!=null&&auth()->user()->hasRole('staff'))
                <script>
                    //When staff, use the owner
                    USER_ID = '{{ auth()->user()->company->user_id }}';
                </script>
            @endif
           
    
            <!-- OneSignal -->
            @if(strlen( config('settings.onesignal_app_id'))>4)
                <script src="{{ asset('vendor') }}/OneSignalSDK/OneSignalSDK.js" async=""></script>
                <script src="{{ asset('custom') }}/js/onesignal.js"></script>
            @endif
    

            @livewireScripts
         <!-- Sweet Alert-->

             <script>
                Livewire.on('notify', ({ type, message }) => {
                    Swal.fire({
                        icon: type,
                        title: message,
                        showConfirmButton: true,
                        customClass: 'swal2-small-text',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false, // No se cierra si se hace clic fuera
                        allowEscapeKey: false     // No se cierra con la tecla ESC
                    });
                });
            </script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                         <script>
                            Livewire.on('notify2', ({ type, message }) => {
                                Swal.fire({
                                    toast: true,
                                    position: 'center',
                                    icon: type,
                                    title: message,
                                    showConfirmButton: true,
                                    timer: null
                                });
                            });
                        </script> 

     
            @stack('js')
            @yield('js')
    

 
             <!-- Pusher -->
             @if(strlen(config('broadcasting.connections.pusher.app_id'))>2)
                <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
                @if (config('settings.app_code_name','')=="qrpdf")
                    <script src="{{ asset('custom') }}/js/pusher.js"></script>    
                @endif
            @endif

            <!-- Import Select2 --->
            <script src="{{ asset('vendor') }}/select2/select2.min.js"></script>
    
            <!-- Custom JS defined by admin -->
            <script src="{{ asset('byadmin') }}/back.js"></script>
 
            

            <!-- Import Moment -->
            <script type="text/javascript" src="{{ asset('vendor') }}/moment/moment.min.js"></script>
            <script type="text/javascript" src="{{ asset('vendor') }}/moment/momenttz.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/es.min.js"></script> 

            <script src="{{ asset('vendor/argon') }}/js/bootstrap.min.js" type="text/javascript"></script>
            
            <!-- Import Vue -->
            <script src="{{ asset('vendor') }}/vue/vue.js"></script>
            <script src="{{ asset('vendor') }}/vue/bootstrap-vue.min.js"></script> 
            
 
        
            <!-- Import AXIOS --->
            <script src="{{ asset('vendor') }}/axios/axios.min.js"></script>

            <?php 
                echo file_get_contents(base_path('public/byadmin/back.js')) 
            ?>
    
   
    </body>
</html>
