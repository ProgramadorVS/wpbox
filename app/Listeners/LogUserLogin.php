<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;
 

class LogUserLogin
{
    public function handle(Login $event)
    {
       

       
        DB::table('logs')->insert([
            'user_id' => $event->user->id,
            'ip_address' => request()->ip(),
            'actividad' => 'login',
        ]);
     
    }
}