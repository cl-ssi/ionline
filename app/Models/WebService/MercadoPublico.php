<?php

namespace App\Models\WebService;

use App\Models\Finance\PurchaseOrder as FinancePurchaseOrder;
use App\Models\RequestForms\PurchaseOrder;
use Exception;
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
            $response = Http::withToken(env('WSSSI_AUTH_TOKEN'))->get(env('WSSSI_CHILE_URL')."/purchase-order/$code");

            $oc = json_decode($response);

            if($response->successful())
            {
                $purchaseOrder = PurchaseOrder::create([
                    'code' => $oc->Listado[0]->Codigo,
                    'date' => Carbon::parse($oc->Listado[0]->Fechas->FechaCreacion)->format('Y-m-d H:i:s'),
                    'data' => $response,
                ]);
            }
            else
            {
                $response = json_decode($response->body());
                throw new Exception($response->message);
            }
        }

        return $purchaseOrder;
    }

    public static function getPurchaseOrderV2($code)
    {
        $purchaseOrder = FinancePurchaseOrder::whereCode($code)->first();

        if(!$purchaseOrder OR $purchaseOrder->json->Listado[0]->Estado != "Recepción Conforme"){

            try {
                $response = Http::withToken(env('WSSSI_AUTH_TOKEN'))->get(env('WSSSI_CHILE_URL')."/purchase-order-v2/$code");
            } catch(\Illuminate\Http\Client\ConnectionException $e) {
                if($purchaseOrder) {
                    return true;
                }
                else {
                    return "No existe en nuestros registros y no se pudo conectar con MercadoPublico.";
                }
            }

            $oc = json_decode($response);

            if($response->successful())
            {
                if($oc->Listado[0]) {
                    $purchaseOrder = FinancePurchaseOrder::updateOrCreate(
                    [
                        'code' =>  $oc->Listado[0]->Codigo
                    ],
                    [
                        'date' => Carbon::parse($oc->Listado[0]->Fechas->FechaCreacion)->format('Y-m-d H:i:s'),
                        'data' => $response,
                    ]);
                }
                return true;
            }
            else
            {
                if($purchaseOrder) {
                    return true;
                }
                else {
                    $response = json_decode($response->body());
                    if($response) {
                        return $response->message;
                    }
                    else {
                        return "No existe en nuestros registros y no se pudo conectar con MercadoPublico.";
                    }
                }
            }
        }
        else {
            return true;
        }
    }
}
