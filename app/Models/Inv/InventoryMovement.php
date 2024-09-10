<?php

namespace App\Models\Inv;

use App\Models\Parameters\Place;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use App\Notifications\Inventory\ItemReception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class InventoryMovement extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inv_inventory_movements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'reception_date' => 'date:Y-m-d H:i:s',
        'installation_date' => 'date',
    ];

    /**
     * Get the inventory that owns the inventory movement.
     */
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * Get the place that owns the inventory movement.
     */
    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }

    /**
     * Get the responsible organizational unit that owns the inventory movement.
     */
    public function responsibleOrganizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'user_responsible_ou_id');
    }

    /**
     * Get the responsible user that owns the inventory movement.
     */
    public function responsibleUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_responsible_id')->withTrashed();
    }

    /**
     * Get the using organizational unit that owns the inventory movement.
     */
    public function usingOrganizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'user_using_ou_id');
    }

    /**
     * Get the using user that owns the inventory movement.
     */
    public function usingUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_using_id')->withTrashed();
    }

    /**
     * Get the sender user that owns the inventory movement.
     */
    public function senderUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_sender_id')->withTrashed();
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($movement) {
            /** Enviar notificación al responsable  */
            if ($movement->user_responsible_id) {
                $movement->responsibleUser?->notify(new ItemReception($movement));
            }
        });
    }
}
