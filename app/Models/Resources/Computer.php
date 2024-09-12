<?php

namespace App\Models\Resources;

use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryLabel;
use App\Models\Parameters\Place;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Computer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'res_computers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active_type',
        'brand',
        'comment',
        'domain',
        'fusion_at',
        'hostname',
        'id',
        'intesis_id',
        'inventory_id',
        'inventory_number',
        'ip',
        'ip_group',
        'mac_address',
        'model',
        'network_segment',
        'office_serial',
        'operating_system',
        'place_id',
        'processor',
        'rack',
        'ram',
        'serial',
        'status',
        'type',
        'vlan',
        'windows_serial',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'fusion_at' => 'datetime',
    ];

    /**
     * Get the users associated with the computer.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'res_computer_user')->withTimestamps();
    }

    /**
     * Get the place associated with the computer.
     */
    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }

    /**
     * Get the inventory associated with the computer.
     */
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * Get the labels associated with the computer.
     */
    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(InventoryLabel::class, 'res_computer_label', 'computer_id', 'label_id')
            ->using(ComputerLabel::class)
            ->withPivot(['computer_id', 'label_id'])
            ->withTimestamps();
    }

    /**
     * Check if the computer is merged.
     */
    public function isMerged(): bool
    {
        return $this->fusion_at != null;
    }

    /**
     * Scope a query to search computers.
     */
    public function scopeSearch($query, $search)
    {
        if ($search != '') {
            return $query->where('brand', 'LIKE', '%'.$search.'%')
                ->orWhere('model', 'LIKE', '%'.$search.'%')
                ->orWhere('ip', 'LIKE', '%'.$search.'%')
                ->orWhere('serial', 'LIKE', '%'.$search.'%')
                ->orWhere('inventory_number', 'LIKE', '%'.$search.'%');
        }
    }

    /**
     * Get the type of the computer.
     */
    public function tipo(): string
    {
        switch ($this->type) {
            case 'desktop':
                return 'PC Escritorio';
            case 'all-in-one':
                return 'PC all-in-one';
            case 'notebook':
                return 'PC Notebook';
            case 'other':
                return 'PC Otro';
            default:
                return '';
        }
    }

    /**
     * Get the active type of the computer.
     */
    public function tipoActivo(): string
    {
        switch ($this->active_type) {
            case 'leased':
                return 'Arrendado';
            case 'own':
                return 'Propio';
            case 'user':
                return 'Usuario';
            default:
                return '';
        }
    }
}
