<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WebService\PendingJsonToInsert;
use Illuminate\Support\Facades\Artisan;

class WebserviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fonasa(Request $request)
    {
        /* Si se le envió el run y el dv por GET */
        if($request->has('run') AND $request->has('dv')) {
            $rut = $request->input('run');
            $dv  = $request->input('dv');

            $wsdl = asset('ws/fonasa/CertificadorPrevisionalSoap.wsdl');
            $client = new \SoapClient($wsdl,array('trace'=>TRUE));
            $parameters = array(
                "query" => array(
                    "queryTO" => array(
                        "tipoEmisor"  => 3,
                        "tipoUsuario" => 2
                    ),
                    "entidad"           => env('FONASA_ENTIDAD'),
                    "claveEntidad"      => env('FONASA_CLAVE'),
                    "rutBeneficiario"   => $rut,
                    "dgvBeneficiario"   => $dv,
                    "canal"             => 3
                )
            );
            $result = $client->getCertificadoPrevisional($parameters);

            if ($result === false) {
                /* No se conecta con el WS */
                $error = array("error" => "No se pudo conectar a FONASA");
            }
            else {
                /* Si se conectó al WS */
                if($result->getCertificadoPrevisionalResult->replyTO->estado == 0) {
                    /* Si no hay error en los datos enviados */

                    $certificado            = $result->getCertificadoPrevisionalResult;
                    $beneficiario           = $certificado->beneficiarioTO;
                    $afiliado               = $certificado->afiliadoTO;

                    $user['run']            = $beneficiario->rutbenef;
                    $user['dv']             = $beneficiario->dgvbenef;
                    $user['name']           = $beneficiario->nombres;
                    $user['fathers_family'] = $beneficiario->apell1;
                    $user['mothers_family'] = $beneficiario->apell2;
                    $user['birthday']       = $beneficiario->fechaNacimiento;
                    $user['gender']         = $beneficiario->generoDes;
                    $user['desRegion']         = $beneficiario->desRegion;
                    $user['desComuna']         = $beneficiario->desComuna;
                    $user['direccion']      = $beneficiario->direccion;
                    $user['telefono']      = $beneficiario->telefono;

                    if($afiliado->desEstado == 'ACTIVO') {
                        $user['tramo'] = $afiliado->tramo;
                    }
                    else {
                        $user['tramo'] = null;
                    }
                    //$user['estado']       = $afiliado->desEstado;
                }
                else {
                    /* Error */
                    $error = array("error" => $result->getCertificadoPrevisionalResult->replyTO->errorM);
                }
            }

            // echo '<pre>';
            //print_r($result);
            //dd($result);

            return isset($user) ? json_encode($user) : json_encode($error);
        }
    }

    // public function pendingJsonToInsert(Request $request)
    // {
    //     // Obtener la ruta del modelo y los datos del JSON
    //     $modelRoute = $request->input('model_route');
    //     $modelData = $request->input('model_data');
    //     $columnMapping = $request->input('column_mapping');

    //     // Verificar si el JSON tiene el formato correcto
    //     if (!is_string($modelRoute) || !is_array($modelData) || !is_array($columnMapping)) {
    //         return response()->json(['error' => 'El JSON no tiene el formato correcto'], 400);
    //     }

    //     // Verificar si el modelo especificado existe
    //     if (!class_exists($modelRoute)) {
    //         return response()->json(['error' => 'El modelo especificado no existe'], 400);
    //     }

    //     // Verificar si el modelo especificado tiene las columnas especificadas en el mapeo
    //     $modelInstance = new $modelRoute;
    //     $modelColumns = $modelInstance->getConnection()->getSchemaBuilder()->getColumnListing($modelInstance->getTable());
    //     $mappedColumns = array_values($columnMapping);
    //     $invalidColumns = array_diff($mappedColumns, $modelColumns);
    //     if (count($invalidColumns) > 0) {
    //         return response()->json(['error' => 'El mapeo de columnas contiene nombres de columna no válidos para el modelo especificado', 'invalid_columns' => $invalidColumns], 400);
    //     }

    //     try {
    //         // Crear el registro solo si no existe una fila con los mismos datos
    //         PendingJsonToInsert::firstOrCreate(
    //             [   // Condiciones de búsqueda
    //                 'model_route' => $modelRoute,
    //                 'data_json' => json_encode($modelData),
    //                 'column_mapping' => json_encode($columnMapping)
    //             ],
    //             [   // Datos para crear el nuevo registro
    //                 'model_route' => $modelRoute,
    //                 'data_json' => json_encode($modelData),
    //                 'column_mapping' => json_encode($columnMapping), // Guardar el mapeo de columnas
    //                 'procesed' => 0
    //             ]
    //         );
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Error al crear o actualizar registros: ' . $e->getMessage()], 500);
    //     }

    //     // Ejecutar el comando de Artisan
    //     Artisan::call('process:pending-json');

    //     // Obtener el resultado de la ejecución del comando (opcional)
    //     $output = Artisan::output();

    //     // Devolver una respuesta al cliente
    //     return response()->json(['message' => 'Registros creados / Comando ejecutado con éxito', 'output' => $output]);
    // }

    public function pendingJsonToInsert(Request $request)
    {
        // Obtener la ruta del modelo y los datos del JSON
        $modelRoute = $request->input('model_route');
        $modelData = $request->input('model_data');
        $columnMapping = $request->input('column_mapping');
        $primaryKeys = $request->input('primary_keys');

        // Verificar si el JSON tiene el formato correcto
        if (!is_string($modelRoute) || !is_array($modelData) || !is_array($columnMapping) || !is_array($primaryKeys)) {
            return response()->json(['error' => 'El JSON no tiene el formato correcto'], 400);
        }

        // Verificar si el modelo especificado existe
        if (!class_exists($modelRoute)) {
            return response()->json(['error' => 'El modelo especificado no existe'], 400);
        }

        // Verificar si el modelo especificado tiene las columnas especificadas en el mapeo
        $modelInstance = new $modelRoute;
        $modelColumns = $modelInstance->getConnection()->getSchemaBuilder()->getColumnListing($modelInstance->getTable());
        $mappedColumns = array_values($columnMapping);
        $invalidColumns = array_diff($mappedColumns, $modelColumns);
        if (count($invalidColumns) > 0) {
            return response()->json(['error' => 'El mapeo de columnas contiene nombres de columna no validos para el modelo especificado', 'invalid_columns' => $invalidColumns], 400);
        }

        try {
            // Verificar si ya existe un registro con los mismos datos
            $existingRecord = PendingJsonToInsert::where('model_route', $modelRoute)
                ->where('data_json', json_encode($modelData))
                ->where('column_mapping', json_encode($columnMapping))
                ->where('primary_keys', json_encode($primaryKeys))
                ->exists();

            if ($existingRecord) {
                // Mostrar un mensaje indicando que ya existe un registro igual
                return response()->json(['message' => 'No se han creado registros, ya existen los que se intentan registrar'], 400);
            }

            // Crear el registro si no existe uno igual
            PendingJsonToInsert::create([
                'model_route' => $modelRoute,
                'data_json' => json_encode($modelData),
                'column_mapping' => json_encode($columnMapping),
                'primary_keys' => json_encode($primaryKeys),
                'procesed' => 0
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear o actualizar registros: ' . $e->getMessage()], 500);
        }

        // Ejecutar el comando de Artisan
        Artisan::call('process:pending-json');

        // Obtener el resultado de la ejecución del comando (opcional)
        $output = Artisan::output();

        // Devolver una respuesta al cliente
        return response()->json(['message' => 'Registros creados con exito', 'output' => $output]);
    }


}