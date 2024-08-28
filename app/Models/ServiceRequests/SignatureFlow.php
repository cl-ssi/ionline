<?php

namespace App\Models\ServiceRequests;

use App\Models\Documents\Signature;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class SignatureFlow extends Model implements AuditableContract
{
    use Auditable, HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doc_signature_flow';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'ou_id',
        'derive_date',
        'responsable_id',
        'user_id',
        'service_request_id',
        'resolution_id',
        'sign_position',
        'type',
        'employee',
        'observation',
        'signature_date',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'signature_date' => 'datetime',
    ];

    /**
     * Get the user responsible for this signature flow.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id')->withTrashed();
    }

    /**
     * Get the service request associated with this signature flow.
     *
     * @return BelongsTo
     */
    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    /**
     * Get the resolution associated with this signature flow.
     *
     * @return BelongsTo
     */
    public function resolution(): BelongsTo
    {
        return $this->belongsTo(Signature::class);
    }

    /**
     * Get the organizational unit associated with this signature flow.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'ou_id')->withTrashed();
    }
}
