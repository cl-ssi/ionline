<?php

namespace App\Models\ProfAgenda;

use App\Models\Parameters\Profession;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class OpenHour extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prof_agenda_open_hours';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'proposal_detail_id',
        'start_date',
        'end_date',
        'patient_id',
        'external_user_id',
        'contact_number',
        'observation',
        'blocked',
        'deleted_bloqued_observation',
        'assistance',
        'absence_reason',
        'profesional_id',
        'profession_id',
        'activity_type_id',
        'reserver_id',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Get the proposal detail associated with the open hour.
     *
     * @return BelongsTo
     */
    public function detail(): BelongsTo
    {
        return $this->belongsTo(ProposalDetail::class, 'proposal_detail_id');
    }

    /**
     * Get the patient associated with the open hour.
     *
     * @return BelongsTo
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id')->withTrashed();
    }

    /**
     * Get the external user associated with the open hour.
     *
     * @return BelongsTo
     */
    public function externalUser(): BelongsTo
    {
        return $this->belongsTo(ExternalUser::class, 'external_user_id')->withTrashed();
    }

    /**
     * Get the professional associated with the open hour.
     *
     * @return BelongsTo
     */
    public function profesional(): BelongsTo
    {
        return $this->belongsTo(User::class, 'profesional_id')->withTrashed();
    }

    /**
     * Get the profession associated with the open hour.
     *
     * @return BelongsTo
     */
    public function profession(): BelongsTo
    {
        return $this->belongsTo(Profession::class, 'profession_id');
    }

    /**
     * Get the activity type associated with the open hour.
     *
     * @return BelongsTo
     */
    public function activityType(): BelongsTo
    {
        return $this->belongsTo(ActivityType::class)->withTrashed();
    }
}
