<?php
namespace Modules\Wpbox\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class MessageDailyLimit extends Model
{
    protected $fillable = ['company_id', 'fecha', 'total_programados'];

    // Opcional, si tienes relaciones
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}