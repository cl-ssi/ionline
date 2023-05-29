<?php

namespace App\Models\Rrhh\Attendance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Rrhh\NoAttendanceRecord;

class Reason extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'rrhh_no_attendance_reasons';
    

    public function noAttendanceRecords()
    {
        return $this->hasMany(NoAttendanceRecord::class);
    }
    
}
