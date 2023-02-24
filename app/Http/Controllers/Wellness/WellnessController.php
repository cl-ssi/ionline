<?php

namespace App\Http\Controllers\Wellness;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WellnessController extends Controller
{
    //
    public function index()
    {
        return view('wellness.index');
    }


    /*todo lo que parta con dos corresponde al TXT */
    public function dosindex()
    {
        return view('wellness.dos.index');
    }

    public function dosimport(Request $request)
{
    /*1 INGRESOS Y 2 EGRESOS
    aclarar dudas con Moreno
    */
    // Obtener el archivo que se cargó en el formulario
    $file = $request->file('file');

    // Inicializar arreglos de ingresos y gastos
    $ingresos = array();
    $gastos = array();
    
    // Establecer banderas para ingresos y gastos
    $en_ingresos = false;
    $en_gastos = false;

    // Leer el archivo de texto línea por línea
    $handle = fopen($file, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            // Buscar la línea de inicio de ingresos
            if (strpos($line, ';I N G R E S O S;') !== false) {
                $en_ingresos = true;
                continue;
            }
            
            // Agregar cada línea al arreglo de ingresos mientras se esté en la sección de ingresos
            if ($en_ingresos) {
                $ingresos[] = $line;
            }
            
            // Buscar la línea de inicio de gastos
            if (strpos($line, ';;GASTOS') !== false) {
                $en_ingresos = false;
                $en_gastos = true;
                continue;
            }
            
            // Agregar cada línea al arreglo de gastos mientras se esté en la sección de gastos
            if ($en_gastos) {
                $gastos[] = $line;
            }
        }
        fclose($handle);
    }
    dd($ingresos);
}

}
