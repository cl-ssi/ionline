<?php

namespace App\Models\Documents;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SignaturesFlow extends Model Implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'doc_signatures_flows';

    protected $dates = ['signature_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'signatures_file_id',
        'type',
        'ou_id',
        'user_id',
        'sign_position',
        'status',
        'signature_date',
        'observation',
        'visator_type',
        'real_signer_id',
    ];

    public function signaturesFile()
    {
        return $this->belongsTo('App\Models\Documents\SignaturesFile', 'signatures_file_id');
    }

    public function userSigner()
    {
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }

    public function realSigner()
    {
        return $this->belongsTo('App\User', 'real_signer_id')->withTrashed();
    }

    public function signature()
    {
        return $this->signaturesFile->signature();
    }

    /* FIXME: porque no usar la relación userSigner? si el usuario no existe explotará
     * puse un return a las relaciones para probar si todo anda bien, si no hay problemas
     * se pueden borrar y dejar entonces sólo las relaciones
     */
    public function getSignerNameAttribute()
    {
        //return User::find($this->user_id)->TinnyName;
        return $this->userSigner->tinnyName;
    }

    public function getRealSignerNameAttribute()
    {
        // return User::find($this->real_signer_id)->fullName;
        return $this->realSigner->tinnyName;
    }

    public function getValidationMessagesAttribute(): array
    {
        $arrayMessages = array();
        if ($this->signature->endorse_type === 'Visación en cadena de responsabilidad') {
            $signaturesFlowsPending = $this->signaturesFile->signaturesFlows
                ->where('type', 'visador')
                ->whereNull('status')
                ->when($this->type === 'visador', function ($query){
                    return $query->where('sign_position', '<', $this->sign_position);
                });

            if ($signaturesFlowsPending->count() > 0) {
                foreach ($signaturesFlowsPending as $signatureFlowPending) {
                    array_push($arrayMessages, "$signatureFlowPending->type {$signatureFlowPending->signerName} pendiente") ;
                }
            }
        }

        $signaturesFlowsRejected = $this->signaturesFile->signaturesFlows
            ->whereNotNull('status')
            ->where('status', false);

        if ($signaturesFlowsRejected->count() > 0) {
            foreach ($signaturesFlowsRejected as $signatureFlowRejected) {
                array_push($arrayMessages, "Rechazado por $signatureFlowRejected->signerName: $signatureFlowRejected->observation");
            }
        }

        return $arrayMessages;
    }

    public function isSigned()
    {
        return $this->status == 1;
    }
}
