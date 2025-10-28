
 @extends('general.index', $setup)
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
@section('head')
 
<style>
    .form-select,
    .form-control,
    .btn {
        transition: all 0.3s ease;
        border-radius: 0.375rem !important;
    }

    .form-select:focus,
    .form-control:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%236c757d' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        padding-right: 2rem;
    }
.card-body {
  flex: 1 1 auto;
  padding: 1rem;
}

 
    .table-active1 {
        background-color: #fcfcfc; /* Gris claro para filas pares */
    }
 

    .whatsapp-green {
    color: #25D366; /* Color oficial de WhatsApp, un verde vibrante */
}

    /* Mejora la distribución en pantallas pequeñas */
    @media (max-width: 767.98px) {
        .filters-container .row > div {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>
 @endsection


 @section('cardbody')

      <livewire:appointments.appointment-list />
               
    @endsection
   
 