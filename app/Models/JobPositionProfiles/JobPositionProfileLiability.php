<?php

namespace App\Models\JobPositionProfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class JobPositionProfileLiability extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jpp_profile_liabilities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // Add any datetime casts here if needed
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the liability that owns the job position profile liability.
     *
     * @return BelongsTo
     */
    public function liability(): BelongsTo
    {
        return $this->belongsTo(Liability::class, 'liability_id');
    }

    /**
     * Get the yes/no value attribute.
     *
     * @return string
     */
    public function getYesNoValueAttribute(): string
    {
        switch ($this->value) {
            case '0':
                return 'No';
            case '1':
                return 'Sí';
            default:
                return '';
        }
    }
}