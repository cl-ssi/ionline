<?php

namespace App\Models\Rrhh;

use App\Models\Documents\Approval;
use App\Models\Establishment;
use App\Models\Rrhh\AbsenteeismType;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Absenteeism extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rrhh_absenteeisms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rut',
        'dv',
        'nombre',
        'ley',
        'edadanos',
        'edadmeses',
        'afp',
        'salud',
        'codigo_unidad',
        'nombre_unidad',
        'genero',
        'cargo',
        'calidad_juridica',
        'planta',
        'n_resolucion',
        'fresolucion',
        'finicio',
        'ftermino',
        'total_dias_ausentismo',
        'ausentismo_en_el_periodo',
        'costo_de_licencia',
        'tipo_de_ausentismo',
        'absenteeism_type_id',
        'codigo_de_establecimiento',
        'nombre_de_establecimiento',
        'saldo_dias_no_reemplazados',
        'tipo_de_contrato',
        'jornada',
        'observacion',
        'sirh_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'finicio'  => 'date',
        'ftermino' => 'date',
        'fresolucion' => 'date',
        'sirh_at'  => 'datetime',
    ];

    /**
     * Get the user that owns the absenteeism.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rut');
    }

    /**
     * Get the organizational unit that owns the absenteeism.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'codigo_unidad', 'sirh_ou_id');
    }

    /**
     * Get the type that owns the absenteeism.
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(AbsenteeismType::class, 'absenteeism_type_id');
    }

    /**
     * Get the establishment that owns the absenteeism.
     *
     * @return BelongsTo
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'codigo_de_establecimiento', 'sirh_code');
    }

    /**
     * Get the approval model.
     *
     * @return MorphOne
     */
    public function approval(): MorphOne
    {
        return $this->morphOne(Approval::class, 'approvable');
    }

    /**
     * Create an approval for the absenteeism.
     *
     * @return void
     */
    public function createApproval()
    {
        $subject = "<strong>Nombre:</strong> {$this->nombre}";
        $subject .= "<br><strong>Tipo:</strong> {$this->tipo_de_ausentismo}";
        $subject .= "<br><strong>Fechas:</strong> {$this->finicio->format('d-m-Y')} - {$this->ftermino->format('d-m-Y')}";

        $this->approval()->create([
            "module"                => "Ausentismo",
            "module_icon"           => "fas fa-plane",
            "subject"               => $subject,
            "document_route_name"   => "rrhh.absenteeisms.show",
            "document_route_params" => json_encode([
                "absenteeism" => $this->id,
            ]),
            "sent_to_ou_id"         => auth()->user()->boss->organizational_unit_id,
        ]);
    }
}