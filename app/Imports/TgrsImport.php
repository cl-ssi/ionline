<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Finance\TgrPayedDte;

class TgrsImport implements WithHeadingRow, ToCollection
{

    public function headingRow(): int
    {
        return 5;
    }

    public function collection(Collection $rows)
    {
        $insert_array = [];

        foreach ($rows as $row) {
            $principalParts = explode(' ', $row['principal'], 2);
            $rut_emisor = $principalParts[0] ?? null;
            $razon_social_emisor = $principalParts[1] ?? null;

            $insert_array[] = [
                'rut_emisor' => $rut_emisor,
                'folio_documento' => $row['nro_documento'],
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
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Realizar el upsert para el conjunto de datos recolectados
        TgrPayedDte::upsert(
            $insert_array,
            ['rut_emisor', 'folio_documento'],
            ['razon_social_emisor', 'area_transaccional', 'folio', 'tipo_operacion', 'combinacion_catalogo', 'principal', 'principal_relacionado', 'beneficiario', 'banco_cta_corriente', 'created_at', 'updated_at']
        );
    }
}
