<?php

namespace App\Models\Rrhh;

use App\Models\Documents\Approval;
use App\Models\Rrhh\Attendance\Reason;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class NoAttendanceRecord extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rrhh_no_attendance_records';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'user_id',
        'type',
        'reason_id',
        'observation',
        'authority_observation',
        'authority_id',
        'rrhh_user_id',
        'rrhh_at',
        'rrhh_observation',
        'rrhh_status',
        'establishment_id',
        'filter.name'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'rrhh_at' => 'datetime',
        'date' => 'date:Y-m-d\TH:i:s',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that owns the no attendance record.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the reason that owns the no attendance record.
     *
     * @return BelongsTo
     */
    public function reason(): BelongsTo
    {
        return $this->belongsTo(Reason::class)->withTrashed();
    }

    /**
     * Get the authority that owns the no attendance record.
     *
     * @return BelongsTo
     */
    public function authority(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the approval model.
     *
     * @return MorphOne
     */
    public function approval(): MorphOne
    {
        return $this->morphOne(Approval::class, 'approvable');
    }

    /**
     * Get the rrhh user that owns the no attendance record.
     *
     * @return BelongsTo
     */
    public function rrhhUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rrhh_user_id')->withTrashed();
    }

    /**
     * Simulate an approval model.
     *
     * @return Approval
     */
    public function getApprovalLegacyAttribute(): Approval
    {
        $approval = new Approval();
        $approval->status = $this->status;
        $approval->approver_id = $this->authority_id;
        $approval->approver_at = $this->authority_at;
        $approval->sent_to_ou_id = $this->approver_ou_id;
        $approval->approver_observation = $this->authority_observation;
        return $approval;
    }
}