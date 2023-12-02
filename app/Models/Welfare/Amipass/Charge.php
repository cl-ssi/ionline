<?php

namespace App\Models\Welfare\Amipass;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Charge extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'rut',
        'dv',
        'nombre',
        'lugar_desempenio',
        'fecha',
        'total_real_cargado',
        'dias_ausentismo',
        'dias_habiles_mes',
        'valor_dia',
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    // protected $casts = [
    //     'fecha' => 'date:Y-m-d',
    // ];
    

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'well_ami_charges';

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'rut');
    // }

    public function getDiasACargarAttribute()
    {
        return $this->dias_habiles_mes - $this->dias_ausentismo;
    }

    public function getValorDebiaCargarseAttribute()
    {
        return ($this->dias_habiles_mes - $this->dias_ausentismo) * $this->valor_dia;
    }

    public function getDiferenciaAttribute()
    {
        return $this->valor_debia_cargarse - $this->total_real_cargado;
    }

    public function getDiferenciaColorAttribute()
    {
        return $this->diferencia >= 0 ? 'text-success' : 'text-danger';
    }
}
