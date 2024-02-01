<?php

namespace App\Models\ProfAgenda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class OpenHour extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    //
    protected $fillable = [
        'id','proposal_detail_id','start_date','end_date','patient_id','contact_number','observation','blocked','deleted_bloqued_observation',
        'assistance', 'absence_reason','profesional_id','profession_id','activity_type_id','deleted_at'
    ];

    protected $table = 'prof_agenda_open_hours';

    protected $dates = ['start_date','end_date'];

    // relaciones
    public function detail(){
        return $this->belongsTo('App\Models\ProfAgenda\ProposalDetail','proposal_detail_id');
    }

    public function patient(){
        return $this->belongsTo('App\User','patient_id');
    }

    public function profesional(){
        return $this->belongsTo('App\User','profesional_id');
    }

    public function profession(){
        return $this->belongsTo('App\Models\Parameters\Profession','profession_id');
    }

    public function activityType(){
        return $this->belongsTo('App\Models\ProfAgenda\ActivityType');
    }

    public function appointments(){
        return $this->hasMany('App\Models\ProfAgenda\Appointment');
    }
    
    // public function active_appointment(){
    //     if($this->appointments()->count()>0){
    //         return $this->appointments()->whereNull('discharged_date')->first();
    //     }else{
    //         return $this->appointments();
    //     }
    // }
}
