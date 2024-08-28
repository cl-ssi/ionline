<?php

namespace App\Models\Documents;

use App\Models\Rrhh\OrganizationalUnit;
use App\Models\ServiceRequests\SignatureFlow;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Resolution extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doc_resolutions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'ou_id',
        'responsable_id',
        'request_date',
        'document_type',
        'resolution_matter',
        'description',
        'endorse_type',
        'document_recipients',
        'document_distribution',
        'user_id'
    ];

    /**
     * Get the signature flows for the resolution.
     *
     * @return HasMany
     */
    public function SignatureFlows(): HasMany
    {
        return $this->hasMany(SignatureFlow::class);
    }

    /**
     * Get the user that owns the resolution.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the responsible user for the resolution.
     *
     * @return BelongsTo
     */
    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id')->withTrashed();
    }

    /**
     * Get the organizational unit that owns the resolution.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'ou_id');
    }
}