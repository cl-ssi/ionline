<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class DteReadyExport implements FromCollection, WithHeadings
{
    protected $dtes;

    public function __construct($dtes)
    {
        $this->dtes = $dtes;
    }

    public function collection()
    {
        // Filtrar solo los campos necesarios para la exportación
        $filteredDtes = $this->dtes->map(function ($dte) {
            $receptionIds = $dte->receptions->pluck('id')->implode(', ');
            return [
                'id' => $dte->id,
                'emisor' => $dte->emisor,
                'folio' => $dte->folio,
                'folio_oc' => $dte->folio_oc,
                'folio_compromiso' => $dte->folio_compromiso_sigfe,
                'folio_devengo' => $dte->folio_devengo_sigfe,
                'folio_pago' => $dte->paid_folio,
                'recepcion' => $dte->receptions->isNotEmpty() ? 'Sí' : 'No',
                'id_recepcion' => $receptionIds,
                'proveedor' => $dte->excel_proveedor ? 'Sí' : 'No',
                'cartera' => $dte->excel_cartera ? 'Sí' : 'No',
                'requerimiento' => $dte->excel_requerimiento ? 'Sí' : 'No',
                'revision' => $dte->check_tesoreria ? 'Sí' : 'No',
            ];
        });

        return new Collection($filteredDtes);
    }

    public function headings(): array
    {
        return [
            'ID', 
            'Emisor', 
            'Folio', 
            'Folio OC', 
            'Folio Compromiso', 
            'Folio Devengo', 
            'Folio Pago', 
            'Recepción', 
            'ID Recepción', 
            'Excel Proveedor', 
            'Excel Cartera Contable', 
            'Excel Requerimiento', 
            'Revisión por tesorería'
        ];
    }
}
