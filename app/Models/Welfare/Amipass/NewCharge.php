<?php

namespace App\Models\Welfare\Amipass;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewCharge extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'rut',
        'dv',
        'nombre',
        'lugar_desempenio',
        'fecha',
        'dias_habiles_mes',
        'dias_ausentismo',
        'valor_dia',
        'total_regularizado'
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'well_ami_new_charges';

    public function getDiasACargarAttribute()
    {
        return $this->dias_habiles_mes - $this->dias_ausentismo;
    }

    public function getSubtotalAttribute()
    {
        return ($this->dias_habiles_mes - $this->dias_ausentismo) * $this->valor_dia;
    }

    public function getValorACargarAttribute()
    {
        return $this->subtotal + $this->total_regularizado;
    }
}
