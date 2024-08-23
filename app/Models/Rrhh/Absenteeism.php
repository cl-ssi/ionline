<?php

namespace App\Models\Rrhh;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Rrhh\OrganizationalUnit;
use App\Models\Documents\Approval;
use App\Models\Establishment;
use App\Models\Rrhh\AbsenteeismType;
use App\Models\User;

class Absenteeism extends Model
{
    use HasFactory;
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
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'finicio',
        'ftermino',
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'rrhh_absenteeisms';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'rut');
    }

    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class,'codigo_unidad','sirh_ou_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(AbsenteeismType::class, 'absenteeism_type_id');
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'codigo_de_establecimiento', 'sirh_code');
    }

    /**
     * Get the approval model.
     */
    public function approval(): MorphOne
    {
        return $this->morphOne(Approval::class, 'approvable');
    }

    public function createApproval()
    {
        $subject  = "<strong>Nombre:</strong> {$this->nombre}";
        $subject .= "<br><strong>Tipo:</strong> {$this->tipo_de_ausentismo}";
        $subject .= "<br><strong>Fechas:</strong> {$this->finicio->format('d-m-Y')} - {$this->ftermino->format('d-m-Y')}";

        $this->approval()->create([
            "module" => "Ausentismo",
            "module_icon" => "fas fa-plane",
            "subject" => $subject,
            "document_route_name" => "rrhh.absenteeisms.show",
            "document_route_params" => json_encode([
                "absenteeism" => $this->id,
            ]),
            "sent_to_ou_id" => auth()->user()->boss->organizational_unit_id,
        ]);
    }

    // public static function getAllAbsenteeismTypes(): array
    // {
    //     return self::query()
    //         ->select('tipo_de_ausentismo')
    //         ->distinct()
    //         ->orderBy('tipo_de_ausentismo', 'asc')
    //         ->pluck('tipo_de_ausentismo')
    //         ->toArray();
    // }

}
