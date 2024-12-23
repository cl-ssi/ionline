<?php

namespace App\Livewire\Rrhh\Attendance;

use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Rrhh\MonthlyAttendance;

class AttendanceUpload extends Component
{
    use WithFileUploads;

    public $attendanceFile;
    public $missingUserIds = [];

    public function render()
    {
        return view('livewire.rrhh.attendance.attendance-upload');
    }

    public function save()
    {
        $this->validate([
            'attendanceFile' => 'required|file', // Asegúrate de que el archivo se ha cargado
        ]);

        $this->attendanceFile->storeAs('attendances', 'att.txt', 'local'); 
        $totalRecords = $this->processFile(storage_path('app/attendances/att.txt'));

        session()->flash('message', 'Archivo de asistencia cargado exitosamente. Total de registros: '. $totalRecords);
        $this->reset('attendanceFile'); // Reset input field
    }

    private function processFile($filepath)
    {
        $file          = fopen($filepath, 'r');
        $lineNumber    = 0;
        $records       = [];
        $date          = '';
        $ct_records    = 0;

        $meses = [];
        for ($i = 1; $i <= 12; $i++) {
            $meses[sprintf("%02d", $i)] = strtoupper(Carbon::createFromDate(null,$i,1)->monthName);
        }

        // Obtener todos los user_id existentes en un array
        $users = User::withTrashed()->pluck('id')->toArray();

        while ( !feof($file) ) {
            $line = fgets($file);
            $line = mb_convert_encoding($line, 'UTF-8', 'Windows-1252'); // Convertir de ANSI (Windows-1252) a UTF-8

            // Ignorar líneas vacías
            // if ( trim($line) == '' ) {
            //     continue;
            // }

            $lineNumber++;

            if ( $lineNumber == 1 ) {
                preg_match('/\d{2}\/\d{2}\/\d{4}/', $line, $matches);
                $fecha = $matches[0]; // Esto capturará "11/04/2024"

                $dateTime = DateTime::createFromFormat('d/m/Y', $fecha);
                $report_date = $dateTime->format('Y-m-d'); // Convertirá "11/04/2024" a "2024-04-11"

                continue;
            } elseif ( $lineNumber == 2 ) {
                preg_match('/\b([A-Z]+)\s+DEL\s+(\d{4})\b/', $line, $matches);
                $monthName = $matches[1];
                $year      = $matches[2];
                $date      = $year . '-' . array_search($monthName, $meses) . '-01';
                continue;
            } elseif ( $lineNumber == 3 ) {
                continue;
            }

            if ( preg_match('/^"RUT"\s+(\d+,\d+,\d+)\s+"-"\s+"(\w+)"/', $line, $matches) ) {
                $userId = str_replace(',', '', $matches[1]);

                // Verificar si el user_id existe en el array
                if (!in_array($userId, $users)) {
                    $this->missingUserIds[] = str_replace('"','',$line);
                    continue; // Saltar este user_id si no existe
                }

                $ct_records++;

                $records[$ct_records] = [
                    'user_id' => $userId,
                    'date' => $date,
                    'report_date' => $report_date,
                    'records' => $line,
                    'establishment_id' => auth()->user()->establishment_id,
                ];

            } elseif ( array_key_exists($ct_records,$records) ) {
                $records[$ct_records]['records'] .= $line; // Concatena las siguientes líneas
            }
        }

        // Comprobar que el array $records tenga registros
        if ( !empty($records) ) {
            MonthlyAttendance::upsert($records, ['user_id', 'date'], ['report_date', 'records']);
        }

        fclose($file);
        return $ct_records;
        // unlink($filepath); // Borra el archivo después de procesarlo
    }
}
