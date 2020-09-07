<?php

namespace App\Documents;

use Illuminate\Database\Eloquent\Model;

class Correlative extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'correlative', 'year'
    ];

    public static function getCorrelativeFromType($type) {
        /* Obtener el objeto correlativo según el tipo */
        $correlative = Correlative::Where('type',"$type")->first();
        /* Almacenar el número del correlativo  */
        $number = $correlative->correlative;
        /* Aumentar el correlativo y guardarlo */
        $correlative->correlative = $correlative->correlative + 1;
        $correlative->save();

        /* Retornar el número actial */
        return $number;
    }

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'doc_correlatives';
}
