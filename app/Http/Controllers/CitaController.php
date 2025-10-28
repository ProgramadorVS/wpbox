<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function confirmar($token=null)
    {
        return view('confirmar-cita', compact('token'));
    }
}