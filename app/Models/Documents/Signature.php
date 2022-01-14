<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Signature extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'ou_id', 'responsable_id', 'request_date', 'document_type',
        'subject','description','endorse_type','recipients',
        'distribution', 'user_id', 'visatorAsSignature','url'
    ];

    public function user(){
        return $this->belongsTo('App\User')->withTrashed();
    }
    public function responsable(){
        return $this->belongsTo('App\User','responsable_id')->withTrashed();
    }

    public function organizationalUnit(){
        return $this->belongsTo('App\Rrhh\OrganizationalUnit','ou_id');
    }

    public function signaturesFiles(){
        return $this->hasMany('App\Models\Documents\SignaturesFile', 'signature_id');
    }

    /**
     * @return mixed Retorna model
     */
    public function getSignaturesFlowSignerAttribute(){
        return $this->signaturesFiles->where('file_type', 'documento')->first()
            ->signaturesFlows->where('type', 'firmante')->first();
    }

    /**
     * @return mixed Retorna collection
     */
    public function getSignaturesFlowVisatorAttribute(){
        return $this->signaturesFiles->where('file_type', 'documento')->first()
            ->signaturesFlows->where('type', 'visador');
    }

    /**
     * Obtiene flows para el archivo tipo documento
     * @return mixed
     */
    public function getSignaturesFlowsAttribute(){
        return $this->signaturesFiles->where('file_type', 'documento')->first()
            ->signaturesFlows;
    }

    /**
     * Verifica si tiene algún flow firmado o rechazado
     * @return bool
     */
    public function getHasSignedOrRejectedFlowAttribute()
    {
        return $this->signaturesFiles->where('file_type', 'documento')->first()
                ->signaturesFlows->whereNotNull('status')->count() > 0;
    }

    public function getSignaturesFileDocumentAttribute()
    {
        return $this->signaturesFiles->where('file_type', 'documento')->first();
    }

    public function getSignaturesFileAnexosAttribute()
    {
        return $this->signaturesFiles->where('file_type', 'anexo');
    }

    protected $table = 'doc_signatures';

    protected $dates = ['request_date'];
}
