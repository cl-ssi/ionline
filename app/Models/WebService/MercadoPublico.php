<?php

namespace App\Models\WebService;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class MercadoPublico extends Model
{
    use HasFactory;

    public static function getTender($date){

        $response = Http::get('http://api.mercadopublico.cl/servicios/v1/publico/licitaciones.json', [
            'fecha' => $date->format('dmY'), 
            'ticket' => env('TICKET_MERCADO_PUBLICO')
        ]);

        return $response->collect();
    }

}
