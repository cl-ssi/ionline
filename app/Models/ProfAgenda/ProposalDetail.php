<?php

namespace App\Models\ProfAgenda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ProposalDetail extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    //
    protected $fillable = [
        'id','programming_proposal_id','activity_type_id','day','start_hour','end_hour','duration'
    ];

    protected $table = 'prof_agenda_proposal_details';

    public function getDayAttribbute(){
        if ($this->day == 1) {
          return "Lunes";
        }
        if ($this->day == 2) {
          return "Martes";
        }
        if ($this->day == 3) {
          return "Miércoles";
        }
        if ($this->day == 4) {
          return "Jueves";
        }
        if ($this->day == 5) {
          return "Viernes";
        }
        if ($this->day == 6) {
          return "Sábado";
        }
        if ($this->day == 7) {
          return "Domingo";
        }
      }

    // relaciones
    // public function commune()
    // {
    //     return $this->belongsTo('App\Models\ClCommune', 'commune_id');
    // }

    // public function rooms()
    // {
    //     return $this->hasMany('App\Models\HotelBooking\Room');
    // }

    // public function images()
    // {
    //     return $this->hasMany('App\Models\HotelBooking\HotelImage');
    // }

    public function activityType(){
        return $this->belongsTo('App\Models\ProfAgenda\ActivityType');
    }

    public function openHours(){
        return $this->hasMany('App\Models\ProfAgenda\OpenHour');
    }
}
