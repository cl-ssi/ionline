<?php

namespace App\Models\Documents;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Documents\Type;

class Signature extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'doc_signatures';

    protected $dates = ['request_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'status',
        'ou_id',
        'responsable_id',
        'request_date',
        'type_id',
        'reserved',
        'subject',
        'description',
        'endorse_type',
        'recipients',
        'distribution',
        'user_id',
        'visatorAsSignature',
        'url'
    ];

    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function responsable()
    {
        return $this->belongsTo('App\User','responsable_id')->withTrashed();
    }

    public function organizationalUnit()
    {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit','ou_id');
    }

    public function signaturesFiles()
    {
        return $this->hasMany('App\Models\Documents\SignaturesFile', 'signature_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class)->withTrashed();
    }


    /**
     * @return mixed Retorna model
     */
    public function getSignaturesFlowSignerAttribute()
    {
        return $this->signaturesFiles->where('file_type', 'documento')->first()
            ->signaturesFlows->where('type', 'firmante')->first();
    }

    /**
     * @return mixed Retorna collection
     */
    public function getSignaturesFlowVisatorAttribute()
    {
        return $this->signaturesFiles->where('file_type', 'documento')->first()
            ->signaturesFlows->where('type', 'visador');
    }

    /**
     * Obtiene flows para el archivo tipo documento
     * @return mixed
     */
    public function getSignaturesFlowsAttribute()
    {
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
}
