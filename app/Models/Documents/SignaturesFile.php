<?php

namespace App\Models\Documents;

use App\Models\Documents\Parte;
use App\Models\Documents\SignaturesFlow;
use App\Models\Documents\Signature;
use App\Models\Documents\Document;
use App\Models\Suitability\Result;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SignaturesFile extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doc_signatures_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'signature_id',
        'file',
        'file_type',
        'signed_file'
    ];

    /**
     * Get the signatures flows for the signatures file.
     *
     * @return HasMany
     */
    public function signaturesFlows(): HasMany
    {
        return $this->hasMany(SignaturesFlow::class, 'signatures_file_id');
    }

    /**
     * Get the signature that owns the signatures file.
     *
     * @return BelongsTo
     */
    public function signature(): BelongsTo
    {
        return $this->belongsTo(Signature::class, 'signature_id');
    }

    /**
     * Get the document associated with the signatures file.
     *
     * @return HasOne
     */
    public function document(): HasOne
    {
        return $this->hasOne(Document::class, 'file_to_sign_id');
    }

    /**
     * Get the suitability result associated with the signatures file.
     *
     * @return HasOne
     */
    public function suitabilityResult(): HasOne
    {
        return $this->hasOne(Result::class, 'signed_certificate_id');
    }

    /**
     * Get the parte associated with the signatures file.
     *
     * @return HasOne
     */
    public function parte(): HasOne
    {
        return $this->hasOne(Parte::class);
    }

    /**
     * Check if the signatures file has a signed flow.
     *
     * @return bool
     */
    public function getHasSignedFlowAttribute(): bool
    {
        return $this->signaturesFlows()->where('status', 1)->count() > 0;
    }

    /**
     * Get the file name of the signatures file.
     *
     * @return string
     */
    public function getFileNameAttribute(): string
    {
        return basename($this->file);
    }

    /**
     * Check if the signatures file has a rejected flow.
     *
     * @return bool
     */
    public function getHasRejectedFlowAttribute(): bool
    {
        return $this->signaturesFlows()->where('status', 0)->count() > 0;
    }

    /**
     * Check if all flows of the signatures file are signed.
     *
     * @return bool
     */
    public function getHasAllFlowsSignedAttribute(): bool
    {
        return $this->signaturesFlows->every('status', 1);
    }

    /**
     * Check if the signatures file has one pending flow.
     *
     * @return bool
     */
    public function getHasOnePendingFlowAttribute(): bool
    {
        return $this->signaturesFlows->whereNull('status')->count() === 1;
    }
}