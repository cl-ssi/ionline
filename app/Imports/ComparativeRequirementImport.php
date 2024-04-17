<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Finance\ComparativeRequirement;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\Finance\Dte;


class ComparativeRequirementImport implements ToCollection, WithStartRow,WithChunkReading
{



    public function startRow(): int
    {
        return 3;
    }

    public function chunkSize(): int
    {
        return 5;
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
            $tipo_documento = null;
            $dte_rut_emisor = null;
            $dte = null;

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


                $dte = Dte::where('emisor', $dte_rut_emisor)
                ->where('folio', trim($principal_values[1]))
                ->where('tipo_documento', $tipo_documento)
                ->first();

                if($dte) {
                    $dte_id = $dte->id;
                    $dte->excel_requerimiento = true;
                    $dte->paid = true;
                    $dte->paid_folio = $row[8];
                    $dte->paid_at = isset($row[1]) && strpos($row[9], '/') !== false ? Carbon::createFromFormat('d/m/Y', $row[9]) : null;
                    $dte->paid_effective_amount = isset($row[10]) ? (int)str_replace('.', '', $row[10]) : null;
                    $dte->paid_automatic = true;
                    $dte->save();
                } else {
                    $dte_id = null; 
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
                    'afectacion_fecha' => isset($row[1]) && strpos($row[1], '/') !== false ? Carbon::createFromFormat('d/m/Y', $row[1]) : null,
                    'afectacion_titulo'         => $row[2],
                    'afectacion_monto'          => isset($row[3]) ? (int)str_replace('.', '', $row[3]) : null,

                    //devengo
                    'devengo_folio'             => $row[4],
                    'devengo_fecha'             => isset($row[1]) && strpos($row[5], '/') !== false ? Carbon::createFromFormat('d/m/Y', $row[5]) : null,
                    'devengo_titulo'            => $row[6],
                    'devengo_monto'             => $row[7],
                    
                    //efectivo
                    'efectivo_folio'            => $row[8],
                    'efectivo_fecha'            => isset($row[1]) && strpos($row[9], '/') !== false ? Carbon::createFromFormat('d/m/Y', $row[9]) : null,
                    'efectivo_monto'            => isset($row[10]) ? (int)str_replace('.', '', $row[10]) : null,


                    'dte_id'                    => $dte_id,
                ];



            }
            else{
                if (isset($row[4]) && $row[4] != 0 && isset($row[5]) && strpos($row[5], '/') !== false) 
                {
                    $dte_rut_emisor = null;
                    $tipo_documento = null;
                    $devengo_fecha = null;
                    $devengo_year = null;
                    $dte_folio = null;
                    $dte_razon_social_emisor = null;
                    $dte = null;
                    $dte_id = null;
                    $oc = null;

                    if (isset($row[5]) && strpos($row[5], '/') !== false) {
                        $devengo_fecha = Carbon::createFromFormat('d/m/Y', $row[5]);
                        $devengo_year = Carbon::createFromFormat('d/m/Y', $row[5])->year;
                    }

                    


                    $dte = Dte::where('folio_devengo_sigfe', $row[4]);
                    // if ($devengo_year) {
                    //     $dte->whereYear('created_at', $devengo_year);
                    // }
                    $dte = $dte->latest()->first();


                    if($dte) {
                        // dd($dte);
                        $dte_id = $dte->id;
                        $dte->excel_requerimiento = true;
                        $dte->paid = true;
                        $dte->paid_folio = $row[8];
                        $dte->paid_at = isset($row[1]) && strpos($row[9], '/') !== false ? Carbon::createFromFormat('d/m/Y', $row[9]) : null;
                        $dte->paid_effective_amount = isset($row[10]) ? (int)str_replace('.', '', $row[10]) : null;
                        $dte->paid_manual = true;
                        $dte->save();
                        $dte_rut_emisor = $dte->emisor;
                        $tipo_documento = $dte->tipo_documento;
                        $dte_folio = $dte->folio;
                        $dte_razon_social_emisor = $dte->razon_social_emisor;
                        $oc = $dte->folio_oc;
                    } else {
                        $dte_id = null; 
                    }

                    $insert_array[] = 
                    [
                        'dte_rut_emisor'            => $dte_rut_emisor ?? null,
                        'dte_folio'                 => $dte_folio ?? null,
                        'dte_razon_social_emisor'   => $dte_razon_social_emisor ?? null,
                        'dte_tipo_documento'        => $tipo_documento ?? null,
                        'oc'                        => $oc ?? null,

                        //afectacion
                        'afectacion_folio'          => $row[0],
                        'afectacion_fecha' => isset($row[1]) && strpos($row[1], '/') !== false ? Carbon::createFromFormat('d/m/Y', $row[1]) : null,
                        'afectacion_titulo'         => $row[2],
                        'afectacion_monto'          => isset($row[3]) ? (int)str_replace('.', '', $row[3]) : null,

                        //devengo
                        'devengo_folio'             => $row[4],
                        'devengo_fecha'             => $devengo_fecha,
                        'devengo_titulo'            => $row[6],
                        'devengo_monto'             => $row[7],
                        
                        //efectivo
                        'efectivo_folio'            => $row[8],
                        'efectivo_fecha'            => isset($row[1]) && strpos($row[9], '/') !== false ? Carbon::createFromFormat('d/m/Y', $row[9]) : null,
                        'efectivo_monto'            => isset($row[10]) ? (int)str_replace('.', '', $row[10]) : null,

                        'dte_id'                    => $dte_id,
                    ];
                

                }
                else {                 
                    continue;
                }
            }


        }


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

                'dte_id',

            ]
        );
    }
}
