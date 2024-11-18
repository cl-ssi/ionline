<?php

namespace App\Models\Parameters;

use App\Models\Establishment;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApprovalFlow extends Model
{
    protected $table = 'cfg_approval_flows';

    protected $fillable = [
        'class',
        'establishment_id',
    ];

    /**
     * Relación con los pasos de aprobación.
     */
    public function steps(): HasMany
    {
        return $this->hasMany(ApprovalStep::class)
            ->orderBy('order');
    }

    /**
     * Relación con el establecimiento.
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     *  Obtiene el flujo de aprobación a través de una clase
     */
    public static function getByClass($class): Collection
    {
        $approvalFlow = ApprovalFlow::where('class', $class)->first();
    
        return $approvalFlow ? $approvalFlow->steps()->get() : collect();
    }

    /**
     *  Obtiene el flujo de aprobación a través de un objeto
     */
    public static function getByObject($object): Collection
    {
        $class = get_class(object: $object);
        $approvalFlow = ApprovalFlow::where('class', $class)->first();
    
        return $approvalFlow ? $approvalFlow->steps()->get() : collect();
    }
}
