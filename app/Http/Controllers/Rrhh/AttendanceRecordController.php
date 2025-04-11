<?php

namespace App\Http\Controllers\Rrhh;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Rrhh\AttendanceRecord;
use App\Notifications\Rrhh\AttendanceRecordNotification;
use Illuminate\Support\Facades\Notification;

class AttendanceRecordController extends Controller
{
    /**
     * Almacenar los registros de asistencia.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json(['message' => 'Registros de asistencia guardados exitosamente.']);

        try {

            $request->validate([
                'attendance_records' => 'required|array',
                'attendance_records.*.date' => 'required|date_format:Y-m-d',
                'attendance_records.*.id_number' => 'required|string',
                'attendance_records.*.name' => 'nullable|string',
                'attendance_records.*.time' => 'required|string',
                'attendance_records.*.status' => 'required|string',
                'attendance_records.*.verification' => 'required|string',
                'device_info.ip_address' => 'required|string',
                'device_info.serial_number' => 'required|string',
            ]);

            DB::beginTransaction();

            try {
                // Extraer información del dispositivo
                $clockIp = $request->input('device_info.ip_address');
                $clockSerial = $request->input('device_info.serial_number');

                foreach ($request->attendance_records as $record) {
                    $user = User::find($record['id_number']); // Buscar al usuario por su ID
                    
                    if($record['status'] == "IN") $status = 1; else $status = 0;
                    
                    if ($user) { // Solo crear si el usuario existe
                        AttendanceRecord::withoutEvents(function () use ($record, $user, $status, $clockIp, $clockSerial) {
                            AttendanceRecord::updateOrCreate(
                                [
                                    // Condición para buscar un registro existente
                                    'record_at' => $record['date'] . ' ' . $record['time'],
                                    'user_id' => $record['id_number'],
                                ],
                                [
                                    // Datos para actualizar o crear
                                    'type' => $status,
                                    'verification' => $record['verification'],
                                    'clock_ip' => $clockIp,              // Agregar IP del reloj
                                    'clock_serial' => $clockSerial,      // Agregar número de serie del reloj
                                    'establishment_id' => $user->establishment_id,
                                    // 'observation' => 'Registrado automáticamente'
                                ]
                            );
                        });
                    }
                }

                DB::commit();

                // Enviar notificación al finalizar exitosamente
                Notification::route('mail', 'sistemas.sst@redsalud.gob.cl')
                    ->notify(new AttendanceRecordNotification("Registros de asistencia guardados exitosamente."));

                return response()->json(['message' => 'Registros de asistencia guardados exitosamente.']);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Attendance record script (Error al guardar registros de asistencia):', ['exception' => $e]);
                return response()->json(['error' => 'Error al guardar los registros: ' . $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            Log::error('Attendance record script (Error al guardar registros de asistencia):', ['exception' => $e]);
            return response()->json(['error' => 'Error al guardar los registros: ' . $e->getMessage()], 500);
        }
    }
    
    public function logPythonError(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Validar que el tipo, mensaje y la IP sean proporcionados correctamente en la solicitud
            $request->validate([
                'ip' => 'required',
                'type' => 'required|in:error,info', // Solo acepta 'error' o 'info'
                'message' => 'required|string',
                'timestamp' => 'nullable|date'
            ]);

            // Obtener los datos del request
            $ip = $request->input('ip');
            $type = $request->input('type');
            $message = $request->input('message');
            $timestamp = $request->input('timestamp', now()->toISOString()); // Usar el timestamp actual si no se proporciona

            // Registrar el log según el tipo
            if ($type === 'error') {
                Log::error('Error reportado desde Python:', [
                    'ip' => $ip,
                    'error_message' => $message,
                    'timestamp' => $timestamp,
                ]);
            } elseif ($type === 'info') {
                Log::info('Información reportada desde Python:', [
                    'ip' => $ip,
                    'info_message' => $message,
                    'timestamp' => $timestamp,
                ]);
            }

            // Respuesta exitosa
            return response()->json([
                'message' => 'Log registrado exitosamente.',
                'type' => $type,
                'ip' => $ip,
                'timestamp' => $timestamp,
            ], 200);

        } catch (\Exception $e) {
            // Manejar errores al registrar el log
            Log::error('Error al registrar el log desde Python:', [
                'exception' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'error' => 'Error al registrar el log.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }


}
