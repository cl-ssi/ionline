<?php

namespace App\Models\ServiceRequests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class SignatureFlow extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'doc_signature_flow';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'ou_id', 'derive_date','responsable_id','user_id','service_request_id','resolution_id', 'sign_position', 'type', 'employee', 'observation', 'signature_date', 'status'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['signature_date'];

    public function user()
    {
        return $this->belongsTo('App\User','responsable_id')->withTrashed();
    }

    public function serviceRequest()
    {
        return $this->belongsTo('\App\Models\ServiceRequests\ServiceRequest');
    }

    public function resolution()
    {
        return $this->belongsTo('App\Models\Documents\Signature');
    }

    public function organizationalUnit()
    {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit','ou_id');
    }
}
