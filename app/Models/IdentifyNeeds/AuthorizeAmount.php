<?php

namespace App\Models\IdentifyNeeds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthorizeAmount extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'identify_need_id',
        'status',
        'authorize_amount',
        'executed_amount',
        'observation',
    ];

    public function identifyNeed(): BelongsTo
    {
        return $this->belongsTo(IdentifyNeed::class, 'identify_need_id');
    }

    /**
     * Get the status value attribute.
     *
     * @return string|null
     */
    public function getStatusValueAttribute(): ?string
    {
        $statuses = [
            'pending'   => 'Pendiente',
            'waitlist'  => 'Lista de Espera',
            'accepted'  => 'Aceptada',
            'rejected'  => 'Rechazada',
        ];

        return $statuses[$this->status] ?? null;
    }

    protected $table = 'dnc_authorize_amounts';
}
