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

    public static function getTender($code)
    {
        $response = Http::get('http://api.mercadopublico.cl/servicios/v1/publico/licitaciones.json', [
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
            $purchaseOrder = null;

            $response = Http::get('http://api.mercadopublico.cl/servicios/v1/publico/ordenesdecompra.json', [
                'codigo' => $code,
                'ticket' => env('TICKET_MERCADO_PUBLICO')
            ]);

            if($response->successful())
            {
                $objoc = json_decode($response);

                $purchaseOrder = PurchaseOrder::create([
                    'code' => $objoc->Listado[0]->Codigo,
                    'date' => Carbon::parse($objoc->Listado[0]->Fechas->FechaCreacion)->format('Y-m-d H:i:s'),
                    'data' => $response,
                ]);
            }
        }

        return $purchaseOrder;
    }
}
