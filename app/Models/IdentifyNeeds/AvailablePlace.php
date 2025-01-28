<?php

namespace App\Models\IdentifyNeeds;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Parameters\Estament;

class AvailablePlace extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'estament_id',
        'family_position',
        'places_number',
        'identify_need_id'
    ];

    /**
     * Get the estament that owns the available place.
     *
     * @return BelongsTo
     */
    public function estament(): BelongsTo
    {
        return $this->belongsTo(Estament::class);
    }

    /**
     * Get the family position value attribute.
     *
     * @return string|null
     */
    public function getFamilyPositionValueAttribute(): ?string
    {
        $familyPositions = [
            'profesional directivo'         => 'Profesional Directivo', 
            'profesional gestion'           => 'Profesional de Gestión',
            'profesional asistencial'       => 'Profesional Asistencial',
            'tecnico de apoyo a la gestion' => 'Técnico de Apoyo a la Gestión',
            'tecnico asistencial'           => 'Técnico Asistencial',
            'administrativo apoyo gestion'  => 'Administrativo(a) de Apoyo a la Gestión',
            'administrativo asistencial'    => 'Administrativo(a) Asistencial',
            'auxiliar apoyo operaciones'    => 'Auxiliar de Apoyo de Operaciones',
            'auxiliar conductor'            => 'Auxiliar Conductor',
        ];

        return $familyPositions[$this->family_position] ?? null;
    }

    protected $table = 'dnc_available_places';
}
