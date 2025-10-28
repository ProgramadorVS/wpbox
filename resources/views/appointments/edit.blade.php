
 @extends('general.index', $setup)

 @section('head')


  <style>
        .form-select {
            border-radius: 0.375rem !important;
            padding: 0.5rem 1rem;
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
            box-shadow: none !important;
        }

        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        }

        /* Flecha personalizada (si no usas Font Awesome) */
        .form-select {
            background-image: none; /* Elimina la flecha por defecto */
            padding-right: 2.5rem; /* Espacio para el ícono */
        }


 
    .hover-bg-light:hover {
        background-color: #f8f9fa;
    }
    
    .cursor-pointer {
        cursor: pointer;
    }
    
    .z-10 {
        z-index: 10;
    }
    
 /* Eliminar icono de reloj */
input[type="time"]::-webkit-calendar-picker-indicator {
    display: none;
}

 </style>
 @endsection


 @section('cardbody')
   

     <livewire:appointments.update :appointmentId="$appointment->id" />
                
 @endsection

 
 