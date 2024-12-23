<?php

namespace App\Models\Rrhh;

use App\Models\Establishment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlyAttendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rrhh_monthly_attendances';

    protected $fillable = [
        'user_id',
        'date',
        'records',
        'report_date',
        'establishment_id',
    ];

    protected $casts = [
        'date' => 'date',
        'report_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get formated records of attendance.
     */
    protected function records(): Attribute
    {
        return Attribute::make(
            get: function (string $value) {
                $record = str_replace(
                    '"Días"	"Horario "	"Horario "	"Horas "	"Horas "	"Horas Extras "	"Total Horas "	"Atrasos y "', 
               "\n".'"Días"														"Horario "						"Horario "				"Horas "		"Horas " "H.Extra"  "Total"		"Atrasos"', 
                    $value);
                $record = str_replace('"', '', $record);
                return $record;
            },
        );
    }

    /**
     * Obtener el grado del records.
     */
    protected function grado(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Definir la expresión regular para buscar "GRADO" seguido de un valor numérico
                $pattern = '/GRADO\s+"?(\d+)"?/';

                // Buscar el grado en los registros
                if (preg_match($pattern, $this->records, $matches)) {
                    return $matches[1] ?? null; // Retornar el valor encontrado
                }

                return null; // Retornar null si no se encontró el grado
            }
        );
    }

    protected function details(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Dividir el contenido en líneas
                $lines = explode("\n", $this->records);
                
                // Días de la semana válidos
                $diasSemana = ["Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"];
                
                // Inicializar un array para almacenar los resultados
                $parsedRecords = [];
                
                // Recorrer cada línea del contenido
                foreach ($lines as $line) {
                    // Dividir la línea en columnas usando el delimitador de tabulación (\t)
                    $columns = explode("\t", $line);
                
                    // Verificar si la primera columna es un día de la semana válido
                    if (in_array($columns[0], $diasSemana)) {
                        // Asignar cada campo a una clave del array
                        $parsedRecords[] = [
                            'dia' => $columns[0] ?? '',
                            'fecha' => $columns[1] ?? '',
                            'entrada' => $columns[2] ?? '',
                            'salida' => $columns[4] ?? '',
                            'entrada_real' => $columns[5] ?? '',
                            'salida_real' => $columns[7] ?? '',
                            'horas' => $columns[8] ?? '',
                            'horas_cero' => $columns[9] ?? '',
                            'horas_extra' => $columns[10] ?? '',
                            'horas_trabajadas' => $columns[11] ?? '',
                            'atrasos' => $columns[12] ?? ''
                        ];
                    }
                }

                return $parsedRecords;
            }
        );
    }

    protected function overTimeRefundDetails(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Dividir el contenido en líneas
                $lines = explode("\n", $this->records);
                
                // Días de la semana válidos
                $diasSemana = ["Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"];
                
                // Inicializar un array para almacenar los resultados
                $parsedRecords = [];

                // Función para convertir "01H,13m" a minutos
                function convertirAHorasExtraEnMinutos($horasExtra)
                {
                    preg_match('/(\d+)H,(\d+)m/', $horasExtra, $matches);
                    $horas = isset($matches[1]) ? (int)$matches[1] : 0;
                    $minutos = isset($matches[2]) ? (int)$matches[2] : 0;
                    return ($horas * 60) + $minutos;
                }

                // Función para convertir la fecha de "d/m/Y" a "Y-m-d"
                function convertirFecha($fecha)
                {
                    $date = Carbon::createFromFormat('d/m/Y', $fecha);
                    return $date ? $date->format('Y-m-d') : null;
                }

                // Recorrer cada línea del contenido
                foreach ($lines as $line) {
                    // Dividir la línea en columnas usando el delimitador de tabulación (\t)
                    $columns = explode("\t", $line);
                
                    // Verificar si la primera columna es un día de la semana válido
                    if (in_array($columns[0], $diasSemana)) {
                        // Asignar cada campo a una clave del array
                        $parsedRecords[] = [
                            // 'dia' => $columns[0] ?? '',
                            'date' => isset($columns[1]) ? convertirFecha($columns[1]) : '',
                            // 'entrada' => $columns[2] ?? '',
                            // 'salida' => $columns[4] ?? '',
                            'entrada_real' => $columns[5] ?? '',
                            'salida_real' => $columns[7] ?? '',
                            // 'horas' => $columns[8] ?? '',
                            // 'horas_cero' => $columns[9] ?? '',
                            'overtime' =>  isset($columns[10]) ? convertirAHorasExtraEnMinutos($columns[10]) : 0,
                            // 'horas_trabajadas' => $columns[11] ?? '',
                            // 'atrasos' => $columns[12] ?? ''
                            'hours_day' => '0',
                            'hours_night' => '0',
                            'active' => false
                        ];
                    }
                }

                return $parsedRecords;
            }
        );
    }
}
