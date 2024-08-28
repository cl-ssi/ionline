<?php

namespace App\Models\Allowances;

use App\Models\ClCommune;
use App\Models\ClLocality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Destination extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alw_destinations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'commune_id',
        'locality_id',
        'description',
        'allowance_id'
    ];

    /**
     * Get the allowance that owns the destination.
     *
     * @return BelongsTo
     */
    public function allowance(): BelongsTo
    {
        return $this->belongsTo(Allowance::class, 'allowance_id');
    }

    /**
     * Get the commune that owns the destination.
     *
     * @return BelongsTo
     */
    public function commune(): BelongsTo
    {
        return $this->belongsTo(ClCommune::class, 'commune_id');
    }

    /**
     * Get the locality that owns the destination.
     *
     * @return BelongsTo
     */
    public function locality(): BelongsTo
    {
        return $this->belongsTo(ClLocality::class, 'locality_id');
    }
}