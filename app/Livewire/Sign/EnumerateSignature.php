<?php

namespace App\Livewire\Sign;

use App\Mail\Signature\NotificationSignedDocument;
use App\Models\Documents\Correlative;
use App\Models\Documents\Sign\Signature;
use App\Services\ImageService;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Str;

class EnumerateSignature extends Component
{
    public $signature;

    public function render()
    {
        return view('livewire.sign.enumerate-signature');
    }

    #[On('enumerate')]
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
        $apiToken = env('FIRMA_API_TOKEN_IONLINE');
        $secret = env('FIRMA_SECRET_IONLINE');

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
        $jwt = JWT::encode($payload, $secret, 'HS256');

        /**
         * Obtengo la coordenada top para ubicar el numero de documento
         */
        $coordinate = app(Signature::class)->calculateTop($signature->link_signed_file);
        $xCoordinate = $coordinate['x'];
        $yCoordinate = $coordinate['y'];

        /**
         * Obtengo la data del signature
         */
        $documentBase64Pdf = base64_encode(file_get_contents($signature->link_signed_file));

        $data = app(Signature::class)->getData($documentBase64Pdf, $jwt, $documentNumberBase64, $apiToken, $xCoordinate, $yCoordinate, true, 1);

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
        $contents = base64_decode($json['files'][0]['content']);

        Storage::put($file, $contents);

        /**
         * Actualiza el link del documento
         */
        $signature->update([
            'signed_file' => $file,
        ]);

        /**
         * Envia por email el documento numerado
         */
        $this->sendDistribution();

        session()->flash('success', 'El documento fue numerado y distribuido exitosamente.');
        return redirect()->route('v2.documents.signatures.index');
    }

    public function sendDistribution()
    {
        /**
         * Setea el array de emails
         */
        $emails = $this->signature->distribution_array;
        $emails = $emails->filter(function($email) {
            return Str::contains($email, '@');
        });

        /**
         * Envia la notificacion por email
         */
        if($emails->isNotEmpty()) {
            Mail::to($emails)->queue(new NotificationSignedDocument($this->signature));
        }
    }
}
