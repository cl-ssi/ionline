<?php

namespace App\Livewire\Rem;

use App\Models\Rem\Seccion;
use Livewire\Component;

class SeccionGenerator extends Component
{
    public Seccion $seccion;
    public $tabla;
    public $tabla_final;
    public $cols;
    public $cods;
    public $columnas;
    public $cabecera;
    public $message;
    public $thead;
    public $nextRecord;

    /*
        'name',
        'serie',
        'nserie',
        'supergroups',
        'supergroups_inline',
        'discard_group',
        'thead',
        'cols',
        'cods',
        'totals',
        'totals_by_prestacion',
        'totals_by_group',
        'totals_first',
        'subtotals',
        'subtotals_first',
        'tfoot',
        'precision'
        */
    protected $rules = [
        'seccion.name' => 'required',
        'seccion.serie' => 'required',
        'seccion.nserie' => 'required',
        'seccion.supergroups' => 'required',
        'seccion.supergroups_inline' => 'required',
        'seccion.discard_group' => 'required',
        'seccion.thead' => 'required',
        'seccion.cols' => 'required',
        'seccion.cods' => 'required',
        'seccion.totals' => 'required',
        'seccion.totals_by_prestacion' => 'required',
        'seccion.totals_by_group' => 'required',
        'seccion.totals_first' => 'required',
        'seccion.subtotals' => 'required',
        'seccion.subtotals_first' => 'required',
        'seccion.tfoot' => 'required',
        'seccion.precision' => 'required',
    ];

    public function mount(Seccion $seccion)
    {
        $this->seccion = $seccion;
        $this->nextRecord = Seccion::where('id', '>', $this->seccion->id)->orderBy('id')->first()->id ?? 1;
    }

    public function generar()
    {
        // buscar en la variable tabla todas las coincidencias de la palabra de: width="n" y eliminarlas
        $this->tabla_final = preg_replace('/ width="(\d+)"/', '', $this->tabla);

        // eliminar todos los $nbsp; de la tabla
        $this->tabla_final = preg_replace('/&nbsp;/', '', $this->tabla_final);

        // eliminar todos los saltos de linea
        $this->tabla_final = preg_replace('/\n/', '', $this->tabla_final);

        // obtener todas las lineas que estén entre un <tr> y un </tr>
        preg_match_all('/<tr>(.*?)<\/tr>/', $this->tabla_final, $rows,PREG_PATTERN_ORDER);
        // dd($rows);


        // por cada $rows obtener todas las columnas que estén entre un <td xx> y un </td>
        $tabla_valores = [];
        foreach ($rows[1] as $row) {
            preg_match_all('/<td(.*?)>(.*?)<\/td>/', $row, $cols,PREG_PATTERN_ORDER);
            $tabla_valores[] = $cols[2];
        }

        // Obtenere todos los indices de $tabla que tengan un valor vacio al comienzo
        $cabecera_values = array_filter($tabla_valores, function($row) {
            return empty($row[0]);
        });

        foreach($cabecera_values as $key => $column) {
            $cabecera[$key] = $rows[1][$key];
        }

        $cuerpo_values = array_filter($tabla_valores, function($row) {
            return !empty($row[0]);
        });

        foreach($cuerpo_values as $key => $column) {
            $cuerpo[$key] = $rows[1][$key];
        }

        // Busca todos los string "COL(NN)" y los guarda en $cols
        $cols = [];
        foreach($cuerpo as $row) {
            preg_match_all('/<td>(COL(\d+))<\/td>/', $row, $matches);
            if(array_key_exists(1,$matches) ) {
                foreach($matches[1] as $col) {
                    if(!in_array(ucfirst(strtolower($col)), $cols)) {
                        $cols[] = ucfirst(strtolower($col));
                    }
                }
            }
        }
        // // Ordena cols por orden alfabetico
        //sort($cols);
        // poner en mayuscula la primera letra

        // // Guarda todos los $cols separados por coma
        $this->cols = implode(',', $cols);

        // obtene el primer elemento de cada fila de tabla_con_cods y lo guarda en $cods separados por ,
        $this->cods = implode(',', array_map(function($row) {
            return $row[0];
        }, $cuerpo_values));

        // app('debugbar')->info($cods);

        // Cuenta cuantos td hay en la variable $rows[0][0]
        $tds = substr_count($rows[0][0], '<td');

        // Suma todos los valores de "colspan" de los td de $rows[0][0]
        preg_match_all('/colspan="(\d+)"/', $rows[0][0], $colspans);
        $this->columnas = array_sum($colspans[1]) - count($colspans[1]) + $tds -1 ; // el -1 es por los cods

        $cabecera_final = [];
        foreach($cabecera as $key_rows => $row) {
            preg_match_all('/<td(.*?)>(.*?)<\/td>/', $row, $cols,PREG_PATTERN_ORDER);

            if($key_rows == 0) {
                $cabecera_final[$key_rows][0]['attributos'] = "colspan='".$this->columnas."' style='text-align: left;'";
                $cabecera_final[$key_rows][0]['valor'] = '<strong>'.$cols[2][1].'</strong>';
                $flag = true;
            }
            else {
                foreach($cols[2] as $key_cols => $col) {
                    if($key_cols != 0) {
                        $cabecera_final[$key_rows][$key_cols]['valor'] = !empty($cols[2][$key_cols]) ? '<strong>'.$cols[2][$key_cols].'</strong>' : '';
                        $cabecera_final[$key_rows][$key_cols]['attributos'] = trim($cols[1][$key_cols]) . ' class="centrado"';
                    }
                }
            }
        }

        $this->cabecera = $cabecera_final;

        $this->thead = '<thead>'."\n";
        foreach($cabecera_final as $row) {
            $this->thead .= "\t".'<tr>'."\n";
            foreach($row as $col) {
                $this->thead .= "\t\t".'<td '.$col['attributos'].'>'.$col['valor'].'</td>'."\n";
            }
            $this->thead .= "\t".'</tr>'."\n";
        }
        $this->thead .= '</thead>';

    }

    public function save() {
        $this->seccion->thead = $this->thead;
        $this->seccion->cols = $this->cols;
        $this->seccion->cods = $this->cods;
        $this->seccion->save();
    }

    public function render()
    {
        return view('livewire.rem.seccion-generator');
    }
}
