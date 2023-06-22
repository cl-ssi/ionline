<?php

namespace App\Http\Livewire\Sign;

use App\Models\Documents\Correlative;
use App\Models\Documents\Sign\Signature;
use App\Services\ImageService;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class EnumerateSignature extends Component
{
    public $signature;

    public function render()
    {
        return view('livewire.sign.enumerate-signature');
    }

    protected $listeners = [
        'enumerate'
    ];

    public function enumerate()
    {
        /**
         * Obtengo el signature
         */
        $signature = $this->signature;

        /**
         * Obtengo el usuario que puede firmar de forma desantendida
         */
        $user = User::find(auth()->id());

        /**
         * Muestra un mensaje de error en caso de estar numerado un documento o incompleto.
         */
        if(! $signature->isCompleted())
        {
            session()->flash('danger', 'El documento no esta completado o ya esta numerado');
            return redirect()->route('v2.documents.signatures.index', ['pendientes']);
        }

        /**
         * Guarda el numero correlativo en Signature
         */
        $signature->update([
            'number' => Correlative::getCorrelativeFromType($signature->type_id),
            'verification_code' => Signature::getVerificationCode($signature),
        ]);

        /**
         * Obtiene la imagen con el numero de Documento en Base 64
         */
        $documentNumberBase64 = app(ImageService::class)->createDocumentNumber($signature->verification_code, $signature->number);

        /**
         * Setea las credenciales de la api desde el env
         */
        $url = env('FIRMA_URL');
        $apiToken = env('FIRMA_API_TOKEN_DESATENDIDO');
        $secret = env('FIRMA_SECRET_DESATENDIDO');

        /**
         * Setea el modo para el payload
         */
        $modo = (env('FIRMA_MODO') == 'test') ? Signature::modoDesatendidoTest() : Signature::modoDesatendidoProduccion();

        /**
         * Setea el payload del JWT
         */
        $payload = app(Signature::class)->getPayload($modo, $user->id);

        /**
         * Convierte y firma un objeto de php a un string de JWT
         */
        $jwt = JWT::encode($payload, $secret);

        /**
         * Obtengo la coordenada top para ubicar el numero de documento
         */
        $coordinate = app(Signature::class)->calculateTop($signature->link_signed_file);
        $xCoordinate = $coordinate['x'];
        $yCoordinate = $coordinate['y'];

        /**
         * Obtengo la data del signature
         */
        $data = app(Signature::class)->getData($signature->link_signed_file, $jwt, $documentNumberBase64, $apiToken, $xCoordinate, $yCoordinate, true, 1);

        /**
         * Peticion la api para firmar
         */
        $response = Http::post($url, $data);
        $json = $response->json();

        $message = null;

        /**
         * Verifica si existe un error
         */
        if (array_key_exists('error', $json))
        {
            $message = $json['error'];
        }
        elseif(!array_key_exists('content', $json['files'][0]))
        {
            if (array_key_exists('error', $json))
            {
                $message = $json['error'];
            }
            else
            {
                $message = $json['files'][0]['status'];
            }
        }

        if(isset($message))
        {
            $signature->update([
                'number' => null,
                'verification_code' => null,
            ]);

            session()->flash('danger', "Error: $message");
            return redirect()->route('v2.documents.signatures.index');
        }

        /**
         * Guardar el archivo numerado en disco
         */
        $folder = Signature::getFolderEnumerate();
        $filename = $folder . "/" . $signature->number . "-". now()->timestamp;
        $file = $filename.".pdf";

        logger()->info($file);

        Storage::disk('gcs')
            ->getDriver()
            ->put($file, base64_decode($json['files'][0]['content']));

        /**
         * Actualiza el link del documento
         */
        $signature->update([
            'signed_file' => $file,
        ]);

        session()->flash('success', 'El documento fue numerado exitosamente');
        return redirect()->route('v2.documents.signatures.index');
    }
}
