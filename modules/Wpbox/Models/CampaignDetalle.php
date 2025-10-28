<?php
// app/Models/CampaignDetalle.php
namespace Modules\Wpbox\Models;
 
use Illuminate\Database\Eloquent\Model;

// Ensure the Group model exists and is imported
use Modules\Contacts\Models\Group;

class CampaignDetalle extends Model
{
    protected $table = 'wa_campaigns_detalles';
    protected $fillable = ['campaign_id', 'group_id'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}