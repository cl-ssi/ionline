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
        $this->establishment = 125;
    }

    private function agregarPadresFaltantes()
    {
        $indexPorCodigo = $this->unidades;

        foreach ( $this->unidades as $codigo => $descripcion ) {
            $codigoPadre = $this->calcularCodigoPadre($codigo);
            if ( $codigoPadre && !isset($indexPorCodigo[$codigoPadre]) ) {
                $this->unidades[$codigoPadre] = '(NO EXISTE UNIDAD SUPERIOR)';
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
