<?php

namespace App\Models\Allowances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AllowanceSign extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'position', 'ou_alias', 'organizational_unit_id', 'status', 'observation', 'date_sign'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }

    public function organizationalUnit() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'organizational_unit_id');
    }

    public function allowance() {
        return $this->belongsTo('App\Models\Allowances\Allowance', 'allowance_id');
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
        }
    }

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $dates = [
        'date_sign'
    ];

    protected $table = 'alw_allowance_signs';
}
