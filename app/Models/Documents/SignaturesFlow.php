<?php

namespace App\Models\Documents;

use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SignaturesFlow extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doc_signatures_flows';

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
        'real_signer_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'signature_date' => 'datetime'
    ];

    /**
     * Get the signatures file that owns the signatures flow.
     *
     * @return BelongsTo
     */
    public function signaturesFile(): BelongsTo
    {
        return $this->belongsTo(SignaturesFile::class, 'signatures_file_id');
    }

    /**
     * Get the user that owns the signatures flow.
     *
     * @return BelongsTo
     */
    public function userSigner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /**
     * Get the real signer that owns the signatures flow.
     *
     * @return BelongsTo
     */
    public function realSigner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'real_signer_id')->withTrashed();
    }

    /**
     * Get the signature that owns the signatures flow.
     *
     * @return BelongsTo
     */
    public function signature(): BelongsTo
    {
        return $this->signaturesFile->signature();
    }

    /**
     * Get the organizational unit that owns the signatures flow.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'ou_id')->withTrashed();
    }

    /**
     * // FIXME: porque no usar la relación userSigner? si el usuario no existe explotará
     * puse un return a las relaciones para probar si todo anda bien, si no hay problemas
     * se pueden borrar y dejar entonces sólo las relaciones
     * Get the signer name attribute.
     *
     * @return string
     */
    public function getSignerNameAttribute(): string
    {
        return $this->userSigner->tinyName;
    }

    /**
     * Get the real signer name attribute.
     *
     * @return string
     */
    public function getRealSignerNameAttribute(): string
    {
        return $this->realSigner->tinyName;
    }

    /**
     * Get the validation messages attribute.
     *
     * @return array
     */
    public function getValidationMessagesAttribute(): array
    {
        $arrayMessages = [];
        if ( $this->signature->endorse_type === 'Visación en cadena de responsabilidad' ) {
            $signaturesFlowsPending = $this->signaturesFile->signaturesFlows
                ->where('type', 'visador')
                ->whereNull('status')
                ->when($this->type === 'visador', function ($query) {
                    return $query->where('sign_position', '<', $this->sign_position);
                });

            if ( $signaturesFlowsPending->count() > 0 ) {
                foreach ( $signaturesFlowsPending as $signatureFlowPending ) {
                    array_push($arrayMessages, "$signatureFlowPending->type {$signatureFlowPending->signerName} pendiente");
                }
            }
        }

        $signaturesFlowsRejected = $this->signaturesFile->signaturesFlows
            ->whereNotNull('status')
            ->where('status', false);

        if ( $signaturesFlowsRejected->count() > 0 ) {
            foreach ( $signaturesFlowsRejected as $signatureFlowRejected ) {
                array_push($arrayMessages, "Rechazado por $signatureFlowRejected->signerName: $signatureFlowRejected->observation");
            }
        }

        return $arrayMessages;
    }

    /**
     * Check if the signatures flow is signed.
     *
     * @return bool
     */
    public function isSigned(): bool
    {
        return $this->status == 1;
    }
}