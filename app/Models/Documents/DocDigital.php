<?php

namespace App\Models\Documents;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocDigital extends Model
{
    use HasFactory;

    private $client;

    /**
     * Get Token
     */
    public function __construct()
    {
        if (session('token') == null) {
            $url = env('DOC_DIGITAL_URL') . '/oauth/token';
            $response = Http::withBasicAuth(env('DOC_DIGITAL_CLIENT_ID'), env('DOC_DIGITAL_SECRET'))->post($url);
            $body = $response->body();
            Session::put('token', json_decode($body)->access_token, now()->addMinutes(json_decode($body)->expires_in));
        }

        $this->client = Http::withToken(session('token'))->baseUrl(env('DOC_DIGITAL_URL'));
    }

    /**
     * Obtiene la Entidad del token
     */
    public function getEntidadesToken()
    {
        $response = $this->client->get('/entidades/token');
        $body = $response->body();
        return json_decode($body);
    }

    /**
     * Busca los documentos de la entidad
     */
    public function getDocumentosBuscar($filtro = [])
    {
        $response = $this->client->get('/documentos/buscar',$filtro);
        $body = $response->body();
        return json_decode($body);
    }

    /**
     * Obtiene los documentos Recibidos
     */
    public function getDocumentosRecibidos()
    {
        $response = $this->client->get('/documentos/recibidos',[
            'runDestinatario' => '14107361',
        ]);
        $body = $response->body();
        return json_decode($body);
    }
}
