<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Inv\Inventory;

class InventoriesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inventory::where('establishment_id',auth()->user()->organizationalUnit->establishment_id)
            ->whereNotNull('number')
            ->select(
                'number',
                'description',
                'unspsc_product_id',
                'brand',
                'model',
                'serial_number',
                'useful_life',
                'po_code',
                'status',
                'place_id',
                'request_user_id',
                'user_responsible_id',
                'user_using_id',
                'observations',
                'po_price',
                'accounting_code_id',
                'dte_number',
                'deliver_date',
                'old_number',
            )->get();
    }

    public function headings(): array
    {
        return [
            "numero-inventario",
            "descripcion (especificaciones tecnicas)",
            "producto estandar ONU (productUNSPSC)",
            "marca",
            "modelo",
            "serial",
            "vida_util",
            "codigo OC",
            "estado del producto",
            "lugar",
            "quien entrega",
            "responsable",
            "usuario",
            "observaciones",
            "valor",
            "cuenta contable",
            "factura",
            "fecha entrega",
            "old number"
        ];
    }
}
