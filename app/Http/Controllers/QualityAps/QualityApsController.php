<?php

namespace App\Http\Controllers\QualityAps;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class QualityApsController extends Controller
{
    public function index()
    {
        $relative_path = "../storage/app/quality_aps/";

        $it = new \RecursiveTreeIterator(
                new \RecursiveDirectoryIterator($relative_path, \RecursiveDirectoryIterator::SKIP_DOTS)
            );
        foreach($it as $path => $element) {
            $tree[] = pathinfo($element)+
                    array('path'=>urlencode(str_replace('../storage/app/','',$path)))+
                    array('depth'=>$it->getDepth())+
                    array('type'=>(is_file($path)==1)?'file':'dir');
        }
        return view('quality_aps.index', compact('tree'));
    }

    public function download($file)
    {
        //die(urldecode($file));
        $download_file = urldecode($file);
        $str = str_replace('\\', '/', $download_file);
        //dd($download_file); quality_aps\hola\archivo.txt
        //return Response::download(storage_path('app/'.$str));
        return response()->download(storage_path('app/'.$str));
    }
}
