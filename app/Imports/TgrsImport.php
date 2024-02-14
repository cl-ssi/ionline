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
            if(isset($row['principal'])){
            list($rut_emisor, $razon_social_emisor) = explode(' ', $row['principal'], 2);
            $rut_emisor_formateado = $this->formatRut($rut_emisor);
            $insert_array[] = [
                'rut_emisor' => $rut_emisor_formateado,
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
        }
        
        TgrPayedDte::upsert(
            $insert_array,
            ['rut_emisor', 'folio_documento'],
            ['razon_social_emisor', 'area_transaccional', 'folio', 'tipo_operacion', 'combinacion_catalogo', 'principal', 'principal_relacionado', 'beneficiario', 'banco_cta_corriente', 'created_at', 'updated_at']
        );
    }

    private function formatRut($rut)
    {
        // Formatear el RUN con puntos
        $parte_numerica = substr($rut, 0, -2); // Obtener los primeros caracteres sin el guion y el dígito verificador
        $digito_verificador = substr($rut, -1); // Obtener el dígito verificador
        $rut_formateado = number_format($parte_numerica, 0, ',', '.') . '-' . $digito_verificador;
        return $rut_formateado;
    }
}
