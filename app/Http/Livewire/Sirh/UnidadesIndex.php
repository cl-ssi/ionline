<?php

namespace App\Http\Livewire\Sirh;

use App\Models\Sirh\RsalUnidad;
use Livewire\Component;

class UnidadesIndex extends Component
{
    public $unidades;
    public $arbol;
    public $establishment;

    public function mount()
    {

    }

    private function agregarPadresFaltantes()
    {
        $indexPorCodigo = $this->unidades;

        foreach ( $this->unidades as $codigo => $descripcion ) {
            $codigoPadre = $this->calcularCodigoPadre($codigo);
            if ( $codigoPadre && !isset($indexPorCodigo[$codigoPadre]) ) {
                $this->unidades[$codigoPadre] = 'PADRE NO EXISTE';
            }
        }
    }

    private function calcularCodigoPadre($cod)
    {
        $cod = strval($cod);
        if ( strlen($cod) != 7 )
            return null;
        if ( $cod[6] != '0' )
            return substr($cod, 0, 6) . '0';
        if ( $cod[5] != '0' )
            return substr($cod, 0, 5) . '00';
        if ( $cod[4] != '0' )
            return substr($cod, 0, 4) . '000';
        if ( $cod[3] != '0' )
            return substr($cod, 0, 3) . '0000';
        return null;
    }

    private function construirArbol()
    {
        $items = [];
        foreach ( $this->unidades as $codigo => $descripcion ) {
            $items[$codigo] = [
                'codigo'      => $codigo,
                'descripcion' => $descripcion,
                'padre'       => $this->calcularCodigoPadre($codigo),
                'children'    => []
            ];
        }

        foreach ( $items as $codigo => &$item ) {
            if ( $item['padre'] && isset($items[$item['padre']]) ) {
                $items[$item['padre']]['children'][] = &$item;
            }
        }
        unset($item); // Break reference link

        // Filter to keep only root nodes
        $this->arbol = array_filter($items, function ($item) {
            return is_null($item['padre']) || !isset ($this->unidades[$item['padre']]);
        });
    }

    public function render()
    {
        $this->unidades = RsalUnidad::where('unid_codigo', 'like', $this->establishment . '%')
            ->whereRaw('LENGTH(unid_codigo) = 7')
            ->pluck('unid_descripcion', 'unid_codigo')
            ->toArray();
        $this->agregarPadresFaltantes();
        $this->construirArbol();
        return view('livewire.sirh.unidades-index', ['arbol' => $this->arbol]);
    }
}


// class UnidadesIndex extends Component
// {
//     public $unidades;
//     public $establishment;

//     public function search() {
//         $this->unidades = RsalUnidad::when($this->establishment != null, function ($query) {
//             return $query->where('unid_codigo', 'like', $this->establishment.'%')
//                 ->whereRaw('LENGTH(unid_codigo) = 7');
//         })->pluck('unid_descripcion', 'unid_codigo')->toArray();

//         // $this->agregarPadresFaltantes();
//     }

//     public function render()
//     {
//         $this->search();

//         if($this->establishment) {
//             $this->agregarPadresFaltantes();
//             $this->agregarPadresFaltantes();
//             $this->agregarPadresFaltantes();
//             $this->construirArbol();
//         }

//         return view('livewire.sirh.unidades-index');
//     }

//     function agregarPadresFaltantes() {
//         $indexPorCodigo = [];
//         foreach ($this->unidades as $codigo => $descripcion) {
//             $indexPorCodigo[$codigo] = $descripcion;
//         }

//         foreach ($this->unidades as $codigo => $descripcion) {
//             $cod = strval($codigo);
//             $codigoPadre = null;

//             // Generar el código padre basado en la estructura del código
//             if ($cod[6] != '0') {
//                 $codigoPadre = substr($cod, 0, 6) . '0';
//             } elseif ($cod[5] != '0') {
//                 $codigoPadre = substr($cod, 0, 5) . '00';
//             } elseif ($cod[4] != '0') {
//                 $codigoPadre = substr($cod, 0, 4) . '000';
//             } elseif ($cod[3] != '0') {
//                 $codigoPadre = substr($cod, 0, 3) . '0000';
//             }

//             // Verificar si el código padre existe en el índice y si no, agregarlo
//             if ($codigoPadre && !isset($indexPorCodigo[$codigoPadre]) && $codigoPadre != $cod) {
//                 // Agregar padre faltante al índice y al arreglo
//                 $this->unidades[$codigoPadre] = 'PADRE NO EXISTE';
//                 $indexPorCodigo[$codigoPadre] = 'PADRE NO EXISTE';
//             }
//         }

//     }

//     private function construirArbol() {
//         $arbol = [];
//         $itemsPorCodigo = [];

//         // Inicializar cada unidad en el arreglo del árbol
//         foreach ($this->unidades as $codigo => $nombre) {
//             $itemsPorCodigo[$codigo] = [
//                 'name' => $nombre,
//                 'children' => []
//             ];
//         }

//         // Asignar cada unidad a su padre
//         foreach ($this->unidades as $codigo => $nombre) {
//             $codigoPadre = $this->calcularCodigoPadre($codigo);

//             if ($codigoPadre && isset($itemsPorCodigo[$codigoPadre])) {
//                 $itemsPorCodigo[$codigoPadre]['children'][$codigo] = &$itemsPorCodigo[$codigo];
//             } else {
//                 // Si no tiene padre, es una raíz del árbol
//                 $arbol[$codigo] = &$itemsPorCodigo[$codigo];
//             }
//         }

//         $this->imprimirArbol($arbol);
//     }

//     private function calcularCodigoPadre($cod) {
//         if ($cod[6] != '0') return substr($cod, 0, 6) . '0';
//         if ($cod[5] != '0') return substr($cod, 0, 5) . '00';
//         if ($cod[4] != '0') return substr($cod, 0, 4) . '000';
//         if ($cod[3] != '0') return substr($cod, 0, 3) . '0000';
//         return null;
//     }

//     private function imprimirArbol($nodos, $nivel = 0) {
//         if (empty($nodos)) return;

//         uasort($nodos, function($a, $b) {
//             return strcmp($a['name'], $b['name']);
//         });

//         foreach ($nodos as $nodo) {
//             echo str_repeat(" ", $nivel * 4) . $nodo['name'] . "\n";
//             $this->imprimirArbol($nodo['children'], $nivel + 1);
//         }
//     }
// }
