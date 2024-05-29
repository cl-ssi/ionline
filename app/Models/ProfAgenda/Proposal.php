<?php

namespace App\Models\ProfAgenda;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\User;

class Proposal extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    //
    protected $fillable = [
        'id','type','user_id','profession_id','start_date','end_date','status','observation'
    ];

    protected $table = 'prof_agenda_proposals';

    protected $dates = ['start_date','end_date'];

    // relaciones
    public function profession(){
        return $this->belongsTo('App\Models\Parameters\Profession','profession_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id')->withTrashed();
    }

    public function details(){
        return $this->hasMany('App\Models\ProfAgenda\ProposalDetail');
    }
}
