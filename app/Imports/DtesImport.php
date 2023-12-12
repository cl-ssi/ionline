<?php

namespace App\Imports;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use App\Models\Finance\Dte;

class DtesImport implements ToModel, WithStartRow, WithHeadingRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return Dte::updateOrCreate(
            [
                'tipo' => $row['tipo'],
                'tipo_documento' => $row['tipo_documento'],
                'folio' => $row['folio'],
                'emisor' => trim($row['emisor']),
            ],
            [
                'razon_social_emisor' => $row['razon_social_emisor'],
                'receptor' => $row['receptor'],
                'publicacion' => Carbon::instance(Date::excelToDateTimeObject($row['publicacion'])),
                'emision' => Carbon::instance(Date::excelToDateTimeObject($row['emision'])),
                'monto_neto' => $row['monto_neto'],
                'monto_exento' => $row['monto_exento'],
                'monto_iva' => $row['monto_iva'],
                'monto_total' => $row['monto_total'],
                'impuestos' => $row['impuestos'],
                'estado_acepta' => $row['estado_acepta'],
                'estado_sii' => $row['estado_sii'],
                'estado_intercambio' => $row['estado_intercambio'],
                'informacion_intercambio' => $row['informacion_intercambio'],
                'uri' => $row['uri'],
                'referencias' => $row['referencias'],
                'fecha_nar' => isset($row['fecha_nar']) ? Carbon::instance(Date::excelToDateTimeObject($row['fecha_nar'])) : null,
                'estado_nar' => $row['estado_nar'],
                'uri_nar' => $row['uri_nar'],
                'mensaje_nar' => $row['mensaje_nar'],
                'uri_arm' => $row['uri_arm'],
                'fecha_arm' => $row['fecha_arm'],
                'fmapago' => $row['fmapago'],
                'controller' => $row['controller'],
                'fecha_vencimiento' => isset($row['fecha_vencimiento']) ? Carbon::instance(Date::excelToDateTimeObject($row['fecha_vencimiento'])) : null,
                'estado_cesion' => $row['estado_cesion'],
                'url_correo_cesion' => $row['url_correo_cesion'],
                'fecha_recepcion_sii' => $row['fecha_recepcion_sii'],
                'estado_reclamo' => $row['estado_reclamo'],
                'fecha_reclamo' => $row['fecha_reclamo'],
                'mensaje_reclamo' => $row['mensaje_reclamo'],
                'estado_devengo' => $row['estado_devengo'],
                'codigo_devengo' => $row['codigo_devengo'],
                // if( trim(mb_strtoupper($row['folio_oc'])) != '' AND !is_null($row['folio_oc']) ) {
                //     'folio_oc' => trim(mb_strtoupper($row['folio_oc'])),
                // }
                'folio_oc' => trim(mb_strtoupper($row['folio_oc'])),
                'fecha_ingreso_oc' => $row['fecha_ingreso_oc'],
                'folio_rc' => $row['folio_rc'],
                'fecha_ingreso_rc' => $row['fecha_ingreso_rc'],
                'ticket_devengo' => $row['ticket_devengo'],
                'folio_sigfe' => $row['folio_sigfe'],
                'tarea_actual' => $row['tarea_actual'],
                'area_transaccional' => $row['area_transaccional'],
                'fecha_ingreso' => $row['fecha_ingreso'],
                'fecha_aceptacion' => $row['fecha_aceptacion'],
                'fecha' => $row['fecha'],
            ]
        );
    }
}
