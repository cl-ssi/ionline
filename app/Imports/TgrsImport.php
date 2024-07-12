<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Finance\TgrPayedDte;
use App\Models\Finance\Dte;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TgrsImport implements WithHeadingRow, ToCollection,WithChunkReading
{

    public function headingRow(): int
    {
        return 5;
    }

    public function collection(Collection $rows)
    {
        $insert_array = [];

        foreach ($rows as $row) {
            if(isset($row['principal']))
            {
                list($rut_emisor, $razon_social_emisor) = explode(' ', $row['principal'], 2);
                $rut_emisor_formateado = $this->formatRut($rut_emisor);

                switch ($row['tipo_documento']) {
                    case '0102 Factura Afecta Electrónica':
                        $tipo_documento = 'factura_electronica';
                        break;
                    case '0102 033 Factura Electrónica':
                        $tipo_documento = 'factura_electronica';
                        break;
                    case '0202 034 Factura Exenta Electrónica':
                        $tipo_documento = 'factura_exenta';
                        break;
                    case '0202 Factura Exenta Electrónica':
                        $tipo_documento = 'factura_exenta';
                        break;
                    default:
                        $tipo_documento = $row['tipo_documento'];
                        break;
                }

                $dte = Dte::where('emisor', $rut_emisor_formateado)
                ->where('folio', $row['nro_documento'])
                ->where('tipo_documento', $tipo_documento)
                ->first();

                if($dte) {
                    $dte_id = $dte->id;
                    $dte->excel_proveedor = true;
                    $dte->paid = true;
                    if (!empty($row['cuenta_tgr'])) {
                        $dte->paid_automatic = true;
                    } else {
                        $dte->paid_manual = true;
                    }
                    $dte->save();
                } else {
                    $dte_id = null; 
                }


                $insert_array[] = 
                    [
                    'rut_emisor' => $rut_emisor_formateado,
                    'folio_documento' => $row['nro_documento'],
                    'razon_social_emisor' => $razon_social_emisor,
                    'tipo_documento' => $tipo_documento,
                    'area_transaccional' => $row['area_transaccional'],
                    'folio' => $row['folio'],
                    'tipo_operacion' => $row['tipo_operacion'],
                    'fecha_generacion' => isset($row['fecha_generacion']) ? Carbon::instance(Date::excelToDateTimeObject($row['fecha_generacion'])) : null,
                    'cuenta_contable' => $row['cuenta_contable'],
                    'tipo_documento_tgr' => $row['tipo_documento'],
                    'nro_documento' => $row['nro_documento'],
                    'fecha_cumplimiento' => isset($row['fecha_cumplimiento']) ? Carbon::instance(Date::excelToDateTimeObject($row['fecha_cumplimiento'])) : null,
                    'combinacion_catalogo' => $row['combinacion_catalogo'],
                    'principal' => $row['principal'],
                    'principal_relacionado' => $row['principal_relacionado'],
                    'beneficiario' => $row['beneficiario'],
                    'banco_cta_corriente' => $row['banco_cta_corriente'],
                    'medio_pago' => $row['medio_pago'],
                    'tipo_medio_pago' => $row['tipo_medio_pago'],
                    'nro_documento_pago' => $row['nro_documento_pago'],
                    'estado_documento' => $row['estado_documento'],
                    'monto' => $row['monto'],
                    'moneda' => $row['moneda'],
                    'tipo_cambio' => $row['tipo_cambio'],
                    'banco_beneficiario' => $row['banco_beneficiario'],
                    'cuenta_beneficiaria' => $row['cuenta_beneficiaria'],
                    'medio_de_pago' => $row['medio_de_pago'],
                    'numero_de_medio_de_pago' => $row['numero_de_medio_de_pago'],
                    'cuenta_tgr' => $row['cuenta_tgr'],
                    'dte_id' => $dte_id,
                    ];
            }
        }
        
        TgrPayedDte::upsert(
            $insert_array,
            ['rut_emisor', 'folio_documento', 'tipo_documento'],
            [
                'razon_social_emisor',
                'area_transaccional',
                'folio',
                'tipo_operacion',
                'fecha_generacion',
                'cuenta_contable',
                'nro_documento',
                'fecha_cumplimiento',
                'combinacion_catalogo',
                'principal',
                'principal_relacionado',
                'beneficiario',
                'banco_cta_corriente',
                'medio_pago',
                'tipo_medio_pago',
                'nro_documento_pago',
                'estado_documento',
                'monto',
                'moneda',
                'tipo_cambio',
                'banco_beneficiario',
                'cuenta_beneficiaria',
                'medio_de_pago',
                'numero_de_medio_de_pago',
                'cuenta_tgr', 
                'dte_id'
            ]
        );
    }

    private function formatRut($rut)
    {        
        $parte_numerica = substr($rut, 0, -2);
        $digito_verificador = substr($rut, -1); 
        $rut_formateado = number_format($parte_numerica, 0, ',', '.') . '-' . $digito_verificador;
        return $rut_formateado;
    }

    public function chunkSize(): int
    {
        return 200;
    }
}
