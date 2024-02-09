<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Finance\Dte;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;



class BheImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */

    public function headingRow(): int
    {
        return 6;
    }

    public function model(array $row)
    {

    if ($row['estado'] === 'VIGENTE') {

        $array_clave =
        [
            'folio' => $row['n'],
            'emisor' => trim($row['rut']),
            
        ];

        $array_variable =
        [
            'razon_social_emisor' => $row['nombre_o_razon_social'],
            'tipo'=> '69',
            'tipo_documento'=> 'boleta_honorarios',
            'receptor' => '61.606.100-3',
            'monto_neto' => $row['pagado'],
            'monto_iva' => $row['retenido'],
            'monto_total' => $row['brutos'],
            'emision' => Carbon::instance(Date::excelToDateTimeObject($row['fecha'])),
        ];

        return Dte::updateOrCreate($array_clave, $array_variable);
        }

    }

}
