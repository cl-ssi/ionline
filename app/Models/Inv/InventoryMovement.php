<?php

namespace App\Models\Inv;

use App\Models\Parameters\Place;
use App\Rrhh\OrganizationalUnit;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class InventoryMovement extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, SoftDeletes;

    protected $table = 'inv_inventory_movements';

    protected $fillable = [
        'reception_confirmation',
        'reception_date',
        'installation_date',
        'observations',
        'inventory_id',
        'place_id',
        'user_responsible_ou_id',
        'user_responsible_id',
        'user_using_ou_id',
        'user_using_id',
        'user_sender_id',
    ];

    protected $dates = [
        'installation_date',
    ];

    protected $casts = [
        'reception_date' => 'date:Y-m-d H:i:s'
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function responsibleOrganizationalUnit()
    {
        return $this->belongsTo(OrganizationalUnit::class, 'user_responsible_ou_id');
    }

    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'user_responsible_id');
    }

    public function usingOrganizationalUnit()
    {
        return $this->belongsTo(OrganizationalUnit::class, 'user_using_ou_id');
    }

    public function usingUser()
    {
        return $this->belongsTo(User::class, 'user_using_id');
    }

    public function senderUser()
    {
        return $this->belongsTo(User::class, 'user_sender_id');
    }
}
