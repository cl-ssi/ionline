<?php

namespace App\Livewire\Rem;

use App\Models\Rem\Seccion;
use Livewire\Component;

class SeccionIndex extends Component
{
    public function render()
    {
        // Obtener de secciones todas las columnas nserie unicas
        $columnas = Seccion::select('nserie')->distinct()->get()->toArray();

        // si se pasó el parametro nserie filtrar la query de secciones
        if (request()->has('nserie')) {
            $secciones = Seccion::where('nserie', request('nserie'))->get();
        }
        else
        {
            $secciones = Seccion::orderBy('nserie')->get();
        }

        return view('livewire.rem.seccion-index',
            [
                'secciones' => $secciones,
                'columnas' => $columnas
            ]);
    }
}
