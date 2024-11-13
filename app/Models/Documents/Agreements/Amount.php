<?php

namespace App\Models\Documents\Agreements;

use App\Models\Parameters\ProgramComponent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Amount extends Model
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
        'process_id',
        'program_component_id'
    ];

    /**
     * Get the process.
     */
    public function process(): BelongsTo
    {
        return $this->belongsTo(Process::class);
    }

    /**
     * Get the program component.
     */
    public function programComponent(): BelongsTo|Builder
    {
        return $this->belongsTo(ProgramComponent::class)->withTrashed();
    }
}
