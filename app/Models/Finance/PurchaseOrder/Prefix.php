<?php

namespace App\Models\Finance\PurchaseOrder;

use App\Models\Establishment;
// use App\Models\Finance\PurchaseOrder\Prefix;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Prefix extends Model
{
    use HasFactory;

    protected $table = 'fin_purchase_order_prefixes';

    protected $fillable = [
        'name',
        'prefix',
        'establishment_id',
        'cenabast'
    ];


    // id;name;prefix;establishment_id;cenabast
    // ========================================
    // 1;Servicio de Salud Tarapacá;1637;38
    // 2;Activo fijo;1057838;38
    // 3;Administracion de fondos;1077499;38
    // 4;Bienes y servicios;1057448;38
    // 5;Compra conjunta;1058517;38
    // 6;Convenios GORE;1180968;38
    // 7;Fármacos;1058052;38
    // 8;Hospital Alto Hospicio;1272565;41
    // 9;Obras civiles;1057964;38
    // 10;Servicio de Bienestar;2549;38
    // 11;Cenabat;621;null

    /** Belongs to Establihsmnet */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    /** 
     * Obtiene el ID del establecimiento a partir de un código de orden de compra dado.
     * @param string $purchaseOrderCode
     * @return int|null
     */
    public static function getEstablishmentIdFromPoCode($purchaseOrderCode)
    {
        $prefix = explode('-', trim($purchaseOrderCode));

        // Usamos el operador de fusión de null para proporcionar un valor predeterminado en caso de que no se encuentre ningún modelo
        $model = Cache::remember('prefix_' . $prefix[0], 60*60*24, function () use ($prefix) {
            return self::where('prefix', $prefix[0])->first();
        }) ?? null;

        // Comprobamos si el modelo existe antes de intentar acceder a sus propiedades
        return $model ? $model->establishment_id : null;
    }

    /** 
     * Obtiene si el código de orden de compra pertenece a Cenabast a partir de un código dado.
     * @param string $purchaseOrderCode
     * @return bool|null
     */
    public static function getIsCenabastFromPoCode($purchaseOrderCode)
    {
        $prefix = explode('-', trim($purchaseOrderCode));

        // Usamos el operador de fusión de null para proporcionar un valor predeterminado en caso de que no se encuentre ningún modelo
        $model = Cache::remember('prefix_' . $prefix[0], 60*60*24, function () use ($prefix) {
            return self::where('prefix', $prefix[0])->first();
        }) ?? null;

        // Comprobamos si el modelo existe antes de intentar acceder a sus propiedades
        return $model ? $model->cenabast : null;
    }

}
