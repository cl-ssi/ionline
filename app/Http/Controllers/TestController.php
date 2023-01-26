<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Carbon\Carbon;

use App\Rrhh\OrganizationalUnit;
use App\Models\Establishment;
use App\Models\WebService\MercadoPublico;

class TestController extends Controller
{
    public function ous()
    {
        $estab = Establishment::find(38);
        //dump($estab->tree->toArray());

        $a = $estab->tree->toArray();

        $this->printAll($a);

    }

    function printAll($a) {
        echo str_repeat(" - ", $a['level']). $a['name'] . '<br>';
        if (!is_array($a)) {
            print_r($a);
            return;
        }
    
        foreach($a['childs'] as $k) {
            $this->printAll($k);
        }
    }

    public function getIp()
    {
        if ( !empty($_SERVER['HTTP_CLIENT_IP']) ) {
            // Check IP from internet.
            // 'ip' => request()->getClientIp(),
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
            // Check IP is passed from proxy.
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            // Get IP address from remote address.
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        logger()->info($ip);
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
        echo "Primer log";
    }

    // public function info()
    // {
    //     phpinfo();
    // }

    /**
    * No cargar 
    */
    public function loopLivewire()
    {
        $ous = OrganizationalUnit::all();

        foreach($ous as $ou)
        {
            // @livewire( parametro ou)
            $estab = Establishment::where('id', $ou->establishment_id)->first();
            // echo $estab->id."<br>";
            if($estab->type == 'HOSPITAL')
            {
                echo $estab->name."<br>";
            } 
            // fin de livewire
        }

    }

}
