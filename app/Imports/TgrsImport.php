<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Models\Finance\TgrPayedDte;

class TgrsImport implements WithHeadingRow, ToModel, WithChunkReading
{

    public function headingRow(): int
    {
        return 5;
    }


    public function model(array $row)
    {        
        $principalParts = explode(' ', $row['principal'], 2);
        $rut_emisor = $principalParts[0] ?? null;
        $razon_social_emisor = $principalParts[1] ?? null;

        $array_clave =
        [
            'rut_emisor' => $rut_emisor,
            'folio_documento' => $row['nro_documento'],
        ];

        $array_variable =
        [
            'razon_social_emisor' => $razon_social_emisor,
            'area_transaccional' => $row['area_transaccional'],
            'folio' => $row['folio'],
            'tipo_operacion' => $row['tipo_operacion'],
            'nro_documento' => $row['nro_documento'],
            'combinacion_catalogo' => $row['combinacion_catalogo'],
            'principal' => $row['principal'],
            'principal_relacionado' => $row['principal_relacionado'],
            'beneficiario' => $row['beneficiario'],
            'banco_cta_corriente' => $row['banco_cta_corriente'],
        ];

        return TgrPayedDte::updateOrCreate($array_clave, $array_variable);
    }

    public function chunkSize(): int
    {
        return 200;
    }

}
