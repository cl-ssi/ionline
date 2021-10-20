<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TestController extends Controller
{
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
        return $ip;

        //dd($events);
	    // return view('test.ip')
        //     ->withResources($resources)
        //     ->withEvents($events);
    }



    /*
    curl -X PATCH -H "Accept: application/vnd.github.v3+json" https://api.github.com/repos/cl-ssi/urgency/issues/22 -d '{"title":"Second Up"}'
    */
}
