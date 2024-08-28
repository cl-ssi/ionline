<?php

namespace App\Models\ServiceRequests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class FulfillmentItem extends Model implements AuditableContract
{
    use Auditable, HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doc_fulfillments_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'fulfillment_id',
        'type',
        'start_date',
        'end_date',
        'observation',
        'responsable_approbation',
        'responsable_approver_id',
        'rrhh_approbation',
        'rrhh_approver_id',
        'finances_approbation',
        'finances_approver_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    /**
     * Get the fulfillment associated with the fulfillment item.
     *
     * @return BelongsTo
     */
    public function Fulfillment(): BelongsTo
    {
        return $this->belongsTo(Fulfillment::class);
    }
}
