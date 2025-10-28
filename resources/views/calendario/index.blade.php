
 @extends('general.index', $setup)
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />


@section('head')

   <style>
        :root {
            --primary: #3B82F6;
            --success: #10B981;
            --danger: #EF4444;
            --gray: #6B7280;
            --light-bg: #f8fafc;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
  
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
            border-radius: 12px;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }


          .whatsapp-green {
                color: #25D366; /* Color oficial de WhatsApp, un verde vibrante */
            }


    /*PARA EL MODAL*/

    
    /* Estilos personalizados para el modal */
    .whatsapp-green {
        color: #25D366 !important;
    }

    /* Hover effects para las cards */
    .modal-body .card {
        transition: transform 0.2s ease-in-out;
    }

    .modal-body .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Estilos para los badges de status */
    #modalStatus.badge {
        background-color: #17a2b8;
    }

    #modalCita.badge, #modalRecordatorio.badge {
        background-color: #28a745;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .modal-dialog {
            margin: 0.5rem;
        }
        
        .modal-body .col-md-6,
        .modal-body .col-md-4 {
            margin-bottom: 1rem;
        }
    }
    /*PARA EL MODAL*/








        .calendar-container {
            background-color: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        #calendar {
            margin-top: 20px;
        }
        
        .fc-toolbar-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1E293B;
        }
        
        .fc-button {
            background-color: var(--primary) !important;
            border: none !important;
            padding: 10px 15px !important;
            border-radius: 8px !important;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        
        .fc-button:hover {
            background-color: #2563EB !important;
            transform: translateY(-2px);
        }
        
        .fc-button:active {
            transform: translateY(0);
        }
        
        .fc-daygrid-event {
            border-radius: 6px;
            padding: 4px 8px;
            font-weight: 500;
            border: none;
        }

 


        .fc-event-title {
                        font-weight: 600;
                        font-size: 0.75em !important; /* Añade esta línea */
                        white-space: nowrap; /* Opcional: evita que el texto se divida en varias líneas */
                    }

                    .fc-event-time {
                        font-weight: 600;
                        font-size: 0.75em !important; /* Añade esta línea */
                        white-space: nowrap; /* Opcional: evita que el texto se divida en varias líneas */
                    }
                
                .divider {
                    background-color: #f1f5f9;
                    text-align: center;
                    padding: 5px;
                    font-weight: 600;
                    color: #64748b;
                }
                

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
                    max-width: 500px;
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
                
               
                
                .footer {
                    text-align: center;
                    margin-top: 30px;
                    padding: 20px;
                    color: #64748B;
                    font-size: 0.9rem;
                }
                
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
                
                @keyframes slideIn {
                    from { 
                        opacity: 0;
                        transform: translateY(-50px);
                    }
                    to { 
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                


        .refresh-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background-color: #3B82F6;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 20px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .refresh-btn:hover {
            background-color: #2563EB;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
        }

        .refresh-btn:active {
            transform: translateY(0);
        }

        .refreshing {
            animation: rotate 1s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }


            #contact-search {
            color: #000 !important;
        }

             

        /* Responsive */
        @media (max-width: 768px) {
            .fc-toolbar {
                flex-direction: column;
                gap: 15px;
            }
            
            .fc-toolbar-title {
                font-size: 1.4rem;
            }
            
            header h1 {
                font-size: 2rem;
            }
            
            .modal-content {
                width: 95%;
                padding: 20px;
            }
        }

    /* PARA EL COLOR DE LOS BOTONES*/
    /* Separar los botones del calendario */
        .fc-button-group .fc-button {
            margin-right: 3px !important; /* Espacio entre botones del mismo grupo */
        }

        .fc-button-group .fc-button:last-child {
            margin-right: 0 !important; /* Sin margen en el último botón */
        }

        /* Separar grupos de botones */
        .fc-button-group {
            margin-right: 8px !important; /* Espacio entre grupos de botones */
        }

        .fc-button-group:last-child {
            margin-right: 0 !important;
        }
 
        /* Cambiar botones de FullCalendar a verde */
        .fc-button-primary {
            background-color: #28a745 !important; /* Verde Bootstrap */
            border-color: #28a745 !important;
            color: white !important;
        }

        .fc-button-primary:hover {
            background-color: #218838 !important;
            border-color: #1e7e34 !important;
            color: white !important;
        }

        .fc-button-primary:focus,
        .fc-button-primary.fc-button-active {
            background-color: #1e7e34 !important;
            border-color: #1c7430 !important;
            color: white !important;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
        }

        /* Botón Today específicamente */
        .fc-today-button {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }

        /* Botones de navegación */
        .fc-prev-button,
        .fc-next-button {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }

        /* Tu botón de actualizar */
        .refresh-btn {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }
    
    /* FIN PARA EL COLOR DE LOS BOTONES*/

    /* PARA EL MODAL DEL CLIC DEL CALENDARIO Estilos para el modal compacto con scroll interno */

    .modal2 {
        display: none;
        align-items: center;      /* Centra verticalmente */
        justify-content: center;  /* Centra horizontalmente */
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(3px);
        overflow: hidden; /* Evita scroll en el fondo */
    }

    .modal2-content {
        background-color: #ffffff;
        margin: 2.5% auto;
        padding: 0;
        border: none;
        border-radius: 8px;
        width: 90%;
        max-width: 600px;
        max-height: 96vh; /* Punto intermedio entre 95vh y 97vh */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        animation: modalSlideIn 0.3s ease-out;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal2-header {
        background: linear-gradient(135deg, #d1f7ce 0%, #02af10 100%);
        color: white;
        padding: 11px 20px; /* Ligeramente más espacio */
        position: relative;
        flex-shrink: 0;
    }

    .modal2-header h2 {
        margin: 0;
        font-size: 1.17rem; /* Ligeramente más grande */
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .close {
        position: absolute;
        top: 7px; /* Intermedio: entre 6px y 8px */
        right: 15px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 24px;
        font-weight: 300;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        background: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        transform: rotate(90deg);
    }

    .modal2-body {
        padding: 14px 20px; /* Un poco más de padding */
        overflow-y: auto;
        flex: 1;
        max-height: calc(96vh - 105px); /* Ajustado para el nuevo header */
    }

    /* Scrollbar personalizado para mejor apariencia */
    .modal2-body::-webkit-scrollbar {
        width: 6px;
    }

    .modal2-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .modal2-body::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    .modal2-body::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    .info-card {
        background: #f8f9fa;
        border-radius: 6px;
        padding: 10px 14px; /* Intermedio: entre 8px-12px y 12px-15px */
        margin-bottom: 10px; /* Intermedio: entre 8px y 12px */
        border-left: 3px solid #667eea;
    }

    .info-row {
        display: flex;
        align-items: center;
        margin-bottom: 7px; /* Un poco más de espacio entre filas */
        padding: 5px 0; /* Ligeramente más padding */
        border-bottom: 1px solid #e9ecef;
    }

    .info-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .info-label {
        font-weight: 600;
        color: #495057;
        min-width: 105px; /* Intermedio: entre 100px y 110px */
        font-size: 0.82rem; /* Intermedio: entre 0.8rem y 0.85rem */
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .info-value {
        color: #212529;
        font-size: 0.92rem; /* Intermedio: entre 0.8rem y 0.85rem */
        flex: 1;
        line-height: 1.25; /* Intermedio: entre 1.2 y 1.3 */
    }

    .status-section {
        background: white;
        border-radius: 6px;
        border: 1px solid #e9ecef;
        overflow: hidden;
    }

    .status-header {
        background: #f8f9fa;
        padding: 8px 14px; /* Intermedio: entre 6px-12px y 10px-15px */
        border-bottom: 1px solid #e9ecef;
        font-weight: 600;
        color: #495057;
        font-size: 0.87rem; /* Intermedio: entre 0.85rem y 0.9rem */
    }

    .status-item {
        display: flex;
        align-items: center;
        padding: 7px 14px; /* Un poco más de padding */
        border-bottom: 1px solid #f1f3f4;
        transition: background-color 0.2s ease;
    }

    .status-item:last-child {
        border-bottom: none;
    }

    .status-item:hover {
        background-color: #f8f9fa;
    }

    .status-label {
        font-weight: 500;
        color: #6c757d;
        min-width: 115px; /* Intermedio: entre 110px y 120px */
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.77rem; /* Intermedio: entre 0.75rem y 0.8rem */
    }

    .status-value {
        flex: 1;
        font-size: 0.77rem;
    }

    .modal2-footer {
        background: #f8f9fa;
        padding: 8px 20px; /* Intermedio: entre 6px y 10px */
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 7px; /* Intermedio: entre 6px y 8px */
        justify-content: flex-end;
        flex-shrink: 0;
    }

    .modal2-footer .btn {
        display: flex;
        align-items: center;
        gap: 3px;
        font-size: 0.77rem; /* Intermedio: entre 0.75rem y 0.8rem */
        padding: 5px 11px; /* Intermedio: entre 4px-10px y 6px-12px */
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    /* Iconos con colores */
    .icon-user { color: #667eea; }
    .icon-phone { color: #28a745; }
    .icon-calendar { color: #ffc107; }
    .icon-clock { color: #17a2b8; }
    .icon-notes { color: #6f42c1; }
    .whatsapp-green { color: #25d366; }
    .status-indicator { color: #6d94e4; }

    /* Badges balanceados */
    .badge {
        font-size: 0.67rem; /* Intermedio: entre 0.65rem y 0.7rem */
        font-weight: 500;
        padding: 3px 7px; /* Intermedio: entre 2px-6px y 4px-8px */
        border-radius: 12px;
        line-height: 1.15;
    }

    /* Media query para laptops */
    @media (max-width: 1366px) {
        .modal2-content {
            margin: 2.5% auto;
            max-height: 97vh;
        }
        
        .modal2-body {
            max-height: calc(97vh - 95px);
        }
    }

    /* Responsive para tablets/móviles */
    @media (max-width: 768px) {
        .modal2-content {
            margin: 2.5% auto;
            width: 96%;
            max-height: 94vh;
        }
        
        .modal2-header {
            padding: 8px 15px;
        }
        
        .modal2-body {
            padding: 10px 15px;
            max-height: calc(94vh - 95px);
        }
        
        .info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 2px;
        }
        
        .info-label {
            min-width: auto;
            font-size: 0.92rem;
        }
        
        .info-value {
            font-size: 0.92rem;
        }
        
        .modal2-footer {
            padding: 8px 15px;
            flex-wrap: wrap;
            flex-shrink: 0;
        }
        
        .modal2-footer .btn {
            font-size: 0.88rem;
            padding: 6px 12px;
        }
    }

    /* Para pantallas muy pequeñas - móviles */
    @media (max-width: 480px) {
        .modal2-content {
            width: 95%;
            margin: 2% auto;
            max-height: 99vh;
            border-radius: 8px;
        }
        
        .modal2-body {
            max-height: calc(92vh - 90px);
            padding: 10px 15px;
        }
        
        .modal2-header {
            padding: 9px 15px;
        }
        
        .modal2-footer {
            padding: 8px 15px;
            flex-shrink: 0;
        }
    }


    /* fin del modal */
        
    </style>
 @endsection


 {{-- @section('content') --}}
 @section('cardbody')
 

 
                    <!-- Campo DOCTOR -->
                            <div class="row mb-3 mb-md-4">
                                <div class="col-12">
                                    <label for="doctor-filter" class="form-label small mb-1">{{ $companyLabels['label_responsable_name_singular'] }}</label>
                                    <select 
                                    
                                        id="doctor-filter" 
                                        class="form-select border py-2 w-100"
                                        
                                    >
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('doctor_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                <!-- Campo DOCTOR -->   


                    <livewire:calendar /> 
                    
                

                <!-- Modal para crear cita -->
                <div id="createAppointmentModal" class="modal">
                    <div class="modal-content">
                        <span class="close" id="closeCreateModal">&times;</span>
                        <br>
                        <livewire:appointments.create />  
                    
                        
                    </div>
                </div>

                

                <!-- Modal para Editar cita -->
                <div id="editarAppointmentModal" class="modal">
                    <div class="modal-content">
                        <span class="close" id="closeEditarModal">&times;</span>
                        <br>
                        <!-- el 0 es solo para que pase, ya al apretar el boton edit se pone el que este en el calendario -->
                        <livewire:appointments.update :appointmentId="0" /> 
                    </div>
                </div>

 
 
@endsection
   
