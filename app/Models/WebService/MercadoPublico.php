<?php

namespace App\Models\WebService;

use App\Models\RequestForms\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class MercadoPublico extends Model
{
    use HasFactory;

    public static function getTender($code, $type)
    {
        $response = Http::get('https://api.mercadopublico.cl/servicios/v1/publico/'.$type.'.json', [
            'codigo' => $code,
            'ticket' => env('TICKET_MERCADO_PUBLICO')
        ]);

        return $response->collect();
    }

    public static function getPurchaseOrder($code)
    {
        $purchaseOrder = PurchaseOrder::whereCode($code);

        if($purchaseOrder->exists())
            $purchaseOrder = $purchaseOrder->first();
        else
        {
            $purchaseOrder = 4;

            $response = Http::get('https://api.mercadopublico.cl/servicios/v1/publico/ordenesdecompra.json', [
                'codigo' => $code,
                'ticket' => env('TICKET_MERCADO_PUBLICO')
            ]);

            if($response->successful())
            {
                $objOC = json_decode($response);

                if($objOC->Cantidad == 0) // OC No Valida, Eliminada o No Aceptada
                    $purchaseOrder = 2;
                elseif($objOC->Listado[0]->Estado == 'Cancelada') // OC Cancelada
                    $purchaseOrder = 3;

                if(($objOC->Cantidad > 0) && ($objOC->Listado[0]->Estado != 'Cancelada')) // OC Bien
                {
                    $purchaseOrder = PurchaseOrder::create([
                        'code' => $objOC->Listado[0]->Codigo,
                        'date' => Carbon::parse($objOC->Listado[0]->Fechas->FechaCreacion)->format('Y-m-d H:i:s'),
                        'data' => $response,
                    ]);
                }
            }
            else
                $purchaseOrder = 1; // Codigo de la OC invalida
        }

        return $purchaseOrder;
    }

    public static function getPurchaseOrderError($purchaseOrder)
    {
        $error = false;
        if($purchaseOrder === 1 || $purchaseOrder === 2 || $purchaseOrder === 3 || $purchaseOrder === 4)
            $error = true;
        return $error;
    }

    public static function getPurchaseOrderErrorMessage($purchaseOrder)
    {
        $msg = null;
        if($purchaseOrder === 1) // 1
            $msg = 'El número de orden de compra es errado.';
        elseif($purchaseOrder === 2) // 2
            $msg = 'La orden de compra está eliminada, no aceptada o es inválida.';
        elseif($purchaseOrder === 3) // 3
            $msg = 'La orden de compra esta cancelada.';
        elseif($purchaseOrder === 4) // 4
            $msg = 'Disculpe, no pudimos obtener los datos de la orden de compra, intente nuevamente.';
        return $msg;
    }
}
