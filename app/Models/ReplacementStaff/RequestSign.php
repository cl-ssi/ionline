<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestSign extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'position', 'ou_alias', 'organizational_unit_id', 'request_id',
        'request_status', 'observation', 'date_sign',
        'request_replacement_staff_id'
    ];

    public function requestReplacementStaff() {
        return $this->belongsTo('App\Models\ReplacementStaff\RequestReplacementStaff');
    }

    public function organizationalUnit() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit');
    }

    public function user() {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function getStatusValueAttribute() {
        switch($this->request_status) {
          case 'pending':
            return 'Pendiente de Aprobación';
            break;
          case 'accepted':
            return 'Aceptada';
            break;
          case 'rejected':
            return 'Rechazada';
            break;
        }
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $dates = [
        'date_sign'
    ];

    protected $table = 'rst_request_signs';
}
