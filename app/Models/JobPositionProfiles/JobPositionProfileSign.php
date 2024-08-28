<?php

namespace App\Models\JobPositionProfiles;

use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class JobPositionProfileSign extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jpp_job_position_profile_signs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'position',
        'event_type',
        'status',
        'observation',
        'date_sign'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_sign' => 'datetime'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Get the organizational unit that owns the job position profile sign.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'organizational_unit_id')->withTrashed();
    }

    /**
     * Get the user that owns the document.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the status value attribute.
     *
     * @return string
     */
    public function getStatusValueAttribute(): string
    {
        switch ($this->status) {
            case 'pending':
                return 'Pendiente de Aprobación';
            case 'accepted':
                return 'Aceptada';
            case 'rejected':
                return 'Rechazada';
            default:
                return 'Pendiente de Aprobación';
        }
    }
}