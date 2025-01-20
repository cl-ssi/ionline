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
        'parameter',
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
    public static function getByClass($class, $parameter = null): Collection
    {
        return self::getApprovalFlow($class, $parameter);
    }

    /**
     *  Obtiene el flujo de aprobación a través de un objeto
     */
    public static function getByObject($object, $parameter = null): Collection
    {
        $class = get_class($object);
        return self::getApprovalFlow($class, $parameter);
    }

    /**
     *  Método privado para obtener el flujo de aprobación
     */
    private static function getApprovalFlow($class, $parameter = null): Collection
    {
        $approvalFlow = ApprovalFlow::where('class', $class)
            ->when($parameter, function ($query, $parameter) {
                return $query->where('parameter', $parameter);
            })
            ->first();

        return $approvalFlow ? $approvalFlow->steps()->get() : collect();
    }
}
