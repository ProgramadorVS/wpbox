<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventBackHistoryCache
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Primero, dejamos que Laravel procese la solicitud y obtenga la respuesta
        $response = $next($request);

        // Ahora, añadimos estas cabeceras a la respuesta ANTES de enviarla
        // Estas 3 líneas le dicen a todos los navegadores que no
        // guarden esta página en caché.
        $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT'); // Una fecha en el pasado

        return $response;
    }
}