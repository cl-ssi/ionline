<?php

namespace App\Livewire\Drugs\Protocols;

use App\Models\Drugs\Protocol;
use Livewire\Component;

class Sign extends Component
{
    public Protocol $protocol;

    public function sendToSign()
    {
        $this->protocol->approval()->create([
            /* Nombre del Módulo que está enviando la solicitud de aprobación */
            "module" => "Drogas",

            /* Ícono del módulo para que aparezca en la bandeja de aprobación */
            "module_icon" => "fas fa-cannabis",

            /* Asunto de la aprobación */
            "subject" => "Protocolo de análisis: " . $this->protocol->id,

            /* Nombre de la ruta que se mostrará al hacer click en el documento */
            "document_route_name" => "drugs.protocols.show",

            /* (Opcional) Parametros que reciba esa ruta */
            "document_route_params" => json_encode([
                "protocol" => $this->protocol->id,
            ]),

            /** Creador del protocolo es quien firma */
            "sent_to_user_id" => $this->protocol->user_id,

            "digital_signature" => true,

            "position" => "center",

            "filename" => "ionline/drugs/protocols/" . $this->protocol->id .".pdf",
        ]);

        $this->protocol->refresh();
    }

    public function render()
    {
        return view('livewire.drugs.protocols.sign');
    }
}
