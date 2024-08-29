<?php

namespace App\Livewire\Documents\DocDigital;

use Livewire\Component;
use App\Models\Documents\DocDigital;

class Creados extends Component
{
    public $documents;
    public $error;
    public $count;

    public function mount()
    {
        $docDigital = new DocDigital();

        $filtro = [
            // 'materia' => 'Carta',
            // 'runCreador' => 15287582, // No funciona
            // 'runDestinatario' => '15.287.582', // No funciona
            // 'nombreCreador' => 'Yeannett Nataly Valdivia Calisaya', // No funciona
            // 'tipoDocumento' => 5,
        ];

        $response = $docDigital->getDocumentosCreados($filtro);

        if($response) {
            $this->documents = $response['result'];
            $this->count     = $response['count'];
        }
        else {
            $this->documents = [];
            $this->error     = 'Error';
        }

        // app('debugbar')->info($this->documents);
    }

    public function render()
    {
        return view('livewire.documents.doc-digital.creados');
    }
}
