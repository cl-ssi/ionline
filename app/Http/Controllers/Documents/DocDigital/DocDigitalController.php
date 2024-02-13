<?php

namespace App\Http\Controllers\Documents\DocDigital;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Documents\DocDigital;

class DocDigitalController extends Controller
{
    public function archivo($documento_id, $id)
    {
        $docDigital = new DocDigital();
        $response = $docDigital->getDocumentosArchivo($documento_id, $id);

        // Devolver el contenido del PDF como una respuesta para forzar la carga en el navegador
        return response(base64_decode($response->result), 200, [
            'Content-Type' => 'application/pdf',
        ]);
    } 
}
