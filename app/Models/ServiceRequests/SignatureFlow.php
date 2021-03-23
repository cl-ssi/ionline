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
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'ou_id', 'derive_date','responsable_id','user_id','service_request_id','resolution_id', 'sign_position', 'type', 'employee', 'observation', 'signature_date', 'status'
    ];

    public function user(){
      return $this->belongsTo('App\User','responsable_id');
    }

    public function serviceRequest(){
      return $this->belongsTo('App\ServiceRequests\ServiceRequest');
    }

    public function resolution(){
      return $this->belongsTo('App\Documents\Signature');
    }

    public function organizationalUnit(){
      return $this->belongsTo('App\Rrhh\OrganizationalUnit','ou_id');
    }

    protected $table = 'doc_signature_flow';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['signature_date'];
}
