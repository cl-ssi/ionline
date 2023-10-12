<?php

namespace App\Models\WebService;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use SopaClient;

class Fonasa extends Model
{
    use HasFactory;

    public static function find($run) {
        $run = strtoupper(str_replace(['.', ','], '', trim($run)));
        list($id, $dv) = explode('-', $run);

        /** Calculo del DV para comprobar que el run sea válido */
        $s = 1;
        $m = 0;
        $rut = $id;
        while ($rut !== 0) {
            $s = ($s + ($rut % 10) * (9 - $m++ % 6)) % 11;
            $rut = (int)($rut / 10);
        }

        if($dv != chr($s ? $s + 47 : 75)) {
            return json_decode('{ "message" : "Run inválido" }');
        }
        else {
            $url = env('WSSSI_URL') . "/fonasa?run=$id&dv=$dv";
            $response = Http::get($url);
            return json_decode($response);
        }
    }

    // public static function find($rut) {
    //     $run = intval($rut);
    //     $s=1;
    //     for($m=0;$run!=0;$run/=10) $s=($s+$run%10*(9-$m++%6))%11;
    //     $dv = chr($s?$s+47:75); 

    //     if($rut AND $dv) {
    //         $wsdl = asset('ws/fonasa/CertificadorPrevisionalSoap.wsdl');
    //         $client = new \SoapClient($wsdl,array('trace'=>TRUE));
    //         $parameters = array(
    //             "query" => array(
    //                 "queryTO" => array(
    //                     "tipoEmisor"  => 3,
    //                     "tipoUsuario" => 2
    //                 ),
    //                 "entidad"           => env('FONASA_ENTIDAD'),
    //                 "claveEntidad"      => env('FONASA_CLAVE'),
    //                 "rutBeneficiario"   => $rut,
    //                 "dgvBeneficiario"   => $dv,
    //                 "canal"             => 3
    //             )
    //         );
    //         $result = $client->getCertificadoPrevisional($parameters);

    //         if ($result === false) {
    //             /* No se conecta con el WS */
    //             return array("error" => "No se pudo conectar a FONASA");
    //         }
    //         else {
    //             /* Si se conectó al WS */
    //             if($result->getCertificadoPrevisionalResult->replyTO->estado == 0) {
    //                 /* Si no hay error en los datos enviados */

    //                 $certificado          = $result->getCertificadoPrevisionalResult;
    //                 $beneficiario         = $certificado->beneficiarioTO;
    //                 $afiliado             = $certificado->afiliadoTO;
    //                 $user                 = new \stdClass();
    //                 $user->run            = $beneficiario->rutbenef;
    //                 $user->dv             = $beneficiario->dgvbenef;
    //                 $user->name           = $beneficiario->nombres;
    //                 $user->fathers_family = $beneficiario->apell1;
    //                 $user->mothers_family = $beneficiario->apell2;
    //                 $user->birthday       = $beneficiario->fechaNacimiento;
    //                 $user->gender         = $beneficiario->generoDes;
    //                 $user->region         = $beneficiario->desRegion;
    //                 $user->commune        = $beneficiario->desComuna;
    //                 $user->address        = $beneficiario->direccion;
    //                 $user->telephone      = $beneficiario->telefono;

    //                 if($afiliado->desEstado == 'ACTIVO') {
    //                     $user->tramo = $afiliado->tramo;
    //                 }
    //                 else {
    //                     $user->tramo = null;
    //                 }
    //                 //$user['estado']       = $afiliado->desEstado;
    //             }
    //             else {
    //                 /* Error */
    //                 return array("error" => $result->getCertificadoPrevisionalResult->replyTO->errorM);
    //             }
    //         }
    //     }
    //     return $user;
    // }
}
