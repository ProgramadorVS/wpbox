<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmar Cita</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
       
        /* Cambiar color del ícono WARNING a rojo */
        .swal2-icon.swal2-warning   {
            border-color: #dc3545 !important; /* rojo */
            color: #dc3545 !important;
        }

        /* Cambiar color del ícono QUESTION a verde */
        .swal2-icon.swal2-question   {
            border-color: #28a745 !important; /* verde */
            color: #28a745 !important;
        }
       

      body {
            background-image: url('{{ asset('uploads/settings/FONDO.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center center;
            margin: 5px;
            padding: 5px;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        
       
        
        .card-custom {
            background: rgb(255, 255, 255);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }
        
        .logo-container {
            text-align: center;
            padding: 2rem 0 1rem 0;
            position: relative;
        }
        
        .logo {
            max-width: 200px;
            max-height: 171px;
            width: 200px;
            height: 171px;
           
            
            padding:5px;
             
            position: relative;
            overflow: hidden;
        }
        
   
        
        @keyframes shine {
            0%, 100% { 
                background-position: 0% 50%; 
                opacity: 0.8;
            }
            50% { 
                background-position: 100% 50%; 
                opacity: 1;
            }
        }
        
        .btn-confirm {
            background: linear-gradient(45deg, #28a745, #34ce57);
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            color: white;
            font-weight: 400;
            font-size: 16px;
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-confirm::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-confirm:hover::before {
            left: 100%;
        }
        
        .btn-confirm:hover {
            background: linear-gradient(45deg, #218838, #b7f2c5);
            box-shadow: 0 12px 35px rgba(40, 167, 69, 0.4);
            transform: translateY(-3px);
            color: white;
        }
        
        .btn-cancel {
            background: transparent;
            border: 2px solid #dc3545;
            padding: 13px 30px;
            border-radius: 50px;
            color: #dc3545;
            font-weight: 400;
            font-size: 16px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-cancel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: #dc3545;
            transition: width 0.3s ease;
            z-index: -1;
        }
        
        .btn-cancel:hover::before {
            width: 100%;
        }
        
        .btn-cancel:hover {
            color: white;
            border-color: #dc3545;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
        }
        
        .btn:disabled {
            opacity: 0.6;
            transform: none !important;
            box-shadow: none !important;
        }
        
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
        
        .alert-custom {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .cita-info {
            background: rgba(108, 117, 125, 0.08);
            border-radius: 15px;
            padding: 0.5rem;
            margin: 0.5rem 0;
            border: 1px solid rgba(108, 117, 125, 0.1);
        }
        
        .cita-info h5 {
            color: #495057;
            margin-bottom: 1rem;
        }
        
        .cita-info .row > div {
            margin-bottom: 0.8rem;
        }
        
        .cita-info strong {
            color: #343a40;
            font-size: 13px;
        }
        
        .cita-info .text-muted {
            color: #6c757d !important;
            font-size: 14px;
            margin-top: 2px;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
        
        .alert-custom {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }








        @media (max-width: 768px) {
            .card-custom {
                margin: 10px;
                border-radius: 14px;
            }
 
            
            .btn-confirm, .btn-cancel {
                padding: 12px 25px;
                font-size: 14px;
            }
            
            .cita-info {
                padding: 1rem;
                margin: 1rem 0;
            }
        }
    </style>
    
    @livewireStyles
</head>
<body>
    <div class="gradient-bg">
        @livewire('confirmar-cita', ['token' => $token])
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @livewireScripts
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    

     @stack('js')
 
</body>
</html>