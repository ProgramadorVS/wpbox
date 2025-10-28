<?php

namespace App\Models;

use App\Models\Company;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctores'; // nombre exacto de la tabla

    protected $guarded = []; // o define solo los fillables si prefieres seguridad

    // Aplica el scope y setea automáticamente el company_id al crear
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);

        static::creating(function ($model) {
            $company_id = session('company_id', null);
            if ($company_id) {
                $model->company_id = $company_id;
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}