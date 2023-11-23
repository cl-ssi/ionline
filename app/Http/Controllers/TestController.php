<?php

namespace App\Http\Controllers;

use setasign\Fpdi\PdfParser\StreamReader;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Firebase\JWT\JWT;
use Exception;
use Carbon\Carbon;
use App\User;
use App\Services\ImageService;
use App\Rrhh\OrganizationalUnit;
use App\Models\WebService\MercadoPublico;
use App\Models\Establishment;
use App\Models\Documents\Sign\Signature;
use App\Models\Documents\DocDigital;
use App\Jobs\TestJob;

class TestController extends Controller
{
    /**
    * DocDigital
    */
    public function docDigital()
    {
        $doc = new DocDigital();
        $filtro = [
            // 'nombreDestinatario' => 'Carla Andrea Cubillos Araya',
            // 'runDestinatario' => '14107361',
            'materia' => 'Rescate usuarios',
        ];
        dd($doc->getDocumentosBuscar($filtro));
    }

    /**
    * Digital Signature
    */
    public function DigitalSignature()
    {
        // $purpose = 'Propósito General';
        $purpose = 'Desatendido';
        // $purpose = 'iOnline';

        $user = User::find(15287582);
        $otp = '322494'; // Sólo para Propósito General

        $page = 'LAST'; // 1,2,3 ... LAST

        $signatureImageBase64 = app(ImageService::class)->createSignature($user);
        // $signatureImageBase64 = app(ImageService::class)->createDocumentNumber("002342-Xdf4", "13.089");

        /** Tamaño de la firma */
        // 160 39
        $width = 930 * 0.172;
        $height = 206 * 0.189;

        //dd($width, $height);

        /** Tamaño del foliado */
        // $width = floor(1100 * 0.172);
        // $height = floor(280 * 0.189);


        /** Obtener el tamaño de la página */
        // $fileContent = file_get_contents(public_path('samples/download.pdf'));
        // $pdf = new Fpdi('P', 'mm');
        // $pdf->setSourceFile(StreamReader::createByString($fileContent));
        // $firstPage = $pdf->importPage(1);
        // $size = $pdf->getTemplateSize($firstPage);

        // /**
        //  * Calculo de milimetros a centimetros
        //  */
        // $widthFile = $size['width'] / 10;
        // $heightFile = $size['height'] / 10;

        // /**
        //  * Calculo de centimetros a pulgadas y cada pulgada son 72 ppp (dots per inch - dpi)
        //  */
        // $xCoordinate = ($widthFile * 0.393701) * 72;
        // $yCoordinate = ($heightFile * 0.393701) * 72;

        // /**
        //  * Resta 290 y 120 a las coordenadas
        //  */
        // $xCoordinate -= 218;
        // $yCoordinate -= 84;




        // $xCoordinate = 93.3; // Left
        // $xCoordinate = 256.4; // Center
        $xCoordinate = 418.8; // Right

        $yCoordinate = 72.3; // Primer piso
        // $yCoordinate = 110.4; // Segundo piso


        /**
         * Documentos a firmar
         */
        $documentBase64 = base64_encode(file_get_contents(public_path('samples/download.pdf')));

        $files[] = [
            'content' => $documentBase64, 
            'checksum' => md5($documentBase64)
        ];




        /** Esto es fijo */
        $url = env('FIRMA_URL');
        $secret = env('FIRMA_SECRET');
        $entity = 'Servicio de Salud Iquique';

        $payload = [
            "purpose" => $purpose,
            "entity" => $entity,
            "run" => $user->id,
            "expiration" => now()->add(30, 'minutes')->format('Y-m-d\TH:i:s'),
        ];

        $data['api_token_key'] = env('FIRMA_API_TOKEN');
        $data['token'] = JWT::encode($payload, $secret, 'HS256');

        foreach($files as $file) {
            $data['files'][] = [
                'content-type' => 'application/pdf',
                'content' => $file['content'],
                'description' => 'str',
                'checksum' => $file['checksum'],
                'layout' => "
                    <AgileSignerConfig>
                        <Application id=\"THIS-CONFIG\">
                            <pdfPassword/>
                            <Signature>
                                <Visible active=\"true\" layer2=\"false\" label=\"true\" pos=\"2\">
                                    <llx>" . ($xCoordinate). "</llx>
                                    <lly>" . ($yCoordinate). "</lly>
                                    <urx>" . ($xCoordinate + $width) . "</urx>
                                    <ury>" . ($yCoordinate + $height) . "</ury>
                                    <page>" . $page . "</page>
                                    <image>BASE64</image>
                                    <BASE64VALUE>$signatureImageBase64</BASE64VALUE>
                                </Visible>
                            </Signature>
                        </Application>
                    </AgileSignerConfig>"
            ];
        }

        /**
         * Peticion a la api para firmar
         */
        try {
            $response = Http::withHeaders(['otp' => $otp])->post($url, $data);
        } catch (\Throwable $th) {
            dd("No se pudo conectar a firma gobierno.", $th->getCode());
        }

        if($response->failed()) {
            dd($response->reason());
        }

        $json = $response->json();

        if(array_key_exists('error',$json)) {
            dd($json['error']);
        }

        $decodedPdf = base64_decode($json['files'][0]['content']);

        // Create a response with the correct headers for a PDF file
        $response = response($decodedPdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);

        return $response;


        //$approval->resetStatus();
        // $img = app(ImageService::class)->createDocumentNumber("452342-Xdfgf4", "13.089");
        // //$img = app(ImageService::class)->createSignature(User::find(17367679));
        // echo '<img src="data:image/png;base64,' . $img . '">';
    }

    public function getIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // Check IP from internet.
            // 'ip' => request()->getClientIp(),
            $ip = $_SERVER['HTTP_CLIENT_IP'];
            logger()->info('HTTP_CLIENT_IP: ' . $_SERVER['HTTP_CLIENT_IP']);
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Check IP is passed from proxy.
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            logger()->info('HTTP_X_FORWARDED_FOR: ' . $_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            // Get IP address from remote address.
            $ip = $_SERVER['REMOTE_ADDR'];
            logger()->info('REMOTE_ADDR: ' . $_SERVER['REMOTE_ADDR']);
        }

        //Storage::disk('local')->prepend('log_ips.txt', $ip);
        return $ip;
    }

    /*
    curl -X PATCH -H "Accept: application/vnd.github.v3+json" https://api.github.com/repos/cl-ssi/urgency/issues/22 -d '{"title":"Second Up"}'
    */

    public function getMercadoPublicoTender($date)
    {
        $tenders = MercadoPublico::getTender(Carbon::parse($date));
        dd($tenders);
    }

    public function log()
    {
        $user = \App\User::find(1528758);
        echo $user->name;
        Log::info('primer log');
        echo 'Primer log';
    }

    public function info()
    {
        phpinfo();
    }

    /**
     * No cargar
     */
    public function loopLivewire()
    {
        $ous = OrganizationalUnit::all();

        foreach ($ous as $ou) {
            // @livewire( parametro ou)
            $estab = Establishment::where('id', $ou->establishment_id)->first();
            // echo $estab->id."<br>";
            if ($estab->type == 'HOSPITAL') {
                echo $estab->name . '<br>';
            }
            // fin de livewire
        }
    }

    /**
     * Test Job
     */
    public function job()
    {
        TestJob::dispatch(auth()->user())
            // ->onConnection('cloudtasks')
            ->delay(15);

        return view('mails.test', [
            'user' => auth()->user(),
        ]);

        // return "Test Job Dispatch";
    }

    /**
     * Test de cards en teams
     */
    public function SendCardToTeams()
    {
        $wh = env('LOG_TEAMS_WEBHOOK_URL_ATORRES');

        // $data['text'] = 'Hello world';

        $data = [
            '@type' => 'MessageCard',
            '@context' => 'http://schema.org/extensions',
            'themeColor' => '0076D7',
            'summary' => 'Larry Bryant created a new task',
            'sections' => [
                [
                    'activityTitle' => 'Larry Bryant created a new task',
                    'activitySubtitle' => 'On Project Tango',
                    'activityImage' => 'https://teamsnodesample.azurewebsites.net/static/img/image5.png',
                    'facts' => [
                        [
                            'name' => 'Assigned to',
                            'value' => 'Unassigned',
                        ],
                        [
                            'name' => 'Due date',
                            'value' => 'Mon May 01 2017 17:07:18 GMT-0700 (Pacific Daylight Time)',
                        ],
                        [
                            'name' => 'Status',
                            'value' => 'Not started',
                        ],
                    ],
                    'markdown' => true,
                ],
            ],
            'potentialAction' => [
                [
                    '@type' => 'ActionCard',
                    'name' => 'Add a comment',
                    'inputs' => [
                        [
                            '@type' => 'TextInput',
                            'id' => 'comment',
                            'isMultiline' => false,
                            'title' => 'Add a comment here for this task',
                        ],
                    ],
                    'actions' => [
                        [
                            '@type' => 'HttpPOST',
                            'name' => 'Add comment',
                            'target' => 'https://learn.microsoft.com/outlook/actionable-messages',
                        ],
                    ],
                ],
                [
                    '@type' => 'ActionCard',
                    'name' => 'Set due date',
                    'inputs' => [
                        [
                            '@type' => 'DateInput',
                            'id' => 'dueDate',
                            'title' => 'Enter a due date for this task',
                        ],
                    ],
                    'actions' => [
                        [
                            '@type' => 'HttpPOST',
                            'name' => 'Save',
                            'target' => 'https://learn.microsoft.com/outlook/actionable-messages',
                        ],
                    ],
                ],
                [
                    '@type' => 'OpenUri',
                    'name' => 'Post x More',
                    'targets' => [
                        [
                            'os' => 'default',
                            'uri' => 'http://localhost:8000/postx',
                        ],
                    ],
                ],
                [
                    '@type' => 'ActionCard',
                    'name' => 'Change status',
                    'inputs' => [
                        [
                            '@type' => 'MultichoiceInput',
                            'id' => 'list',
                            'title' => 'Select a status',
                            'isMultiSelect' => 'false',
                            'choices' => [
                                [
                                    'display' => 'In Progress',
                                    'value' => '1',
                                ],
                                [
                                    'display' => 'Active',
                                    'value' => '2',
                                ],
                                [
                                    'display' => 'Closed',
                                    'value' => '3',
                                ],
                            ],
                        ],
                    ],
                    'actions' => [
                        [
                            '@type' => 'HttpPOST',
                            'name' => 'Save',
                            'target' => 'https://learn.microsoft.com/outlook/actionable-messages',
                        ],
                    ],
                ],
            ],
        ];

        $response = Http::withBody(json_encode($data), 'application/json')->post($wh);

        if ($response->failed()) {
            dd(json_decode($response->getBody(), true));
        } else {
            dd('success');
        }
    }
}
