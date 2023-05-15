<?php

namespace App\Http\Livewire\Sign;

use App\Models\Documents\Sign\Signature;
use App\Models\Documents\Sign\SignatureFlow;
use App\Services\ImageService;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class SignatureIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $filterBy = "all";
    public $search;
    public $otp;

    public function render()
    {
        return view('livewire.sign.signature-index', [
            'signatures' => $this->getSignatures()
        ]);
    }

    public function getSignatures()
    {
        $search = "%$this->search%";

        $signatures = Signature::query()
            ->when(isset($this->search), function ($query) use($search) {
                $query->whereHas('flows', function($query) {
                    $query->whereSignerId(auth()->id());
                })->where(function($query) use($search) {
                    $query->where('subject', 'like', $search)
                    ->orWhere('description', 'like', $search);
                });
            })
            ->when($this->filterBy != "all", function($query) {
                $query->whereHas('flows', function($query) {
                    $query->when($this->filterBy == 'pending', function ($query) {
                        $query->whereStatus('pending');
                    }, function ($query) {
                        $query->whereIn('status', ['signed', 'rejected']);
                    })
                    ->whereSignerId(auth()->id());
                });
            })
            ->orderByDesc('id')
            ->whereHas('flows', function($query) {
                $query->whereSignerId(auth()->id());
            })
            ->paginate(10);

        return $signatures;
    }

    /**
     * Pasar al componente: vista o link, usuario id, position: derecha, centro o izquierda, fila 1, ruta 1 y nombre de archivo.
     * Devolver un callback con el link, modulo drogas, acta 505.
     * devuelvo el link. Nombre de ruta y parámetros como array.
     *
     * @param  Signature $signature
     * @return void
     */
    public function signDocument(Signature $signature)
    {
        /**
         * Obtiene el usuario autenticado
         */
        $user = auth()->user();

        /**
         * Obtiene el signatureFlow asociado
         */
        $signatureFlow = SignatureFlow::query()
            ->whereSignatureId($signature->id)
            ->whereSignerId($user->id)
            ->first();

        /**
         * Setea el otp
         */
        $otp = $this->otp;

        /**
         * Obtiene el link del documento
         */
        $document = $signature->link;

        /**
         * Obtiene el base64 del pdf y el checksum
         */
        $base64Pdf = base64_encode(file_get_contents($document));
        $checkSumPdf = md5_file($document);

        /**
         * Obtiene la imagen con el numero de Documento
         */
        $imageWithDocumentNumber = app(ImageService::class)->createSignature($user);
        ob_start();
        imagepng($imageWithDocumentNumber);
        $signatureBase64 = base64_encode(ob_get_clean());
        imagedestroy($imageWithDocumentNumber);

        /**
         * Setea las credenciales de la api desde el env
         */
        $url = env('FIRMA_URL');
        $apiToken = env('FIRMA_API_TOKEN');
        $secret = env('FIRMA_SECRET');

        /**
         * Setea la info para firmar un documento
         */
        $page = 'LAST';

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
        $payload = app(Signature::class)->getPayload($modo, $user->id);

        /**
         * Convierte y firma un objeto de php a un string de JWT
         */
        $jwt = JWT::encode($payload, $secret);

        /**
         * Asigna coordenadas
         */
        $xCoordinate = $signatureFlow->x;
        $yCoordinate = $signatureFlow->y;

        /**
         * Largo y ancho de la imagen
         */
        $heightFirma = 200;
        $widthFirma = 100;

        /**
         * Set the file data
         */
        $data = [
            'api_token_key' => $apiToken,
            'token' => $jwt,
            'files' => [
                [
                    'content-type' => 'application/pdf',
                    'content' => $base64Pdf,
                    'description' => 'str',
                    'checksum' => $checkSumPdf,
                    'layout' => "
                        <AgileSignerConfig>
                            <Application id=\"THIS-CONFIG\">
                                <pdfPassword/>
                                <Signature>
                                    <Visible active=\"true\" layer2=\"false\" label=\"true\" pos=\"2\">
                                        <llx>" . ($xCoordinate). "</llx>
                                        <lly>" . ($yCoordinate). "</lly>
                                        <urx>" . ($xCoordinate + $heightFirma) . "</urx>
                                        <ury>" . ($yCoordinate + $widthFirma + 5) . "</ury>
                                        <page>" . $page . "</page>
                                        <image>BASE64</image>
                                        <BASE64VALUE>$signatureBase64</BASE64VALUE>
                                    </Visible>
                                </Signature>
                            </Application>
                        </AgileSignerConfig>"
                ]
            ]
        ];

        /**
         * Peticion a la api para firmar
         */
        $response = Http::withHeaders(['otp' => $otp])->post($url, $data);

        $json = $response->json();

        /**
         * Verifica si existe un error
         */
        if (array_key_exists('error', $json)) {

            session()->flash('danger', 'El proceso de firma produjo un error. Codigo 1');
            return redirect()->route('v2.documents.signatures.index');

            return ['statusOk' => false,
                'content' => '',
                'errorMsg' => $json['error'],
            ];
        }

        if (!array_key_exists('content', $json['files'][0]))
        {
            if (array_key_exists('error', $json))
            {
                session()->flash('danger', 'El proceso de firma produjo un error. Codigo 2');
                return redirect()->route('v2.documents.signatures.index');
            }
            else
            {
                session()->flash('danger', 'El proceso de firma produjo un error. Codigo 3');
                return redirect()->route('v2.documents.signatures.index');
            }

        }

        /**
         * Guardar el archivo firmado en disco
         */
        $folder = Signature::getFolderSigned();
        $filename = $folder . "/" . $signature->id . "-". $signatureFlow->id;
        $file = $filename.".pdf";

        Storage::disk('gcs')
            ->getDriver()
            ->put($file, base64_decode($json['files'][0]['content']), ['CacheControl' => 'no-store']);

        /**
         * Actualiza el archivo en Signature
         */
        $signature->update([
            'file' => $file
        ]);

        /**
         * Actualiza el archivo y el estado en el SignatureFlow
         */
        $signatureFlow->update([
            'file' => $file,
            'status' => 'signed'
        ]);

        session()->flash('success', 'El documento fue firmado exitosamente');
        return redirect()->route('v2.documents.signatures.index');
    }
}
