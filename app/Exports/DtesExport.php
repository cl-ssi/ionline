<?php

namespace App\Exports;

use App\Models\Finance\Dte;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DtesExport implements FromCollection, WithHeadings
{
    protected $dtes;

    public function __construct($dtes)
    {
        $this->dtes = $dtes;
    }

    public function collection()
    {
        // Obtener solo las columnas deseadas de los DTEs
        return $this->dtes->map(function ($dte) {
            return [
                'ID' => $dte->id,
                'FR' => $dte->requestForm?->folio,
                'OC' => $dte->folio_oc,
                'Tipo Documento' => $dte->tipo_documento,
                'Folio' => $dte->folio,
                'Emisor' => $dte->emisor,
                'Razon Social Emisor' => $dte->razon_social_emisor,
                'Fecha Emision' => $dte->emision?->format('Y-m-d'),
                'Monto Neto' => $dte->monto_neto,
                'Monto Exento' => $dte->monto_exento,
                'Monto Iva' => $dte->monto_iva,
                'Monto Total' => $dte->monto_total,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'FR',
            'OC',
            'Tipo Documento',
            'Folio',
            'Emisor',
            'Razon Social Emisor',
            'Fecha Emision',
            'Monto Neto',
            'Monto Exento',
            'Monto Iva',
            'Monto Total',
        ];
    }
}
