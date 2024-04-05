<?php

namespace App\Models\Finance\Receptions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Finance\Receptions\Reception;

class ReceptionItem extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'fin_reception_items';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'reception_id',
        'item_position',
        'CodigoCategoria',
        'Producto',
        'Cantidad',
        'Unidad',
        'EspecificacionComprador',
        'EspecificacionProveedor',
        'PrecioNeto',
        'PrecioExento',
        'TotalDescuentos',
        'TotalCargos',
        'Total',
    ];

    public function reception()
    {
        return $this->belongsTo(Reception::class);
    }
    
}
