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
