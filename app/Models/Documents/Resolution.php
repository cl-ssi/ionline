<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Resolution extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'ou_id', 'responsable_id', 'request_date', 'document_type',
        'resolution_matter','description','endorse_type','document_recipients',
        'document_distribution', 'user_id'
    ];

    public function SignatureFlows() {
    	return $this->hasMany('\App\Models\ServiceRequests\SignatureFlow');
    }

    public function user(){
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function responsable(){
        return $this->belongsTo('App\User','responsable_id')->withTrashed();
    }

    public function organizationalUnit(){
        return $this->belongsTo('App\Rrhh\organizationalUnit','ou_id');
    }

    protected $table = 'doc_resolutions';
}
