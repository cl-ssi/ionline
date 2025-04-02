<?php

namespace App\Models\Pharmacies;

use App\Models\Establishment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fractionation extends Model
{
    use SoftDeletes;

    protected $table = 'frm_fractionations';

    protected $fillable = [
        'date',
        'pharmacy_id',
        'origin_establishment_id',
        'patient_id',
        'acquirer',
        'medic_id',
        'qf_supervisor_id',
        'fractionator_id',
        'notes',
        'inventory_adjustment_id'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function originEstablishment(): BelongsTo 
    {
        return $this->belongsTo(Establishment::class, 'origin_establishment_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function medic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'medic_id');
    }

    public function qfSupervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'qf_supervisor_id');
    }

    public function fractionator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'fractionator_id');
    }

    public function inventoryAdjustment(): BelongsTo
    {
        return $this->belongsTo(InventoryAdjustment::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(FractionationItem::class);
    }
}
