<?php

namespace App\Http\Controllers\Wellness;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wellness\Balance;

class WellnessController extends Controller
{
    //
    public function index()
    {
        return view('wellness.index');
    }

    public function balances()
    {
        $balances = Balance::all();
        return view('wellness.balance', compact('balances'));
    }

    public function ingresos()
    {
        $balances = Balance::where('tipo', 'ingresos')->get();
        return view('wellness.balance', compact('balances'));
    }

    public function gastos()
    {
        $balances = Balance::where('tipo', 'gastos')->get();
        return view('wellness.balance', compact('balances'));
    }


    /*todo lo que parta con dos corresponde al TXT */
    public function dosindex()
    {
        return view('wellness.dos.index');
    }

    public function dosimport(Request $request)
    {
        // Obtener el archivo que se cargó en el formulario
        $file = $request->file('file');

        // Obtener el mes y el año del formulario
        $mes = $request->input('month');
        $ano = $request->input('year');


        // Inicializar arreglos de ingresos y gastos
        $ingresos = array();
        $gastos = array();

        // Abrir el archivo y leer línea por línea
        $handle = fopen($file->getPathname(), "r");

        if ($handle) {
            while (($line = fgets($handle)) !== false) {

                // Encontrar la sección de ingresos
                if (strpos($line, "I N G R E S O S;INICIAL;PRESUPUESTO;AJUSTADO;EJECUTADO;PRESUPUEST.") !== false) {
                    // Leer líneas hasta encontrar la sección de gastos
                    while (($line = fgets($handle)) !== false && strpos($line, "G A S T O S ;INICIAL;PRESUPUESTO;AJUSTADO;EJECUTADO;PRESUPUEST") === false) {
                        // Agregar la línea a los ingresos
                        if (preg_match('/^(?!(;{3})).*?;.*?;.*?;.*?;.*?;.*?;.*?$/', $line) && substr_count($line, ';') == 7) {
                            $ingresos[] = $line;
                        }
                    }
                }

                // Encontrar la sección de gastos
                if (strpos($line, "G A S T O S ;INICIAL;PRESUPUESTO;AJUSTADO;EJECUTADO;PRESUPUEST") !== false) {
                    // Leer líneas hasta el final del archivo
                    while (($line = fgets($handle)) !== false) {
                        // Agregar la línea a los gastos
                        if (preg_match('/^(?!(;{3})).*?;.*?;.*?;.*?;.*?;.*?;.*?$/', $line) && substr_count($line, ';') == 7) {
                            $gastos[] = $line;
                        }
                    }
                }
            }

            // Cerrar el archivo
            fclose($handle);
        }

        // Recorrer los vectores de ingresos y gastos y actualizar o crear los registros correspondientes
        foreach ($ingresos as $line) {
            // Parsear la línea de ingresos
            $data = explode(';', $line);
            // Separar el valor del campo 'codigo' en tres partes
            $codigo_parts = explode('.', $data[1]);
            Balance::updateOrCreate([
                'ano' => $ano,
                'mes' => $mes,
                'tipo' => 'ingresos',
                'codigo' => $data[1],
                'titulo' => $codigo_parts[0],
                'item' => $codigo_parts[1],
                'asignacion' => $codigo_parts[2],
                'glosa' => $data[2],
                'inicial' => $data[3],
                'traspaso' => $data[4],
                'ajustado' => $data[5],
                'ejecutado' => $data[6],
                'saldo' => $data[7],
            ]);
        }

        foreach ($gastos as $line) {
            // Parsear la línea de gastos
            $data = explode(';', $line);
            // Separar el valor del campo 'codigo' en tres partes
            $codigo_parts = explode('.', $data[1]);
            Balance::updateOrCreate([
                'ano' => $ano,
                'mes' => $mes,
                'tipo' => 'gastos',
                'codigo' => $data[1],
                'titulo' => $codigo_parts[0],
                'item' => $codigo_parts[1],
                'asignacion' => $codigo_parts[2],
                'glosa' => $data[2],
                'inicial' => $data[3],
                'traspaso' => $data[4],
                'ajustado' => $data[5],
                'ejecutado' => $data[6],
                'saldo' => $data[7],
            ]);
        }

        // Agregar mensaje flash y redireccionar a la página anterior
        return redirect()->back()->with('success', 'Archivo cargado exitosamente.');
    }
}
