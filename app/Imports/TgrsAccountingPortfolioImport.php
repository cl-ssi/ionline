<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Finance\TgrAccountingPortfolio;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\Finance\Dte;

class TgrsAccountingPortfolioImport implements ToCollection, WithHeadingRow, WithChunkReading
{

    public function headingRow(): int
    {
        return 11;
    }



    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        set_time_limit(3600);
        ini_set('memory_limit', '1024M');
        $insert_array = [];

        foreach ($rows as $row) {
            if(isset($row['folio'])){
            list($rut_emisor, $razon_social_emisor) = explode(' ', $row['principal'], 2);
            $rut_emisor_formateado = $this->formatRut($rut_emisor);


            switch ($row['tipo_documento']) {
                case 'Factura Afecta Electrónica':
                    $tipo_documento = 'factura_electronica';
                    break;
                case 'Factura Exenta Electrónica':
                    $tipo_documento = 'factura_exenta';
                    break;
                case 'Boleta de Honorarios Electrónica':
                    $tipo_documento = 'boleta_honorarios';
                    break;
                case 'Nota de Crédito Electrónica':
                    $tipo_documento = 'nota_credito';
                    break;
                case 'Nota de Débito Electrónica':
                    $tipo_documento = 'nota_debito';
                    break;
                default:
                    $tipo_documento = $row['tipo_documento'];
                    break;
            }



            $dte = Dte::where('emisor', $rut_emisor_formateado)
            ->where('folio', $row['numero_documento'])
            ->where('tipo_documento', $tipo_documento)
            ->first();

            if($dte) {
                $dte_id = $dte->id;
                $dte->excel_cartera = true;
                $dte->save();
            } else {
                $dte_id = null; 
            }


            $insert_array[] = [
                'rut_emisor' => $rut_emisor_formateado,
                'folio_documento' => $row['folio'],
                'razon_social_emisor' => $razon_social_emisor,
                'cuenta_contable' => $row['cuenta_contable'],
                'principal' => $row['principal'],
                'saldo' => $row['saldo'],
                'tipo_movimiento' => $row['tipo_movimiento'],
                'fecha' => isset($row['fecha']) ? Carbon::instance(Date::excelToDateTimeObject($row['fecha'])) : null,
                'titulo' => $row['titulo'],
                'debe' => $row['debe'],
                'haber' => $row['haber'],
                'saldo_acumulado' => $row['saldo_acumulado'],
                'tipo_documento' => $row['tipo_documento'],
                'numero' => $row['numero'],
                'origen_transaccion' => $row['origen_transaccion'],
                'numero_documento' => $row['numero_documento'],
                'dte_id' => $dte_id,
                ];
            }
        }


        TgrAccountingPortfolio::upsert(
            $insert_array,
            ['rut_emisor', 'folio_documento', 'tipo_documento'],
                [
                'razon_social_emisor',
                'cuenta_contable',
                'principal',
                'saldo',
                'tipo_movimiento',
                'fecha',
                'titulo',
                'debe',
                'haber',
                'saldo_acumulado',
                'numero',
                'origen_transaccion',
                'numero_documento',
                'dte_id'
                ]
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

    public function chunkSize(): int
    {
        return 30;
    }
}
