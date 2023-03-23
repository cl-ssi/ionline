<?php

namespace App\Http\Controllers\Welfare;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Welfare\Balance;
use App\Exports\BalanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class WelfareController extends Controller
{
    //
    public function index()
    {
        return view('welfare.index');
    }



    public function balances(Request $request)
    {
        $mes = $request->input('month');
        $ano = $request->input('year');
        $type = $request->input('type');

        // Obtener los balances correspondientes al mes y año seleccionado
        $balances = Balance::where('mes', $mes)
            ->where('ano', $ano);        

        if ($type == 'ingresos') {
            $balances = $balances->where('tipo', 'ingresos');
        } elseif ($type == 'gastos') {
            $balances = $balances->where('tipo', 'gastos');
        }

        $balances = $balances->get();

        // Obtener el último día del mes
        $ultimo_dia_del_mes = Carbon::createFromDate($ano, $mes)->endOfMonth()->format('Y-m-d');

        $meses = Balance::distinct('mes')->orderBy('mes')->get(['mes']);


        $request->flash();
        // Retornar la vista con los balances correspondientes y el último día del mes
        return view('welfare.balance', ['balances' => $balances, 'ultimo_dia_del_mes' => $ultimo_dia_del_mes, 'meses' => $meses]);
    }



    public function ingresos(Request $request)
    {
        $mes = $request->input('month');
        $ano = $request->input('year');

        // Obtener los balances correspondientes al mes y año seleccionado
        $balances = Balance::where('mes', $mes)
            ->where('ano', $ano)
            ->where('tipo', 'ingresos')
            ->get();

        // Obtener el último día del mes
        $ultimo_dia_del_mes = Carbon::createFromDate($ano, $mes)->endOfMonth()->format('Y-m-d');

        // Retornar la vista con los balances correspondientes y el último día del mes
        return view('welfare.balance', ['balances' => $balances, 'ultimo_dia_del_mes' => $ultimo_dia_del_mes, 'meses' => $meses]);
    }

    public function gastos(Request $request)
    {
        $mes = $request->input('month');
        $ano = $request->input('year');

        // Obtener los balances correspondientes al mes y año seleccionado
        $balances = Balance::where('mes', $mes)
            ->where('ano', $ano)
            ->where('tipo', 'gastos')
            ->get();

        // Obtener el último día del mes
        $ultimo_dia_del_mes = Carbon::createFromDate($ano, $mes)->endOfMonth()->format('Y-m-d');

        // Retornar la vista con los balances correspondientes y el último día del mes
        return view('welfare.balance', ['balances' => $balances, 'ultimo_dia_del_mes' => $ultimo_dia_del_mes]);
    }


    /*todo lo que parta con dos corresponde al TXT */
    public function dosindex()
    {
        return view('welfare.dos.index');
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

    /*Reporte con gráficos de Torta*/
    public function report()
    {
        $ingreso = Balance::select('inicial', 'traspaso', 'ajustado', 'ejecutado', 'saldo')
            ->where('ano', 2022)
            ->where('codigo', 'like', '10.000.00%')
            ->first();

        $gasto = Balance::select('inicial', 'traspaso', 'ajustado', 'ejecutado', 'saldo')
            ->where('ano', 2022)
            ->where('codigo', 'like', '20.000.00%')
            ->first();

        return view('welfare.report', compact('ingreso', 'gasto'));
    }


    public function exportBalance()
    {
        $ingresos = Balance::select('titulo', 'item', 'asignacion', 'glosa', 'inicial', 'ajustado', 'ejecutado', 'saldo')
            ->where('tipo', 'ingresos')
            ->get()
            ->map(function ($balance) {
                if ($balance->item == '000') {
                    $balance->item = '';
                }
                if ($balance->asignacion == '00') {
                    $balance->asignacion = '';
                }
                return $balance;
            });

        $gastos = Balance::select('titulo', 'item', 'asignacion', 'glosa', 'inicial', 'ajustado', 'ejecutado', 'saldo')
            ->where('tipo', 'gastos')
            ->get()
            ->map(function ($balance) {
                if ($balance->item == '000') {
                    $balance->item = '';
                }
                if ($balance->asignacion == '00') {
                    $balance->asignacion = '';
                }
                return $balance;
            });
        return Excel::download(new BalanceExport($ingresos, $gastos), 'balance.xlsx');
    }
}
