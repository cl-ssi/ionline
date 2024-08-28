<?php

namespace App\Models\Documents\Sign;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class SignatureAnnex extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sign_annexes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'url',
        'file',
        'signature_id'
    ];

    /**
     * Get the signature that owns the annex.
     *
     * @return BelongsTo
     */
    public function signature(): BelongsTo
    {
        return $this->belongsTo(Signature::class);
    }

    /**
     * Determine if the annex is a file.
     *
     * @return bool
     */
    public function isFile(): bool
    {
        return $this->type == 'file';
    }

    /**
     * Determine if the annex is a link.
     *
     * @return bool
     */
    public function isLink(): bool
    {
        return $this->type == 'link';
    }

    /**
     * Get the link to the file.
     *
     * @return string|null
     */
    public function getLinkFileAttribute(): ?string
    {
        $link = null;
        if ($this->isFile() && Storage::disk('gcs')->exists($this->file)) {
            $link = Storage::disk('gcs')->url($this->file);
        }

        return $link;
    }
}