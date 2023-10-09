<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\User;

class AmiLoad extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'id',
        'id_amipass',
        'centro_de_costo',
        'sucursal',
        'n_factura',
        'tipo',
        'fecha',
        'n_tarjeta',
        'nombre_empleado',
        'run',
        'dv',
        'tipo_empleado',
        'monto'
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'fecha'
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'well_ami_loads';

    public function user()
    {
        return $this->belongsTo(User::class,'run');
    }
}
