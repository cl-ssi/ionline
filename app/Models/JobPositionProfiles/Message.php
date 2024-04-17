<?php

namespace App\Models\JobPositionProfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Message extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'section', 'message', 'job_position_profile_id'
    ];

    public function jobPositionProfile() {
        return $this->belongsTo('App\Models\JobPositionProfiles\JobPositionProfile');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function getSectionValueAttribute() {
        switch($this->section) {
            case '1':
                return 'I. IDENTIFICACIÓN DEL CARGO';
                break;
          
            case '2':
                return 'II. REQUISITOS FORMALES';
                break;
            
            case '3':
                return 'III. PROPÓSITOS DEL CARGO';
                break;
            
            case '4':
                return 'IV. ORGANIZACIÓN Y CONTEXTO DEL CARGO';
                break;

            case '5':
                return 'V. RESPONSABILIDAD DEL CARGO';
                break;
            
            case '6':
                return 'VI. DICCIONARIO DE COMPETENCIAS DEL S.S.T';
                break;
        }
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'jpp_messages';
}
