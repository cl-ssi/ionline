<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;
use App\Models\Rrhh\Attendance\Reason;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function rrhhUser()
    {
        return $this->belongsTo(User::class,'rrhh_user_id')->withTrashed();
    }

}
