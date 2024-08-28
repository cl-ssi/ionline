<?php

namespace App\Models\Documents;

use App\Models\Documents\SignaturesFile;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Documents\Type;
use App\Models\User;
use App\Notifications\Signatures\SignedDocument;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;
use OwenIt\Auditing\Contracts\Auditable;

class Signature extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doc_signatures';

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'request_date' => 'datetime',
        'rejected_at' => 'datetime'
    ];

    /**
     * Get the user that owns the signature.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the responsible user for the signature.
     *
     * @return BelongsTo
     */
    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id')->withTrashed();
    }

    /**
     * Get the organizational unit that owns the signature.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'ou_id');
    }

    /**
     * Get the signatures files for the signature.
     *
     * @return HasMany
     */
    public function signaturesFiles(): HasMany
    {
        return $this->hasMany(SignaturesFile::class, 'signature_id');
    }

    /**
     * Get the type that owns the signature.
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class)->withTrashed();
    }

    /**
     * Get the signatures flow signer attribute.
     *
     * @return mixed
     */
    public function getSignaturesFlowSignerAttribute()
    {
        return $this->signaturesFiles->where('file_type', 'documento')->first()
            ->signaturesFlows->where('type', 'firmante')->first();
    }

    /**
     * Get the pending signatures flows.
     *
     * @return mixed
     */
    public function pendingSignaturesFlows()
    {
        return $this->signaturesFlows->where('status', null);
    }

    /**
     * Get the signatures flow visator attribute.
     *
     * @return collection
     */
    public function getSignaturesFlowVisatorAttribute()
    {
        return $this->signaturesFiles->where('file_type', 'documento')->first()
            ->signaturesFlows->where('type', 'visador');
    }

    /**
     * Get the signatures flows attribute.
     *
     * @return mixed
     */
    public function getSignaturesFlowsAttribute()
    {
        return $this->signaturesFiles->where('file_type', 'documento')->first()
            ->signaturesFlows;
    }

    /**
     * Verifica si tiene algún flow firmado o rechazado
     *
     * @return bool
     */
    public function getHasSignedOrRejectedFlowAttribute(): bool
    {
        return $this->signaturesFiles->where('file_type', 'documento')->first()
                ->signaturesFlows->whereNotNull('status')->count() > 0;
    }

    /**
     * Get the signatures file document attribute.
     *
     * @return mixed
     */
    public function getSignaturesFileDocumentAttribute()
    {
        return $this->signaturesFiles->where('file_type', 'documento')->first();
    }

    /**
     * Get the signatures file anexos attribute.
     *
     * @return mixed
     */
    public function getSignaturesFileAnexosAttribute()
    {
        return $this->signaturesFiles->where('file_type', 'anexo');
    }

    /**
     * Get mails to distribute.
     *
     * @return array
     */
    public function getMailsToDistribute(): array
    {
        $allEmails = $this->recipients . ',' . $this->distribution;
        preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $allEmails, $valid_emails);
        return $valid_emails[0] ?? [];
    }

    /**
     * Distribute document to Recipients and Distribution.
     */
    public function distribute(): void
    {
        /**
         * Utilizando notify y con colas
         */
        $valid_emails = $this->getMailsToDistribute();

        if (!empty($valid_emails)) {
            Notification::route('mail', $valid_emails)->notify(new SignedDocument($this));
        }
    }
}