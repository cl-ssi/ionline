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
        'id','proposal_detail_id','start_date','end_date','patient_id','contact_number','observation','blocked','deleted_bloqued_observation'
    ];

    protected $table = 'prof_agenda_open_hours';

    protected $dates = ['start_date','end_date'];

    // relaciones
    public function detail(){
        return $this->belongsTo('App\Models\ProfAgenda\ProposalDetail','proposal_detail_id');
    }

    public function patient(){
        return $this->belongsTo('App\User');
    }
}
