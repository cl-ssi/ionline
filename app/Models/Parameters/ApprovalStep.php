<?php

namespace App\Models\Parameters;

use App\Models\Rrhh\OrganizationalUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovalStep extends Model
{
    use SoftDeletes;

    protected $table = 'cfg_approval_steps';

    protected $fillable = [
        'approval_flow_id',
        'order',
        'organizational_unit_id',
    ];

    /**
     * Relación polimórfica con los modelos asociados (e.g., Cdp, RequestForm).
     */
    public function approvalFlow(): BelongsTo
    {
        return $this->belongsTo(ApprovalFlow::class);
    }

    /**
     * Relación con la unidad organizacional.
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }
}
