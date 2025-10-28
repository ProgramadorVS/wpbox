<x-guest-layout>

 
<div class="logo-section">
    <img class="navbar-brand-img" src="{{ config('settings.logo') }}" alt="Logo">
    <h1 class="clinic-name">Centro Integral de Asma y Alergia</h1>
    <p class="clinic-subtitle">ALEVER</p>
</div>

    <x-validation-errors class="mb-4" />

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600 text-center">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" id="loginform">
        @csrf

        <div class="form-group">
            <label for="email">Usuario</label>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input id="email" type="text" name="email"
                       class="form-control"
                       placeholder="tu usuario"
                       value="{{ old('email') }}"
                       required autofocus autocomplete="username">
            </div>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input id="password" type="password" name="password"
                       class="form-control"
                       placeholder="Tu contraseña"
                       required autocomplete="current-password">
            </div>
        </div>

        <div class="form-group" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="remember-me" style="display: flex; align-items: center;">
                <input id="remember_me" type="checkbox" name="remember" style="margin-right: 8px; accent-color: #2e7d32;">
                <label for="remember_me" style="font-size: 14px; color: #555;">Acuérdate de mí</label>
            </div>
            {{-- <a href="{{ route('password.request') }}" class="forgot-password">¿Olvidaste tu contraseña?</a> --}}
        </div>

        <button type="submit" class="btn-login">ACCESO</button>
       
         <div class="medical-icons">
            <i class="fas fa-stethoscope"></i>
            <i class="fas fa-user-md"></i>
            <i class="fas fa-pills"></i>
        </div>
    </form>
</x-guest-layout>

