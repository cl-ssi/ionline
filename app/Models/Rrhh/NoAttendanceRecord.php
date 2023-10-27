<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;
use App\Models\Rrhh\Attendance\Reason;
use App\Models\Documents\Approval;

class NoAttendanceRecord extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'date',
        'user_id',
        'reason_id',
        'observation',
        'authority_observation',
        'authority_id',
        'rrhh_user_id',
        'rrhh_at',
        'rrhh_observation',
        'rrhh_status',
        'establishment_id',
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'rrhh_no_attendance_records';

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'rrhh_at',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d\TH:i:s'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }

    public function authority()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the approval model.
     */
    public function approval(): MorphOne
    {
        return $this->morphOne(Approval::class, 'approvable');
    }

    /**
     * Simular un approval model.
     */
    public function getApprovalLegacyAttribute()
    {
        $approval = new Approval();
        $approval->status = $this->status;
        $approval->approver_id = $this->authority_id;
        $approval->approver_at = $this->authority_at;
        $approval->approver_ou_id = $this->approver_ou_id;
        $approval->reject_observation = $this->authority_observation;
        return $approval;
    }

    public function rrhhUser()
    {
        return $this->belongsTo(User::class,'rrhh_user_id')->withTrashed();
    }

}
