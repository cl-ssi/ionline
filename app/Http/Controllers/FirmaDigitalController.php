<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use SimpleSoftwareIO\QrCode\Generator;


/* No se si son necesarias, las puse para el try catch */
use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;


class FirmaDigitalController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return pdf
     */
    public function signPdf()
    {
        // echo '<pre>'; /* Debug Para mostrar la imágen de la firma */
        //header("Content-Type: image/png; charset=UTF-8");

        /* Setear Variables */
        $testing        = true; /* Si es true se usará un run o otp de prueba */
        $run            = 15287582;
        $otp            = '040133';
        $tipo           = 'vb'; /* 'vb', 'principal' */
        $ct_firmas      = 4; /* Sólo para tipo "vb" */
        $pocision_firma = 1; /* Sólo para tipo "vb" */
        $pdf            = 'samples/original.pdf';
        /* Fin seteo de variable */

        $pdfbase64      = base64_encode(file_get_contents(public_path($pdf)));
        $checksum_pdf   = md5_file(public_path($pdf));

        /* Confección del cuadro imagen de la firma */
        $font_light   = public_path('fonts/verdana-italic.ttf');
        $font_bold    = public_path('fonts/verdana-bold-2.ttf');
        $font_regular = public_path('fonts/Verdana.ttf');

        $im = @imagecreate(400, 60) or die("Cannot Initialize new GD image stream");

        $background_color = imagecolorallocate($im, 204, 204, 204);
        $white            = imagecolorallocate($im, 255, 255, 255);

        //imagefilledrectangle($image,int $x1,int $y1,int $x2,int $y2,int $color).
        imagefilledrectangle(   $im,       1,      1,     398,     58,    $white);

        $text_color = imagecolorallocate($im, 0, 0, 0);

        $marginTop  = 1;
        $xAxis      = 5;
        $yPading    = 16;
        $fontSize   = 10;

        /* email=alvaro.torres@redsalud.gob.cl
         * cn=Álvaro Raymundo Edgardo Torres Fuchslocher
         * serialNumber=15287582-7
         * title=Profesional Sidra
         * o=Ministerio de Salud
         * cn=Autoridad Certificadora del Estado de Chile
         */

        imagettftext($im, $fontSize,   0, $xAxis, $yPading * 1 + $marginTop,
            $text_color, $font_light,  'Firmado digitalmente el 2020-12-21 16:21 por:');
        imagettftext($im, $fontSize+1, 0, $xAxis, $yPading * 2 + $marginTop + 2,
            $text_color, $font_bold,   'Jorge Patricio Galleguillos Möller');
        imagettftext($im, $fontSize,   0, $xAxis, $yPading * 3 + $marginTop + 3,
            $text_color, $font_regular,'email = director.ssi@redsalud.gob.cl');
        /*
        imagettftext($im, $fontSize, 0, $xAxis, $yPading * 4 + $marginTop + 3,
            $text_color, $font_light, 'serialNumber = 15287582-7');
        imagettftext($im, $fontSize, 0, $xAxis, $yPading * 5 + $marginTop + 3,
            $text_color, $font_light, 'title = Profesional Sidra');
        imagettftext($im, $fontSize, 0, $xAxis, $yPading * 6 + $marginTop + 3,
            $text_color, $font_light, 'o = Ministerio de Salud');
        imagettftext($im, $fontSize, 0, $xAxis, $yPading * 7 + $marginTop + 3,
            $text_color, $font_light, 'cn = Autoridad Certificadora del Estado de Chile');
        */

        // Alvaro Raymundo Edgardo Torres Fuchslocher
        // Esteban Alejandro Rojas García
        // Oscar Jesus Zavala Cortés

        /* Obtener Imagen de firma en variable $firma */
        ob_start();
        imagepng($im);
        $firma = base64_encode(ob_get_clean());
        imagedestroy($im);
        //die();

        /* Fin cuadro de firma */




        if($testing) {
            $url = 'https://api.firma.test.digital.gob.cl/firma/v2/files/tickets';
            $api_token = 'sandbox';
            $secret = 'abcd';

            $run = 22222222;  // $run = 22222222;
            $otp = 227083;

            $purpose = 'Desatendido'; // $purpose = 'Propósito General';
            $entity = 'Subsecretaría General de La Presidencia';

            /* $pdfbase64 = base64_encode(file_get_contents(public_path('samples/sample3.pdf'))); */
        }
        else {
            $url = 'https://api.firma.digital.gob.cl/firma/v2/files/tickets';
            $api_token = env('FIRMA_API_TOKEN');
            $secret = env('FIRMA_SECRET');

            $purpose = 'Propósito General';
            $entity = 'Servicio de Salud Iquique';
        }


        /* Confección firma en JWT */
        $payload = [
            "purpose"   => $purpose,
            "entity"    => $entity,
            "expiration"=> now()->add(30,'minutes')->format('Y-m-d\TH:i:s'),
            "run"       => $run
        ];

        $jwt = JWT::encode($payload, $secret);
        // die($jwt);


        if($tipo == 'vb') {
            $padding        = 25;
            $coordenada_x   = 65;
            $coordenada_y   = 50 + $padding * $ct_firmas - ($pocision_firma * $padding);
            $ancho          = 170 * 0.9;
            $alto           = 30  * 0.9;
        }
        else if($tipo == 'principal'){
            $coordenada_x   = 310;
            $coordenada_y   = 49;
            $ancho          = 170 * 1.4;
            $alto           = 30  * 1.4;
        }


        $data = [
            'api_token_key' => $api_token,
            'token' => $jwt,
            'files' => [
                [
                    'content-type' => 'application/pdf',
                    'content' => $pdfbase64,
                    'description' => 'str',
                    'checksum' => $checksum_pdf,
                    'layout' => "
                        <AgileSignerConfig>
                            <Application id=\"THIS-CONFIG\">
                                <pdfPassword/>
                                <Signature>
                                    <Visible active=\"true\" layer2=\"false\" label=\"true\" pos=\"1\">
                                        <llx>". $coordenada_x ."</llx>
                                        <lly>". $coordenada_y ."</lly>
                                        <urx>". ($coordenada_x + $ancho) ."</urx>
                                        <ury>". ($coordenada_y + $alto)  ."</ury>
                                        <page>LAST</page>
                                        <image>BASE64</image>
                                        <BASE64VALUE>$firma</BASE64VALUE>
                                    </Visible>
                                </Signature>
                            </Application>
                        </AgileSignerConfig>"
                ]
            ]
        ];

        // <llx> Coordenada x de la esquina inferior izquierda de la imagen.
        // <lly> Coordenada y de la esquina inferior izquierda de la imagen.
        // <urx> Coordenada x de la esquina superior derecha de la imagen.
        // <ury> Coordenada y de la esquina superior derecha de la imagen.

        try {
            $response = Http::withHeaders(['otp' => $otp ])->post($url, $data);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            var_dump($e);exit();
        }
        catch (RequestException $e) {
            var_dump($e);exit();
        }
        catch (Exception $e){
            var_dump($e);exit();
        }
        $json = $response->json();

        //print_r($json);

        $data = base64_decode($json['files'][0]['content']);
        header('Content-Type: application/pdf');
        echo $data;
    }

    /*
    $pdfbase64 = 'JVBERi0xLjMNCiXi48/TDQoNCjEgMCBvYmoNCjw8DQovVHlwZSAvQ2F0YWxvZw0KL091dGxpbmVzIDIgMCBSDQovUGFnZXMgMyAwIFINCj4+DQplbmRvYmoNCg0KMiAwIG9iag0KPDwNCi9UeXBlIC9PdXRsaW5lcw0KL0NvdW50IDANCj4+DQplbmRvYmoNCg0KMyAwIG9iag0KPDwNCi9UeXBlIC9QYWdlcw0KL0NvdW50IDINCi9LaWRzIFsgNCAwIFIgNiAwIFIgXSANCj4+DQplbmRvYmoNCg0KNCAwIG9iag0KPDwNCi9UeXBlIC9QYWdlDQovUGFyZW50IDMgMCBSDQovUmVzb3VyY2VzIDw8DQovRm9udCA8PA0KL0YxIDkgMCBSIA0KPj4NCi9Qcm9jU2V0IDggMCBSDQo+Pg0KL01lZGlhQm94IFswIDAgNjEyLjAwMDAgNzkyLjAwMDBdDQovQ29udGVudHMgNSAwIFINCj4+DQplbmRvYmoNCg0KNSAwIG9iag0KPDwgL0xlbmd0aCAxMDc0ID4+DQpzdHJlYW0NCjIgSg0KQlQNCjAgMCAwIHJnDQovRjEgMDAyNyBUZg0KNTcuMzc1MCA3MjIuMjgwMCBUZA0KKCBBIFNpbXBsZSBQREYgRmlsZSApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDY4OC42MDgwIFRkDQooIFRoaXMgaXMgYSBzbWFsbCBkZW1vbnN0cmF0aW9uIC5wZGYgZmlsZSAtICkgVGoNCkVUDQpCVA0KL0YxIDAwMTAgVGYNCjY5LjI1MDAgNjY0LjcwNDAgVGQNCigganVzdCBmb3IgdXNlIGluIHRoZSBWaXJ0dWFsIE1lY2hhbmljcyB0dXRvcmlhbHMuIE1vcmUgdGV4dC4gQW5kIG1vcmUgKSBUag0KRVQNCkJUDQovRjEgMDAxMCBUZg0KNjkuMjUwMCA2NTIuNzUyMCBUZA0KKCB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDYyOC44NDgwIFRkDQooIEFuZCBtb3JlIHRleHQuIEFuZCBtb3JlIHRleHQuIEFuZCBtb3JlIHRleHQuIEFuZCBtb3JlIHRleHQuIEFuZCBtb3JlICkgVGoNCkVUDQpCVA0KL0YxIDAwMTAgVGYNCjY5LjI1MDAgNjE2Ljg5NjAgVGQNCiggdGV4dC4gQW5kIG1vcmUgdGV4dC4gQm9yaW5nLCB6enp6ei4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kICkgVGoNCkVUDQpCVA0KL0YxIDAwMTAgVGYNCjY5LjI1MDAgNjA0Ljk0NDAgVGQNCiggbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDU5Mi45OTIwIFRkDQooIEFuZCBtb3JlIHRleHQuIEFuZCBtb3JlIHRleHQuICkgVGoNCkVUDQpCVA0KL0YxIDAwMTAgVGYNCjY5LjI1MDAgNTY5LjA4ODAgVGQNCiggQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgKSBUag0KRVQNCkJUDQovRjEgMDAxMCBUZg0KNjkuMjUwMCA1NTcuMTM2MCBUZA0KKCB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBFdmVuIG1vcmUuIENvbnRpbnVlZCBvbiBwYWdlIDIgLi4uKSBUag0KRVQNCmVuZHN0cmVhbQ0KZW5kb2JqDQoNCjYgMCBvYmoNCjw8DQovVHlwZSAvUGFnZQ0KL1BhcmVudCAzIDAgUg0KL1Jlc291cmNlcyA8PA0KL0ZvbnQgPDwNCi9GMSA5IDAgUiANCj4+DQovUHJvY1NldCA4IDAgUg0KPj4NCi9NZWRpYUJveCBbMCAwIDYxMi4wMDAwIDc5Mi4wMDAwXQ0KL0NvbnRlbnRzIDcgMCBSDQo+Pg0KZW5kb2JqDQoNCjcgMCBvYmoNCjw8IC9MZW5ndGggNjc2ID4+DQpzdHJlYW0NCjIgSg0KQlQNCjAgMCAwIHJnDQovRjEgMDAyNyBUZg0KNTcuMzc1MCA3MjIuMjgwMCBUZA0KKCBTaW1wbGUgUERGIEZpbGUgMiApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDY4OC42MDgwIFRkDQooIC4uLmNvbnRpbnVlZCBmcm9tIHBhZ2UgMS4gWWV0IG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gKSBUag0KRVQNCkJUDQovRjEgMDAxMCBUZg0KNjkuMjUwMCA2NzYuNjU2MCBUZA0KKCBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDY2NC43MDQwIFRkDQooIHRleHQuIE9oLCBob3cgYm9yaW5nIHR5cGluZyB0aGlzIHN0dWZmLiBCdXQgbm90IGFzIGJvcmluZyBhcyB3YXRjaGluZyApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDY1Mi43NTIwIFRkDQooIHBhaW50IGRyeS4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gKSBUag0KRVQNCkJUDQovRjEgMDAxMCBUZg0KNjkuMjUwMCA2NDAuODAwMCBUZA0KKCBCb3JpbmcuICBNb3JlLCBhIGxpdHRsZSBtb3JlIHRleHQuIFRoZSBlbmQsIGFuZCBqdXN0IGFzIHdlbGwuICkgVGoNCkVUDQplbmRzdHJlYW0NCmVuZG9iag0KDQo4IDAgb2JqDQpbL1BERiAvVGV4dF0NCmVuZG9iag0KDQo5IDAgb2JqDQo8PA0KL1R5cGUgL0ZvbnQNCi9TdWJ0eXBlIC9UeXBlMQ0KL05hbWUgL0YxDQovQmFzZUZvbnQgL0hlbHZldGljYQ0KL0VuY29kaW5nIC9XaW5BbnNpRW5jb2RpbmcNCj4+DQplbmRvYmoNCg0KMTAgMCBvYmoNCjw8DQovQ3JlYXRvciAoUmF2ZSBcKGh0dHA6Ly93d3cubmV2cm9uYS5jb20vcmF2ZVwpKQ0KL1Byb2R1Y2VyIChOZXZyb25hIERlc2lnbnMpDQovQ3JlYXRpb25EYXRlIChEOjIwMDYwMzAxMDcyODI2KQ0KPj4NCmVuZG9iag0KDQp4cmVmDQowIDExDQowMDAwMDAwMDAwIDY1NTM1IGYNCjAwMDAwMDAwMTkgMDAwMDAgbg0KMDAwMDAwMDA5MyAwMDAwMCBuDQowMDAwMDAwMTQ3IDAwMDAwIG4NCjAwMDAwMDAyMjIgMDAwMDAgbg0KMDAwMDAwMDM5MCAwMDAwMCBuDQowMDAwMDAxNTIyIDAwMDAwIG4NCjAwMDAwMDE2OTAgMDAwMDAgbg0KMDAwMDAwMjQyMyAwMDAwMCBuDQowMDAwMDAyNDU2IDAwMDAwIG4NCjAwMDAwMDI1NzQgMDAwMDAgbg0KDQp0cmFpbGVyDQo8PA0KL1NpemUgMTENCi9Sb290IDEgMCBSDQovSW5mbyAxMCAwIFINCj4+DQoNCnN0YXJ0eHJlZg0KMjcxNA0KJSVFT0YNCg==';
    */

    //$firma = base64_encode($image);

    /*
    $firma = 'iVBORw0KGgoAAAANSUhEUgAAAK8AAACvCAYAAACLko51AAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsSAAALEgHS3X78AAADw0lEQVR42u3dW64bIRAFQCfK/rec/EaWI5GeBvrcW/XvMYyPEJjX6wUAAAAAAAAAAAAAAAAM96P5eb9vV+gfdaqWa+VZq99Xfde7n3VaW+Z+3q4JVAkvsYSXWMJLrF8HvqN7UPi3GwOQlfp01rk6AF0tQ+zvo+UllvASS3iJdaLP++5JP6irf7baj1yZIFidRKg+6/S7mVCGJVpeYgkvsYSXWMJLrBsDtgmeDLKqn9u9Qm3lWV+KlpdYwkss4SWW8BLruwzYqoOXlc+tzkjtXgH35Qdo77S8xBJeYgkvsYSXWDcGbDcGFtXZp85B1u4ZvJXPVcs5kpaXWMJLLOEl1ok+74Tzsarl7FwJdrpcT54fQctLLOEllvASS3iJFfOHdLMnBzbv3LrzWvwcLy0vwYSXWMJLLOEl1o3bgHav6OqsU+fheNUtRbsHeqdnDN0GBMJLLOEl1o0LVTr7iJ+c3v3Q2Yd/0h/s2qbfeePmVlpeYgkvsYSXWMJLrBMd8Z2TDbsHF6e3yDwp+8SB5NbfR8tLLOEllvASS3iJNeHcsCnlrc78dQ5Kbrybzm1NXZ9bouUllvASS3iJJbzESr8NaPfVprsPtFspx+5tOZ3v4egfAFpeYgkvsYSXWJMnKU4f7Dx1YmHCJIg+L3QSXmIJL7GEl1hp24Am/Dk/4T2sPH/CWQtWlcEnwkss4SWW8BJrygzb7nJMOIx592xgtY62AcFpwkss4SWW8BJr8m1A1e/bfZp5ym1A1TKslqvz+SVaXmIJL7GEl1gTVh69Xvv7rivf98np24BWdd380/l9x2l5iSW8xBJeYgkvsb7LJEVX2bslX21brY9VZSC8xBJeYgkvsdIOl544u7V7W1N1W87IlWCdtLzEEl5iCS+xhJdYk89tOL3V5Un5q/WpDv6mHjh4dIZVy0ss4SWW8BIr9g/q/3T6PK6qJ7/HhC1SR2l5iSW8xBJeYgkvsW5sA5pQpykHXFdXglXfw+6JEtuAYIXwEkt4iSW8xDqxDWjnQGh1gNM5ENo5W7db56zb9dVuWl5iCS+xhJdYN7a+P+kXne43np5YWK3zynemTBiVaXmJJbzEEl5iCS+x0s4qq6oOHE7fBvTkj/+u1WGrZbCqDKqEl1jCSyzhJdZ3GbBVnZ7JunFmws7B7FZaXmIJL7GEl1jCS6wbA7YpB1pXy7VzFqlzu0115m/CdqUlWl5iCS+xhJdYJ/q8E7ajvHuyXb1an87Dq1fKNeG92wYEnwgvsYSXWMILAAAAAAAAAAAAAAAAwC5/APY6riajMRrIAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTA5LTAxVDAxOjUxOjIyKzEwOjAw125LowAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wOS0wMVQwMTo1MToyMisxMDowMKYz8x8AAAAASUVORK5CYII=';
    */
}
