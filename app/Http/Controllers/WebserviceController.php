<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WebService\PendingJsonToInsert;
use Illuminate\Support\Facades\Artisan;

use App\Notifications\Sirh\PendingJsonToInsertNotification;
use Illuminate\Support\Facades\Notification;

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

    public function pendingJsonToInsert(Request $request)
    {
        try {
            ini_set('max_execution_time', 300); // Aumenta el tiempo de ejecución a 300 segundos (5 minutos)

            // Obtener la ruta del modelo y los datos del JSON
            $modelRoute = $request->input('model_route');
            $modelData = $request->input('model_data');
            $columnMapping = $request->input('column_mapping');
            $primaryKeys = $request->input('primary_keys');

            // Verificar si el JSON tiene el formato correcto
            if (!is_string($modelRoute) || !is_array($modelData) || !is_array($columnMapping) || !is_array($primaryKeys)) {

                Notification::route('mail', 'sistemas.sst@redsalud.gob.cl')
                    ->notify(new PendingJsonToInsertNotification("El JSON no tiene el formato correcto: " . $modelRoute ));

                return response()->json(['error' => 'El JSON no tiene el formato correcto'], 400);
            }

            // Verificar si el modelo especificado existe
            if (!class_exists($modelRoute)) {

                Notification::route('mail', 'sistemas.sst@redsalud.gob.cl')
                    ->notify(new PendingJsonToInsertNotification("El modelo especificado no existe: " . $modelRoute ));

                return response()->json(['error' => 'El modelo especificado no existe'], 400);
            }

            // Verificar si el modelo especificado tiene las columnas especificadas en el mapeo
            $modelInstance = new $modelRoute;
            $modelColumns = $modelInstance->getConnection()->getSchemaBuilder()->getColumnListing($modelInstance->getTable());
            $mappedColumns = array_values($columnMapping);
            $invalidColumns = array_diff($mappedColumns, $modelColumns);
            if (count($invalidColumns) > 0) {

                Notification::route('mail', 'sistemas.sst@redsalud.gob.cl')
                    ->notify(new PendingJsonToInsertNotification("El mapeo de columnas contiene nombres de columna no validos para el modelo especificado: " . $modelRoute, $invalidColumns));

                return response()->json(['error' => 'El mapeo de columnas contiene nombres de columna no validos para el modelo especificado', 'invalid_columns' => $invalidColumns], 400);
            }

            try {
                // // Verificar si ya existe un registro con los mismos datos
                // $existingRecord = PendingJsonToInsert::where('model_route', $modelRoute)
                //     ->where('data_json', json_encode($modelData))
                //     ->where('column_mapping', json_encode($columnMapping))
                //     ->where('primary_keys', json_encode($primaryKeys))
                //     ->exists();

                // if ($existingRecord) {

                //     Notification::route('mail', 'sistemas.sst@redsalud.gob.cl')
                //         ->notify(new PendingJsonToInsertNotification("No se han creado registros, ya existen los que se intentan registrar: " . $modelRoute ));

                //     // Mostrar un mensaje indicando que ya existe un registro igual
                //     return response()->json(['message' => 'No se han creado registros, ya existen los que se intentan registrar: ' . $modelRoute], 400);
                // }

                // Crear el registro si no existe uno igual
                $pendingJson = PendingJsonToInsert::create([
                    'model_route' => $modelRoute,
                    'data_json' => json_encode($modelData),
                    'column_mapping' => json_encode($columnMapping),
                    'primary_keys' => json_encode($primaryKeys),
                    'procesed' => 0
                ]);

            } catch (\Exception $e) {

                Notification::route('mail', 'sistemas.sst@redsalud.gob.cl')
                    ->notify(new PendingJsonToInsertNotification("Error al crear o actualizar registros: " . $modelRoute . ": " . $e->getMessage()));

                return response()->json(['error' => 'Error al crear o actualizar registros: ' . $e->getMessage()], 500);
            }

            // Ejecutar el comando de Artisan
            Artisan::call('process:pending-json');

            // Obtener el resultado de la ejecución del comando (opcional)
            $output = Artisan::output();

            // Enviar la notificación
            Notification::route('mail', 'sistemas.sst@redsalud.gob.cl')->notify(new PendingJsonToInsertNotification("Registros creados con exito", $output));

            // Si la ejecución fue exitosa, eliminar los registros anteriores del mismo modelo
            PendingJsonToInsert::where('model_route', $modelRoute)
                ->where('id', '<>', $pendingJson->id) // Excluir el registro recién creado
                ->delete();

            // Devolver una respuesta al cliente
            return response()->json(['message' => 'Registros creados con exito', 'output' => $output]);

        } catch (\Exception $e) {

            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }



}