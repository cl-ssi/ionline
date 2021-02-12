<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Signature extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'ou_id', 'responsable_id', 'request_date', 'document_type',
        'subject','description','endorse_type','recipients',
        'distribution', 'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function responsable(){
        return $this->belongsTo('App\User','responsable_id');
    }

    public function organizationalUnit(){
        return $this->belongsTo('App\Rrhh\organizationalUnit','ou_id');
    }

    public function signaturesFiles(){
        return $this->hasMany('App\Models\Documents\SignaturesFile', 'signature_id');
    }

    public function getSignaturesFlowSignerAttribute(){
        return $this->signaturesFiles->where('file_type', 'documento')->first()
            ->signaturesFlows->where('type', 'firmante')->first();
    }


    protected $table = 'doc_signatures';

    protected $dates = ['request_date'];
}
