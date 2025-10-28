<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Portal Médico') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    <!-- Custom Login Style -->
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        body {
            display: flex; justify-content: center; align-items: center;
            min-height: 100vh;
            /* background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 25%, #dcfce7 50%, #d1fae5 75%, #ecfdf5 100%); */
            overflow: hidden; position: relative;
               background-image: url('/uploads/settings/FONDO.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: center center;
                font-size: 14px
        }

     
        .medical-pattern {
            position: absolute; width: 100%; height: 100%; opacity: 0.05;
            
        }

        .login-container {
            position: relative; z-index: 1;
            width: 400px; padding: 40px;
            background: rgba(255,255,255,0.95);
            border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px); overflow: hidden;
        }

        .login-container::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 5px;
            background: linear-gradient(90deg, #2e7d32, #66bb6a, #2e7d32);
            background-size: 200% 100%; animation: gradient 3s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
          .navbar-brand-img 
            {
                max-width: 100% !important;
                max-height: 10rem !important;
            }
            /* 🔻 En pantallas móviles (menores a 768px) */
            @media (max-width: 768px) {
                .navbar-brand-img {
                    max-height: 10rem !important;
                }
            }

        .logo-section {
            display: flex;
            flex-direction: column;
            align-items: center;  /* centra horizontal */
            justify-content: center; /* opcional, centra vertical si el contenedor tiene altura fija */
            text-align: center;
           
        }
 
        .clinic-name { font-size: 20px; font-weight: 600; color: #2e7d32; margin-bottom: 5px; }
        .clinic-subtitle { font-size: 14px; color: #666; }

        .form-group { margin-bottom: 20px; position: relative; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: #333; font-size: 14px; }
        .input-group { position: relative; }
        .input-group i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #2e7d32; }

        .form-control {
            width: 100%; padding: 12px 15px 12px 45px;
            border: 1px solid #ddd; border-radius: 8px;
            font-size: 18px; transition: all 0.3s; background-color: #f9f9f9;
        }
        .form-control:focus {
            border-color: #2e7d32; box-shadow: 0 0 0 3px rgba(46,125,50,0.1);
            outline: none; background-color: white;
        }

        .btn-login {
            width: 100%; padding: 12px;
            background: linear-gradient(135deg, #2e7d32, #66bb6a);
            color: white; border: none; border-radius: 8px;
            font-size: 18px; font-weight: 600; cursor: pointer;
            transition: all 0.3s; box-shadow: 0 4px 10px rgba(46,125,50,0.3);
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(46,125,50,0.4); }
        .btn-login:active { transform: translateY(0); }

    
        .medical-icons {
            position: absolute;
            bottom: 10px;
            right: 20px;
            display: flex;
            gap: 10px;
            opacity: 0.2;
        }
        
        .medical-icons i {
            font-size: 24px;
            color: #2e7d32;
        }
        
   

        @media (max-width: 480px) {
            .login-container { width: 90%; padding: 30px 20px; }
        }
    </style>
</head>

<body>
    <div >
        <div class="medical-pattern"></div>
    </div>

    <div class="login-container">
        {{ $slot }}
    </div>
</body>
</html>
