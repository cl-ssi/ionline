<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Model;

class Correlative extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type_id',
        'correlative',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doc_correlatives';

    public static function getCorrelativeFromType($type_id)
    {
        /* Obtener el objeto correlativo según el tipo */
        $correlative = Correlative::where('type_id', $type_id)->first();
        if(!$correlative) {
            $correlative = Correlative::create([
                'type_id' => $type_id,
                'correlative' => 1,
                'year' => date('Y')
            ]);
        }
        /* Almacenar el número del correlativo  */
        $number = $correlative->correlative;

        /* Aumentar el correlativo y guardarlo */
        $correlative->correlative += 1;
        $correlative->save();

        /* Retornar el número actial */
        return $number;
    }
}