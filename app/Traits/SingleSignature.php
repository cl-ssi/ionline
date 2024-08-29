<?php

namespace App\Traits;

use App\Models\Documents\Sign\Signature;
use App\Services\ImageService;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

trait SingleSignature
{
    public function signFile($signer, $position = 'center', $row = 1, $startY = 80, $pdfBase64, $otp, $filename, $callbackRoute = null, $callbackParams = null, $callbackControllerMethods = null, $callbackControllerParams = null, $dispatchEvent = null, $dispatchParams = null)
    {
        /**
         * Obtiene la imagen de la firma
         */
        $signatureBase64 = app(ImageService::class)->createSignature($signer);

        /**
         * Setea las credenciales de la api
         */
        $url = env('FIRMA_URL');
        $apiToken = env('FIRMA_API_TOKEN');
        $secret = env('FIRMA_SECRET');

        /**
         * Setea el modo para el payload
         */
        if(env('FIRMA_MODO') == 'test')
        {
            $modo = Signature::modoAtendidoTest();
        }
        else
        {
            $modo = Signature::modoAtendidoProduccion();
        }

        /**
         * Setea el payload del JWT
         */
        $payload = app(Signature::class)->getPayload($modo, $signer->id);

        /**
         * Convierte y firma un objeto de php a un string de JWT
         */
        $jwt = JWT::encode($payload, $secret, 'HS256');

        /**
         * Asigna coordenadas
         */
        $xCoordinate = app(Signature::class)->calculateColumn($position);
        $yCoordinate = app(Signature::class)->calculateRow($row, $startY);

        /**
         * Set the file data
         */
        $data = app(Signature::class)->getData($pdfBase64, $jwt, $signatureBase64, $apiToken, $xCoordinate, $yCoordinate, false);

        /**
         * Solicitud http a la api para firmar
         */
        try {
            $response = Http::withHeaders(['otp' => $otp])->post($url, $data);
        } catch (\Throwable $th) {
            throw new Exception("Disculpe, se produjo un error con firma electrónica, intente nuevamente.");
        }

        $json = $response->json();

        /**
         * Verifica si existe un error
         */
        if (array_key_exists('error', $json))
        {
            throw new Exception($json['error'], 1);
        }
        elseif(!array_key_exists('content', $json['files'][0]))
        {
            if (array_key_exists('error', $json))
            {
                throw new Exception($json['error'], 2);
            }
            else
            {
                throw new Exception($json['files'][0]['status'], 3);
            }
        }

        /**
         * Muestra el mensaje de error
         */
        if(isset($json['files'][0]['content']))
        {
            /**
             * Obtiene el archivo, la carpeta y el nombre del archivo
             */
            $file = $filename.".pdf";
            $contentFile = base64_decode($json['files'][0]['content']);

            /**
             * Guarda el archivo en el storage
             */
            Storage::disk('gcs')->put($file, $contentFile, ['CacheControl' => 'no-store']);

            /**
             * Redirige a la ruta del callbackRoute
             */
            if($callbackRoute)
            {
                return redirect()->route($callbackRoute, $callbackParams);
            }

            /**
             * Ejecuta dispatch, definido en callbackControllerMethods y emit al dispatchEvent
             */
            if(isset($dispatchEvent) && isset($callbackControllerMethods)) {
                app()->call($callbackControllerMethods,
                json_decode($callbackControllerParams, true));

                $this->dispatch($dispatchEvent, $dispatchParams);
            }
        }
    }
}