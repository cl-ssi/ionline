<?php

namespace App\Models\ProfAgenda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ProfessionMessage extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'id','profession_id','text'
    ];

    protected $table = 'prof_agenda_profession_messages';

    public function profession(){
        return $this->belongsTo('App\Models\Parameters\Profession','profession_id');
    }
}
