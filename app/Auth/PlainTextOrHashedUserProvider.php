<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class PlainTextOrHashedUserProvider extends EloquentUserProvider
{
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $plain = $credentials['password'];

        $stored = $user->getAuthPassword();

        // Si la contraseña almacenada es un hash válido, usamos Hash::check
        if (strlen($stored) === 60 && preg_match('/^\$2[ayb]\$/', $stored)) {
            return Hash::check($plain, $stored);
        }

        // Caso contrario, asumimos que es texto plano y lo comparamos directamente
        return $plain === $stored;
    }
}
