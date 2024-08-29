<?php

namespace App\Livewire\Indicators;

use Livewire\Component;

class PrestacionesLoader extends Component
{
    public $prestaciones;
    public $process;
    public $truncate_query;

    public function process() {
        $this->process = null;
        $prestaciones = $this->prestaciones;
        $prestaciones = explode("\n", $prestaciones);
        $prestaciones = array_map('trim', $prestaciones);
        $prestaciones = array_filter($prestaciones);

        // Eliminar el primer registro de $prestaciones
        unset($prestaciones[0]);
        
        foreach ($prestaciones as $key => $prestacion) {
            try {
                list($codigo_prestacion, $descripcion, $serie, $nserie, $year) = explode("\t", $prestacion);
            } catch (\Exception $e) {
                dd($prestacion);
            }

            $nserie = strtoupper($nserie);
            // eliminar los caracteres ' de la descripcion
            $descripcion = ucfirst(trim(str_replace("'", "", $descripcion)));
            // trim al codigo_prestacion
            $codigo_prestacion = trim($codigo_prestacion);
            $this->process[] = "INSERT INTO `{$year}prestaciones` (codigo_prestacion, descripcion, serie, Nserie) VALUES ('$codigo_prestacion','$descripcion','$serie','$nserie');";
        }

        $this->truncate_query = "DELETE FROM `{$year}prestaciones` WHERE serie = '$serie';";
    }

    public function render()
    {
        return view('livewire.indicators.prestaciones-loader');
    }
}
