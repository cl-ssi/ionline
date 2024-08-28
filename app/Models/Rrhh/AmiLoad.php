<?php

namespace App\Models\Rrhh;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmiLoad extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table = 'well_ami_loads';

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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'fecha' => 'date'
    ];

    /**
     * Get the user that owns the AmiLoad.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'run');
    }
}