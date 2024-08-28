<?php

namespace App\Models\Agreements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramResolutionAmount extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agr_amounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'subtitle',
        'program_component_id',
        'program_resolution_id'
    ];

    /**
     * Get the program resolution that owns the amount.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program_resolution(): BelongsTo
    {
        return $this->belongsTo(ProgramResolution::class);
    }

    /**
     * Get the program component that owns the amount.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program_component(): BelongsTo
    {
        return $this->belongsTo(ProgramComponent::class)->withTrashed();
    }
}