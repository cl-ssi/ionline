<?php

namespace App\Models\ProfAgenda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Appointment extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'id','open_hour_id','begin_date','discharged_date'
    ];

    protected $table = 'prof_agenda_appointments';

    protected $dates = ['begin_date','discharged_date'];

    public function openHour(){
        return $this->belongsTo('App\Models\ProfAgenda\OpenHour');
    }
}
