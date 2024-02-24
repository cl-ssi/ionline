<?php

namespace App\Http\Livewire\Rem;

use App\Models\Rem\Seccion;
use Livewire\Component;

class SeccionIndex extends Component
{
    public function render()
    {
        $secciones = Seccion::all();
        return view('livewire.rem.seccion-index',
            [
                'secciones' => $secciones
            ]);
    }
}
