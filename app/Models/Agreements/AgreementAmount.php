<?php

namespace App\Models\Agreements;

use App\Models\Agreements\Agreement;
use App\Models\Agreements\ProgramComponent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgreementAmount extends Model
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
        'agreement_id',
        'program_component_id'
    ];

    /**
     * Get the agreement.
     */
    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class);
    }

    /**
     * Get the program component.
     */
    public function program_component(): BelongsTo
    {
        return $this->belongsTo(ProgramComponent::class)->withTrashed();
    }
}
