<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
    protected $fillable = [
        'user_id',
        'ip_address',
        'actividad',
        'last_activity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
