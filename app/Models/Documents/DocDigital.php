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
     * Archivo Swagger Prod = https://api-doc.digital.gob.cl/api/def/swagger-ui/
     * Archivo Swagger Demo = https://api-demodoc.digital.gob.cl/api/def/swagger-ui/
     * Access_Token Prod    = https://api-doc.digital.gob.cl/api/oauth/token
     * Access_Token Demo    = https://api-demodoc.digital.gob.cl/api/oauth/token
     * 
     * agregar en .env
     * DOC_DIGITAL_URL=https://api-demodoc.digital.gob.cl/api
     * DOC_DIGITAL_CLIENT_ID=
     * DOC_DIGITAL_SECRET=
     */


    /**
     * Pruebas requeridas en DemoDoc
     * ==============================
     * 1. Caso de uso de recepción de documentos. (Recepción Conforme)
     *    (POST/api/documentos/recibidos/{id}/acusorecibo)
     * 
     * 2. Caso de uso de devolución de documentos (Recepción Rechazo)
     *    (POST/api/documentos/recibidos/{id}/devolver)
     * 
     * 3. Caso de uso de ingreso de los documentos: envío efectivo a usuarios 
     *    destinatarios específicos/oficina de partes y si corresponde
     *    incorporación de documentación en formato borrador.
     *    (POST /api/documentos/firmado/ingresar)
     *    (POST /api/documentos/firmado/borrador): Sólo si aplica.
     * 
     * Evidencias requeridas DemoDoc
     * 1. Json utilizados por cada método
     * 2. Documento con las evidencias de ejecución exitosa de los métodos probados (capturas de pantalla).
     * 3. Capturas de pantalla de lo que se visualiza en DemoDoc
     */


    /**
     * Constructor que obtiene el token una vez, si no existe en la sessión
     */
    public function __construct()
    {
        if (session('token') == null) {
            $url = env('DOC_DIGITAL_URL') . '/oauth/token';
            $response = Http::withBasicAuth(env('DOC_DIGITAL_CLIENT_ID'), env('DOC_DIGITAL_SECRET'))->post($url);
            $body = $response->body();
            Session::put('token', json_decode($body)->access_token, now()->addMinutes(json_decode($body)->expires_in));
        }
        // app('debugbar')->info(session('token'));
        $this->client = Http::withToken(session('token'))->baseUrl(env('DOC_DIGITAL_URL'));
    }

    /**
     * Obtiene la Entidad del token
     */
    public function getEntidadesToken()
    {
        $response = $this->client->get('/entidades/token');
        return json_decode($response->body(), true);
    }

    /**
     * Busca los documentos de la entidad
     */
    public function getDocumentosBuscar($filtro = [])
    {
        $response = $this->client->get('/documentos/buscar',$filtro);
        return json_decode($response->body(), true);
    }

    /**
     * Método para obtener los documentos creados por la entidad asociada al token de autenticación
     */
    public function getDocumentosCreados($filtro = [])
    {
        $response = $this->client->get('/documentos/creados', $filtro);
        return json_decode($response->body(), true);
    }

    /**
     * Obtiene los documentos Recibidos
     */
    public function getDocumentosRecibidos($filtro = [])
    {
        $response = $this->client->get('/documentos/recibidos', $filtro);
        return json_decode($response->body(), true);
    }

    /**
     * Obtiene los documentos Recibidos
     */
    public function getDocumentosArchivo($documento_id, $id)
    {
        $response = $this->client->get('/documentos/'.$documento_id.'/archivo', ['archivo_id' => $id]);
        return json_decode($response->body());
    }

    /**
     * Método para obtener usuarios o destinatario
     * ===========================================
     * 
     * idEntidad        integer($int32)   ID de la entidad
     * idOrganismo      integer($int32)   ID del organismo
     * nombre           string            Nombre o Apellido del usuario. Búsqueda por coincidencia
     * nombreEntidad    string            Nombre de la entidad. Búsqueda por coincidencia
     * nombreOrganismo  string            Nombre del organismo. Búsqueda por coincidencia
     * run              integer($int32)   RUN de usuario sin guion y ni dígito verficador. Ej.: 12040901
     * tipo             integer($int32)   Tipo rol usuario: 1=tramitador | 2=OP Salida | 3=OP Entrada | 4=Admin
     */
    public function getUsuarios($filtro = [])
    {
        $response = $this->client->get('/usuarios/', $filtro);
        return json_decode($response->body());
    }
}
