<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Finance\ComparativeRequirement;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class ComparativeRequirementImport implements ToCollection, WithStartRow,WithChunkReading
{



    public function startRow(): int
    {
        return 3;
    }

    public function chunkSize(): int
    {
        return 200;
    }

    private function formatRUT($rut)
    {
        // Eliminar caracteres no numéricos y convertir K a mayúscula
        $rut = preg_replace('/[^0-9kK]/', '', $rut);
        $rut = str_pad($rut, 8, '0', STR_PAD_LEFT); // El RUT sin el dígito verificador tiene 8 dígitos
    
        // Reordenar los números del RUT de derecha a izquierda
        $rut_reversed = strrev($rut);
    
        // Multiplicar cada dígito por la serie 2, 3, 4, 5, 6, 7 y sumar los resultados
        $sum = 0;
        $multipliers = [2, 3, 4, 5, 6, 7];
        $multiplier_index = 0;
        for ($i = 0; $i < 8; $i++) {
            $sum += (int)$rut_reversed[$i] * $multipliers[$multiplier_index];
            $multiplier_index = ($multiplier_index + 1) % count($multipliers);
        }
    
        // Calcular el resto de la división por 11
        $mod = $sum % 11;
    
        // Obtener el dígito verificador
        $dv = $mod == 0 ? 0 : ($mod == 1 ? 'K' : 11 - $mod);
    
        // Formatear RUT con puntos y guión
        $formatted_rut = substr($rut, 0, 2) . '.' . substr($rut, 2, 3) . '.' . substr($rut, 5, 3) . '-' . $dv;
        return $formatted_rut;
    }
    
    
    


    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        //
        $insert_array = [];
        foreach ($rows as $row) {
            $principal = $row[6] ?? '';

            $principal_values = explode('/', $principal);
            if (count($principal_values) >= 1 && (trim($principal_values[0]) === 'FA' || trim($principal_values[0]) === 'FE')) {

                $dte_rut_emisor = isset($principal_values[2]) ? $this->formatRUT(trim($principal_values[2])) : null;

                

                switch (trim($principal_values[0])) {
                    case 'FA':
                        $tipo_documento = 'factura_electronica';
                        break;
                    case 'FE':
                        $tipo_documento = 'factura_exenta';
                        break;
                    default:
                        $tipo_documento = trim($principal_values[0]);
                        break;
                }

                $insert_array[] = 
                [
                    'dte_rut_emisor'            => $dte_rut_emisor,
                    'dte_folio'                 => isset($principal_values[1]) ? trim($principal_values[1]) : null,
                    'dte_razon_social_emisor'   => trim($principal_values[4] ?? null),
                    'dte_tipo_documento'        => $tipo_documento,
                    'oc'                        => trim($principal_values[3] ?? null),

                    //afectacion
                    'afectacion_folio'          => $row[0],
                    //'afectacion_fecha'          => isset($row[1]) ? Carbon::instance(Date::excelToDateTimeObject($row[1])) : null,
                    

                    'afectacion_titulo'         => $row[2],
                    'afectacion_monto'          => $row[3],


                    //devengo
                    'devengo_folio'             => $row[4],
                    //'devengo_fecha'             => isset($row[5]) ? Carbon::instance(Date::excelToDateTimeObject($row[5])) : null,
                    'devengo_titulo'            => $row[6],
                    'devengo_monto'             => $row[7],
                    
                    //efectivo
                    'efectivo_folio'            => $row[8],
                    //'efectivo_fecha'             => isset($row[9]) ? Carbon::instance(Date::excelToDateTimeObject($row[9])) : null,
                    'efectivo_monto'            => $row[10],
                ];

                ComparativeRequirement::upsert(
                    $insert_array,
                    ['dte_rut_emisor', 'dte_folio', 'dte_tipo_documento'],
                    [
                        'dte_razon_social_emisor',
                        'oc',
                        


                        //afectacion
                        'afectacion_folio',
                        'afectacion_fecha',
                        'afectacion_titulo',
                        'afectacion_monto',

                        //devengo
                        'devengo_folio',
                        'devengo_fecha',
                        'devengo_titulo',
                        'devengo_monto',

                        //efectivo
                        'efectivo_folio',
                        'efectivo_fecha',
                        'efectivo_monto',


                    ]
                );

            }


        }
    }
}
