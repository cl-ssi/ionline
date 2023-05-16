<?php

namespace App\Models\JobPositionProfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class JobPositionProfileSign extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'position', 'event_type', 'status', 'observation', 'date_sign'
    ];

    public function organizationalUnit() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'organizational_unit_id')->withTrashed();
    }

    public function user() {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function getStatusValueAttribute() {
        switch($this->status) {
            case 'pending':
                return 'Pendiente de Aprobación';
                break;
            case 'accepted':
                return 'Aceptada';
                break;
            case 'rejected':
                return 'Rechazada';
                break;
            default:
                return 'Pendiente de Aprobación';
                break;
        }
    }

    protected $dates = [
        'date_sign'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'jpp_job_position_profile_signs';
}
