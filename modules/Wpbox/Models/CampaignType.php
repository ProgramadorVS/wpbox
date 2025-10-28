<?php
 
namespace Modules\Wpbox\Models;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class CampaignType extends Model
{
    protected $table = 'wa_campaings_tipo';
    public $timestamps = false;
    protected $fillable = ['name', 'company_id'];
    protected $primaryKey = 'id';
     public $incrementing = true;
    protected $keyType = 'int';
    public $guarded = [];

    // 🔗 Relación: un tipo → muchas campañas
    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'idtipocampaña', 'id');
        //          ^ modelo hijo       ^ foreign key en wa_campaings  ^ local key
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