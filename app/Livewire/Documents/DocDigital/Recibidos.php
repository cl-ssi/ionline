<?php

namespace App\Livewire\Documents\DocDigital;

use Livewire\Component;
use App\Models\Documents\DocDigital;

class Recibidos extends Component
{
    public $documents;
    public $error;
    public $count;

    public function mount()
    {
        $docDigital = new DocDigital();

        $filtro = [
            // 'materia' => 'Carta',
            // 'runDestinatario' => '15.287.582', // No funciona
            // 'runCreador' => 17094619, // No funciona
            // 'nombreCreador' => 'Yeannett Nataly Valdivia Calisaya', // No funciona
            // 'tipoDocumento' => 5,
        ];

        $response = $docDigital->getDocumentosRecibidos($filtro);

        if($response) {
            $this->documents = $response['result'];
            $this->count     = $response['count'];
        }
        else {
            $this->documents = [];
            $this->error     = 'Error';
        }

        // dd(session('token'));
    }

    public function render()
    {
        return view('livewire.documents.doc-digital.recibidos');
    }

    // [0] => stdClass Object
    // (
    //     [destinatarios] => stdClass Object
    //         (
    //             [reservado] => 
    //             [usuarios_destinatarios] => Array
    //                 (
    //                     [0] => stdClass Object
    //                         (
    //                             [usuario_id] => 7045
    //                             [usuario_run] => 15287582-7
    //                             [usuario_nombre] => Álvaro Raymundo Edgardo Torres Fuchslocher
    //                             [usuario_email] => alvaro.torres@redsalud.gob.cl
    //                             [usuario_cargo] => Ingeniero de Sistemas
    //                             [entidad_id] => 121
    //                             [entidad_nombre] => Servicio de Salud Tarapacá
    //                             [organismo_id] => 
    //                             [organismo_nombre] => 
    //                         )
    //                 )
    //             [con_copia] => stdClass Object
    //                 (
    //                     [entidades] => Array
    //                         (
    //                             [0] => stdClass Object
    //                                 (
    //                                     [organismo] => 
    //                                     [estado] => Acuse recibido
    //                                     [motivo] => 
    //                                     [entidad_id] => 121
    //                                     [entidad_nombre] => Servicio de Salud Tarapacá
    //                                     [entidad_padre_id] => 
    //                                 )
    //                         )
    //                     [correos] => 
    //                 )
    //         )
    //     [solicitud_id] => 2291
    //     [documento_principal] => stdClass Object
    //         (
    //             [id] => b9e5d539-34dd-4de5-a940-ed035eb56f38
    //             [materia] => dsafasdf
    //             [descripcion] => 
    //             [contenido] => 
    //             [tipo] => Memorandos
    //             [fechaCreacion] => 27-09-2023 16:05:57
    //             [foliado] => 1
    //             [folio] => 123456
    //             [fechaFolio] => 27-09-2023 16:31:11
    //             [documento_id] => 2291
    //             [nombre_archivo] => download_1.pdf
    //             [url_documento] => https://api-demodoc.digital.gob.cl/api/documentos/2291/archivo?archivo_id=b9e5d539-34dd-4de5-a940-ed035eb56f38
    //             [tipo_id] => 3
    //         )
    //     [documentos_anexos] => Array
    //         (
    //         )
    //     [info_creador] => stdClass Object
    //         (
    //             [usuario_id] => 7045
    //             [usuario_run] => 15287582-7
    //             [usuario_nombre] => Álvaro Raymundo Edgardo Torres Fuchslocher
    //             [usuario_email] => 
    //             [usuario_cargo] => Ingeniero de Sistemas
    //             [entidad_id] => 121
    //             [entidad_nombre] => Servicio de Salud Tarapacá
    //             [organismo_id] => 
    //             [organismo_nombre] => 
    //         )
    //     [info_visaciones] => stdClass Object
    //         (
    //             [visadores] => 
    //             [tipo_id] => 
    //         )
    //     [info_firmas] => stdClass Object
    //         (
    //             [layoutId] => 
    //             [firmantes] => Array
    //                 (
    //                     [0] => Array
    //                         (
    //                             [0] => stdClass Object
    //                                 (
    //                                     [usuario_id] => 7045
    //                                     [usuario_run] => 15287582-7
    //                                     [usuario_nombre] => Álvaro Raymundo Edgardo Torres Fuchslocher
    //                                     [usuario_email] => alvaro.torres@redsalud.gob.cl
    //                                     [usuario_cargo] => Ingeniero de Sistemas
    //                                     [entidad_id] => 121
    //                                     [entidad_nombre] => Servicio de Salud Tarapacá
    //                                     [organismo_id] => 
    //                                     [organismo_nombre] => 
    //                                 )
    //                         )
    //                 )
    //         )
    //     [entidad_creadora_id] => 121
    //     [resumen_entidades_destinatarias] => Array
    //         (
    //             [0] => 121
    //         )
    // )
}
