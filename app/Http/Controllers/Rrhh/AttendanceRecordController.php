<?php

namespace App\Http\Controllers\Rrhh;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Rrhh\AttendanceRecord;

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
                                    'observation' => 'Registrado automáticamente'
                                ]
                            );
                        });
                    }
                }

                DB::commit();
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
}
