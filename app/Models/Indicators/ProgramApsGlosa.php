<?php

namespace App\Models\Indicators;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramApsGlosa extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'periodo', 'numero', 'nivel', 'prestacion', 'poblacion', 'verificacion',
        'profesional'
    ];

    public function values() {
        return $this->hasMany(ProgramApsValue::class);
    }

    use SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    protected $table = 'ind_program_aps_glosas';
}
