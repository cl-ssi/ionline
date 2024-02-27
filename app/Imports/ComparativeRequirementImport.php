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

                $insert_array[] = 
                [
                    'dte_rut_emisor'            => isset($principal_values[2]) ? trim($principal_values[2]) : null,
                    'dte_folio'                 => isset($principal_values[1]) ? trim($principal_values[1]) : null,
                    'dte_razon_social_emisor'   => trim($principal_values[4] ?? null),
                    'dte_tipo_documento'        => trim($principal_values[0]),
                    'oc'                        => trim($principal_values[3] ?? null),

                    //afectacion
                    'afectacion_folio'          => $row[0],
                    //'afectacion_fecha' => isset($row[1]) ? Carbon::instance(Date::excelToDateTimeObject($row[1])) : null,
                    //preguntar por la fecha

                    'afectacion_titulo'         => $row[2],
                    'afectacion_monto'          => $row[3],


                    //devengo
                    'devengo_folio'          => $row[4],
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
                    ]
                );

            }


        }
    }
}
