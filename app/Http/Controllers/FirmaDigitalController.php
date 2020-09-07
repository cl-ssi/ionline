<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use SimpleSoftwareIO\QrCode\Generator;


class FirmaDigitalController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return pdf
     */
    public function signPdf()
    {
        // echo '<pre>';
        //header("Content-Type: image/png; charset=UTF-8");
        $im = @imagecreate(250, 100) or die("Cannot Initialize new GD image stream");

        $background_color = imagecolorallocate($im, 0, 0, 255);
        $white = imagecolorallocate($im, 255, 255, 255);
        //
        imagefilledrectangle($im,1,1,248, 98,$white);

        $text_color = imagecolorallocate($im, 0, 0, 0);
        imagestring($im, 3, 5, 5,  "Alvaro Torres Fuchslocher", $text_color);

        $marginTop = 10;
        $xAxis = 5;
        $yPading = 11;
        $fontSize = 1;

        imagestring($im, $fontSize, $xAxis, $yPading * 1 + $marginTop, 'Firmado digitalmente por:', $text_color);
        imagestring($im, $fontSize, $xAxis, $yPading * 2 + $marginTop, 'cn = Alvaro Raymundo Edgardo Torres Fuchslocher', $text_color);
        imagestring($im, $fontSize, $xAxis, $yPading * 3 + $marginTop, 'email = alvaro.torres@redsalud.gob.cl', $text_color);
        imagestring($im, $fontSize, $xAxis, $yPading * 4 + $marginTop, 'serialNumber = 15287582-7', $text_color);
        imagestring($im, $fontSize, $xAxis, $yPading * 5 + $marginTop, 'title = Profesional Sidra', $text_color);
        imagestring($im, $fontSize, $xAxis, $yPading * 6 + $marginTop, 'o = Ministerio de Salud', $text_color);
        imagestring($im, $fontSize, $xAxis, $yPading * 7 + $marginTop, 'cn = Autoridad Certificadora del Estado de Chile', $text_color);

        /*
        email=alvaro.torres@redsalud.gob.cl
        cn=Álvaro Raymundo Edgardo Torres Fuchslocher
        serialNumber=15287582-7
        title=Profesional Sidra
        o=Ministerio de Salud
        cn=Autoridad Certificadora del Estado de Chile
        */

        ob_start();
        imagepng($im);
        $firma = base64_encode(ob_get_clean());
        imagedestroy($im);
        //die();


        $testing = true;

        if($testing) {
            $url = 'https://api.firma.test.digital.gob.cl/firma/v2/files/tickets';
            $api_token = 'sandbox';
            $secret = 'abcd';

            $run = 22222222;  // $run = 22222222;
            $otp = 269734;

            $purpose = 'Desatendido'; // $purpose = 'Propósito General';
            $entity = 'Subsecretaría General de La Presidencia';
        }
        else {
            $url = 'https://api.firma.digital.gob.cl/firma/v2/files/tickets';
            $api_token = env('FIRMA_API_TOKEN');
            $secret = env('FIRMA_SECRET');

            $run = 15287582;
            $otp = 269734;

            $purpose = 'Propósito General';
            $entity = 'Servicio de Salud Iquique';
        }

        $payload = [
            "purpose" => $purpose,
            "entity" => $entity,
            "expiration" => now()->add(30,'minutes')->format('Y-m-d\TH:i:s'),
            "run" => $run
        ];

        $jwt = JWT::encode($payload, $secret);

        //die($jwt);

        $pdfbase64 = 'JVBERi0xLjMNCiXi48/TDQoNCjEgMCBvYmoNCjw8DQovVHlwZSAvQ2F0YWxvZw0KL091dGxpbmVzIDIgMCBSDQovUGFnZXMgMyAwIFINCj4+DQplbmRvYmoNCg0KMiAwIG9iag0KPDwNCi9UeXBlIC9PdXRsaW5lcw0KL0NvdW50IDANCj4+DQplbmRvYmoNCg0KMyAwIG9iag0KPDwNCi9UeXBlIC9QYWdlcw0KL0NvdW50IDINCi9LaWRzIFsgNCAwIFIgNiAwIFIgXSANCj4+DQplbmRvYmoNCg0KNCAwIG9iag0KPDwNCi9UeXBlIC9QYWdlDQovUGFyZW50IDMgMCBSDQovUmVzb3VyY2VzIDw8DQovRm9udCA8PA0KL0YxIDkgMCBSIA0KPj4NCi9Qcm9jU2V0IDggMCBSDQo+Pg0KL01lZGlhQm94IFswIDAgNjEyLjAwMDAgNzkyLjAwMDBdDQovQ29udGVudHMgNSAwIFINCj4+DQplbmRvYmoNCg0KNSAwIG9iag0KPDwgL0xlbmd0aCAxMDc0ID4+DQpzdHJlYW0NCjIgSg0KQlQNCjAgMCAwIHJnDQovRjEgMDAyNyBUZg0KNTcuMzc1MCA3MjIuMjgwMCBUZA0KKCBBIFNpbXBsZSBQREYgRmlsZSApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDY4OC42MDgwIFRkDQooIFRoaXMgaXMgYSBzbWFsbCBkZW1vbnN0cmF0aW9uIC5wZGYgZmlsZSAtICkgVGoNCkVUDQpCVA0KL0YxIDAwMTAgVGYNCjY5LjI1MDAgNjY0LjcwNDAgVGQNCigganVzdCBmb3IgdXNlIGluIHRoZSBWaXJ0dWFsIE1lY2hhbmljcyB0dXRvcmlhbHMuIE1vcmUgdGV4dC4gQW5kIG1vcmUgKSBUag0KRVQNCkJUDQovRjEgMDAxMCBUZg0KNjkuMjUwMCA2NTIuNzUyMCBUZA0KKCB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDYyOC44NDgwIFRkDQooIEFuZCBtb3JlIHRleHQuIEFuZCBtb3JlIHRleHQuIEFuZCBtb3JlIHRleHQuIEFuZCBtb3JlIHRleHQuIEFuZCBtb3JlICkgVGoNCkVUDQpCVA0KL0YxIDAwMTAgVGYNCjY5LjI1MDAgNjE2Ljg5NjAgVGQNCiggdGV4dC4gQW5kIG1vcmUgdGV4dC4gQm9yaW5nLCB6enp6ei4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kICkgVGoNCkVUDQpCVA0KL0YxIDAwMTAgVGYNCjY5LjI1MDAgNjA0Ljk0NDAgVGQNCiggbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDU5Mi45OTIwIFRkDQooIEFuZCBtb3JlIHRleHQuIEFuZCBtb3JlIHRleHQuICkgVGoNCkVUDQpCVA0KL0YxIDAwMTAgVGYNCjY5LjI1MDAgNTY5LjA4ODAgVGQNCiggQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgKSBUag0KRVQNCkJUDQovRjEgMDAxMCBUZg0KNjkuMjUwMCA1NTcuMTM2MCBUZA0KKCB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBFdmVuIG1vcmUuIENvbnRpbnVlZCBvbiBwYWdlIDIgLi4uKSBUag0KRVQNCmVuZHN0cmVhbQ0KZW5kb2JqDQoNCjYgMCBvYmoNCjw8DQovVHlwZSAvUGFnZQ0KL1BhcmVudCAzIDAgUg0KL1Jlc291cmNlcyA8PA0KL0ZvbnQgPDwNCi9GMSA5IDAgUiANCj4+DQovUHJvY1NldCA4IDAgUg0KPj4NCi9NZWRpYUJveCBbMCAwIDYxMi4wMDAwIDc5Mi4wMDAwXQ0KL0NvbnRlbnRzIDcgMCBSDQo+Pg0KZW5kb2JqDQoNCjcgMCBvYmoNCjw8IC9MZW5ndGggNjc2ID4+DQpzdHJlYW0NCjIgSg0KQlQNCjAgMCAwIHJnDQovRjEgMDAyNyBUZg0KNTcuMzc1MCA3MjIuMjgwMCBUZA0KKCBTaW1wbGUgUERGIEZpbGUgMiApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDY4OC42MDgwIFRkDQooIC4uLmNvbnRpbnVlZCBmcm9tIHBhZ2UgMS4gWWV0IG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gKSBUag0KRVQNCkJUDQovRjEgMDAxMCBUZg0KNjkuMjUwMCA2NzYuNjU2MCBUZA0KKCBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDY2NC43MDQwIFRkDQooIHRleHQuIE9oLCBob3cgYm9yaW5nIHR5cGluZyB0aGlzIHN0dWZmLiBCdXQgbm90IGFzIGJvcmluZyBhcyB3YXRjaGluZyApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDY1Mi43NTIwIFRkDQooIHBhaW50IGRyeS4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gKSBUag0KRVQNCkJUDQovRjEgMDAxMCBUZg0KNjkuMjUwMCA2NDAuODAwMCBUZA0KKCBCb3JpbmcuICBNb3JlLCBhIGxpdHRsZSBtb3JlIHRleHQuIFRoZSBlbmQsIGFuZCBqdXN0IGFzIHdlbGwuICkgVGoNCkVUDQplbmRzdHJlYW0NCmVuZG9iag0KDQo4IDAgb2JqDQpbL1BERiAvVGV4dF0NCmVuZG9iag0KDQo5IDAgb2JqDQo8PA0KL1R5cGUgL0ZvbnQNCi9TdWJ0eXBlIC9UeXBlMQ0KL05hbWUgL0YxDQovQmFzZUZvbnQgL0hlbHZldGljYQ0KL0VuY29kaW5nIC9XaW5BbnNpRW5jb2RpbmcNCj4+DQplbmRvYmoNCg0KMTAgMCBvYmoNCjw8DQovQ3JlYXRvciAoUmF2ZSBcKGh0dHA6Ly93d3cubmV2cm9uYS5jb20vcmF2ZVwpKQ0KL1Byb2R1Y2VyIChOZXZyb25hIERlc2lnbnMpDQovQ3JlYXRpb25EYXRlIChEOjIwMDYwMzAxMDcyODI2KQ0KPj4NCmVuZG9iag0KDQp4cmVmDQowIDExDQowMDAwMDAwMDAwIDY1NTM1IGYNCjAwMDAwMDAwMTkgMDAwMDAgbg0KMDAwMDAwMDA5MyAwMDAwMCBuDQowMDAwMDAwMTQ3IDAwMDAwIG4NCjAwMDAwMDAyMjIgMDAwMDAgbg0KMDAwMDAwMDM5MCAwMDAwMCBuDQowMDAwMDAxNTIyIDAwMDAwIG4NCjAwMDAwMDE2OTAgMDAwMDAgbg0KMDAwMDAwMjQyMyAwMDAwMCBuDQowMDAwMDAyNDU2IDAwMDAwIG4NCjAwMDAwMDI1NzQgMDAwMDAgbg0KDQp0cmFpbGVyDQo8PA0KL1NpemUgMTENCi9Sb290IDEgMCBSDQovSW5mbyAxMCAwIFINCj4+DQoNCnN0YXJ0eHJlZg0KMjcxNA0KJSVFT0YNCg==';

        /*
        $firma = 'iVBORw0KGgoAAAANSUhEUgAAAK8AAACvCAYAAACLko51AAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsSAAALEgHS3X78AAADw0lEQVR42u3dW64bIRAFQCfK/rec/EaWI5GeBvrcW/XvMYyPEJjX6wUAAAAAAAAAAAAAAAAM96P5eb9vV+gfdaqWa+VZq99Xfde7n3VaW+Z+3q4JVAkvsYSXWMJLrF8HvqN7UPi3GwOQlfp01rk6AF0tQ+zvo+UllvASS3iJdaLP++5JP6irf7baj1yZIFidRKg+6/S7mVCGJVpeYgkvsYSXWMJLrBsDtgmeDLKqn9u9Qm3lWV+KlpdYwkss4SWW8BLruwzYqoOXlc+tzkjtXgH35Qdo77S8xBJeYgkvsYSXWDcGbDcGFtXZp85B1u4ZvJXPVcs5kpaXWMJLLOEl1ok+74Tzsarl7FwJdrpcT54fQctLLOEllvASS3iJFfOHdLMnBzbv3LrzWvwcLy0vwYSXWMJLLOEl1o3bgHav6OqsU+fheNUtRbsHeqdnDN0GBMJLLOEl1o0LVTr7iJ+c3v3Q2Yd/0h/s2qbfeePmVlpeYgkvsYSXWMJLrBMd8Z2TDbsHF6e3yDwp+8SB5NbfR8tLLOEllvASS3iJNeHcsCnlrc78dQ5Kbrybzm1NXZ9bouUllvASS3iJJbzESr8NaPfVprsPtFspx+5tOZ3v4egfAFpeYgkvsYSXWJMnKU4f7Dx1YmHCJIg+L3QSXmIJL7GEl1hp24Am/Dk/4T2sPH/CWQtWlcEnwkss4SWW8BJrygzb7nJMOIx592xgtY62AcFpwkss4SWW8BJr8m1A1e/bfZp5ym1A1TKslqvz+SVaXmIJL7GEl1gTVh69Xvv7rivf98np24BWdd380/l9x2l5iSW8xBJeYgkvsb7LJEVX2bslX21brY9VZSC8xBJeYgkvsdIOl544u7V7W1N1W87IlWCdtLzEEl5iCS+xhJdYk89tOL3V5Un5q/WpDv6mHjh4dIZVy0ss4SWW8BIr9g/q/3T6PK6qJ7/HhC1SR2l5iSW8xBJeYgkvsW5sA5pQpykHXFdXglXfw+6JEtuAYIXwEkt4iSW8xDqxDWjnQGh1gNM5ENo5W7db56zb9dVuWl5iCS+xhJdYN7a+P+kXne43np5YWK3zynemTBiVaXmJJbzEEl5iCS+x0s4qq6oOHE7fBvTkj/+u1WGrZbCqDKqEl1jCSyzhJdZ3GbBVnZ7JunFmws7B7FZaXmIJL7GEl1jCS6wbA7YpB1pXy7VzFqlzu0115m/CdqUlWl5iCS+xhJdYJ/q8E7ajvHuyXb1an87Dq1fKNeG92wYEnwgvsYSXWMILAAAAAAAAAAAAAAAAwC5/APY6riajMRrIAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTA5LTAxVDAxOjUxOjIyKzEwOjAw125LowAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wOS0wMVQwMTo1MToyMisxMDowMKYz8x8AAAAASUVORK5CYII=';
        */

        //$image = file_get_contents('https://chart.googleapis.com/chart?chs=50x50&cht=qr&chl=alvaro.torres%40redsalud.gob.cl&choe=UTF-8&chld=L|0');

        //$firma = base64_encode($image);

        $data = [
            'api_token_key' => $api_token,
            'token' => $jwt,
            'files' => [
                [
                    'content-type' => 'application/pdf',
                    'content' => $pdfbase64,
                    'description' => 'str',
                    'checksum' => '4b41a3475132bd861b30a878e30aa56a',
                    'layout' => "
                        <AgileSignerConfig>
                            <Application id=\"THIS-CONFIG\">
                                <pdfPassword/>
                                <Signature>
                                    <Visible active=\"true\" layer2=\"false\" label=\"true\" pos=\"1\">
                                        <llx>400</llx>
                                        <lly>0</lly>
                                        <urx>600</urx>
                                        <ury>100</ury>
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


        $response = Http::withHeaders(['otp' => $otp ])->post($url, $data);

        $json = $response->json();

        // print_r($json);

        $data = base64_decode($json['files'][0]['content']);
        header('Content-Type: application/pdf');
        echo $data;
    }

}
