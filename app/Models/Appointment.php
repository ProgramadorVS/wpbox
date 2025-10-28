<?php

namespace App\Models;
use Modules\Contacts\Models\Contact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Wpbox\Models\Message;
use App\Models\Company as Company;
use App\Scopes\CompanyScope;
 


class Appointment extends Model
{
    use HasFactory;
    protected $table = 'citas';
    protected $guarded = [];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }


  public function messages()
    {
        return $this->hasMany(Message::class, 'cita_id', 'id');
    }


   /**
     * Relación con la compañía
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }


    /**
     * Relación con el doctor
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }


    protected static function booted(){
        static::addGlobalScope(new CompanyScope);

        static::creating(function ($model){
           $company_id=session('company_id',null);
            if($company_id){
                $model->company_id=$company_id;
            }
        });
    }
}
