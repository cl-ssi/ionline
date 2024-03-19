<?php

namespace App\Models\Meetings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Meeting extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'status', 'correlative', 'user_creator_id', 'user_responsible_id', 'ou_responsible_id', 'establishment_id', 
        'date', 'type', 'subject', 'mechanism', 'start_at', 'end_at'
    ];

    public function userResponsible() {
        return $this->belongsTo('App\User', 'user_responsible_id')->withTrashed();
    }

    public function groupings() {
        return $this->hasMany('App\Models\Meetings\Grouping');
    }

    public function commitments() {
        return $this->hasMany('App\Models\Meetings\Commitment');
    }

    public function userCreator() {
        return $this->belongsTo('App\User', 'user_creator_id')->withTrashed();
    }

    public function getStatusValueAttribute() {
        switch($this->status) {
            case 'saved':
                return 'Guardado';
                break;

            case 'sgr':
                return 'Derivado SGR';
                break;
        }
    }

    public function getTypeValueAttribute() {
        switch($this->type) {
            case 'lobby':
                return 'Lobby';
                break;

            case 'pending':
                return 'Pendiente';
                break;
        }
    }

    public function getMechanismValueAttribute() {
        switch($this->mechanism) {
            case 'videoconferencia':
                return 'Videoconferencia';
                break;

            case 'presencial':
                return 'Presencial';
                break;
        }
    }

    /*
    protected $dates = [
        'date'
    ];
    */
    

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /*
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($meeting) {
            //TODO: PARAMETRIZAR TYPE_ID VIATICOS
            $meeting->correlative = Correlative::getCorrelativeFromType(10, $allowance->organizationalUnitAllowance->establishment_id);
        });
    }
    */

    protected $table = 'meet_meetings';
}
