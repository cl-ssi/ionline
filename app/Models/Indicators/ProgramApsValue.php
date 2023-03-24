<?php

namespace App\Models\Indicators;

use App\Models\Commune;
use App\Models\Establishment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramApsValue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'periodo', 'program_aps_glosa_id', 'commune_id', 'establishment_id',
        'poblacion', 'cobertura', 'concentracion', 'actividadesProgramadas',
        'observadoAnterior', 'rendimientoProfesional', 'observaciones'
    ];

    public function commune() {
        return $this->belongsTo(Commune::class);
    }

    public function establishment() {
        return $this->belongsTo(Establishment::class);
    }

    public function glosa() {
        return $this->belongsTo(ProgramApsGlosa::class, 'program_aps_glosa_id');
    }

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'ind_program_aps_values';
}
