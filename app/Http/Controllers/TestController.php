<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use App\Rrhh\OrganizationalUnit;
use Illuminate\Support\Facades\DB;
use App\Models\WebService\MercadoPublico;
use Carbon\Carbon;

class TestController extends Controller
{
    public function ous()
    {
        //$ous = OrganizationalUnit::all();
        $ous = OrganizationalUnit::pluck('id','name');
        // $ous = OrganizationalUnit::select(DB::raw('id','name'))->get();
        // debug($ous);
        return true;
    }

    public function getIp()
    {

        if ( !empty($_SERVER['HTTP_CLIENT_IP']) ) {
            // Check IP from internet.
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
            // Check IP is passed from proxy.
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            // Get IP address from remote address.
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        //Storage::disk('local')->prepend('log_ips.txt', $ip);

        return $ip;

    }

    /*
    curl -X PATCH -H "Accept: application/vnd.github.v3+json" https://api.github.com/repos/cl-ssi/urgency/issues/22 -d '{"title":"Second Up"}'
    */

    public function getMercadoPublicoTender($date){
        $tenders = MercadoPublico::getTender(Carbon::parse($date));
        dd($tenders);
    }
}
