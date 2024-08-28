<?php

namespace App\Models\Agreements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Agreements\Program;
use App\Models\Agreements\Signer;
use App\Models\Agreements\ProgramResolutionAmount;

class ProgramResolution extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agr_program_resolutions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'date',
        'file',
        'program_id',
        'director_signer_id',
        'referrer_id',
        'res_exempt_number',
        'res_exempt_date',
        'res_resource_number',
        'res_resource_date',
        'establishment'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'res_exempt_date' => 'date',
        'res_resource_date' => 'date',
    ];

    /**
     * Get the program that owns the resolution.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the referrer that owns the resolution.
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the director signer that owns the resolution.
     */
    public function director_signer(): BelongsTo
    {
        return $this->belongsTo(Signer::class);
    }

    /**
     * Get the resolution amounts for the resolution.
     */
    public function resolution_amounts(): HasMany
    {
        return $this->hasMany(ProgramResolutionAmount::class);
    }
}