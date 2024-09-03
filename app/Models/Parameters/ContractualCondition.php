<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ContractualCondition extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use softDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'cfg_contractual_conditions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        //
    ];

    /**
     * Get the contractual condition that owns the model.
     */
    public function contractualCondition(): BelongsTo
    {
        return $this->belongsTo(ContractualCondition::class);
    }
}
