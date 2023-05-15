<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;

class NoAttendanceRecord extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'date',
        'user_id',
        'observation',
        'authority_observation',
        'authority_id',
        'rrhh_user_id',
        'rrhh_at',
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
        return $this->belongsTo(User::class);
    }
    
    public function authority()
    {
        return $this->belongsTo(User::class);
    }

    public function rrhhUser()
    {
        return $this->belongsTo(User::class,'rrhh_user_id');
    }
    

}
