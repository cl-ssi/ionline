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
        'establishment_id'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doc_correlatives';

    public static function getCorrelativeFromType($type_id, $establishment_id = null)
    {
        abort_if(auth()->user()->organizational_unit_id == null, 501,'El usuario no tiene unidad organizacional asociada');

        if($establishment_id == NULL){
            $establishment_id = auth()->user()->organizationalUnit->establishment_id;
        }

        /* Obtener el objeto correlativo según el tipo */
        $correlative = Correlative::where('type_id', $type_id)
            ->where('establishment_id',$establishment_id)
            ->lockForUpdate()
            ->first();

        if(!$correlative) {
            $correlative = Correlative::create([
                'type_id' => $type_id,
                'correlative' => 1,
                'establishment_id' => $establishment_id
            ])->lockForUpdate();
        }
        /* Almacenar el número del correlativo  */
        $number = $correlative->correlative;

        /* Aumentar el correlativo y guardarlo */
        $correlative->correlative += 1;
        $correlative->save();

        /* Retornar el número actual */
        return $number;
    }
}