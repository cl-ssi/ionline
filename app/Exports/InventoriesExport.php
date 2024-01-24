<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{WithHeadings, WithMapping, ShouldAutoSize};
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Inv\Inventory;
use Illuminate\Support\Collection;

class InventoriesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $establishmentId = auth()->user()->organizationalUnit->establishment_id;

        $inventories = new Collection();

        Inventory::with('unspscProduct', 'lastMovement')
            ->where('establishment_id', $establishmentId)
            ->whereNotNull('number')
            ->chunk(200, function ($chunk) use ($inventories) {
                $inventories->push($chunk);
            });

        return $inventories->flatten();
    }
    

    public function headings(): array
    {
        return [
            "numero-inventario",
            "descripcion",
            "código producto estandar ONU (productUNSPSC)",
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
            "old number",
        ];
    }

    public function map($inventory): array
    {
        //$description = '';
        $status = '';

        switch ($inventory->status) {
                case -1:
                $status = 'MALO';
                break;
            case 0:
                $status = 'REGULAR';
                break;
            case 1:
                $status = 'BUENO';
                break;
            default:
                $status = 0;
                break;
        }

        $receptionDate = $inventory->lastMovement?->reception_date ? \Carbon\Carbon::parse($inventory->lastMovement->reception_date)->format('d-m-Y') : null;



        // if ($inventory->unspscProduct) {
        //     $description .= 'Std: ' . rtrim($inventory->unspscProduct->name) . "\n";
        // }

        // if ($inventory->product) {
        //     $description .= 'Bodega: ' . rtrim($inventory->product->name);
        // } else {
        //     $description .= 'Desc: ' . rtrim($inventory->description);
        // }

        return [
            $inventory->number,
            $inventory->description,
            optional($inventory->unspscProduct)->code,
            $inventory->brand,
            $inventory->model,
            $inventory->serial_number,
            $inventory->useful_life,
            $inventory->po_code,
            //$inventory->status,
            $status,
            $inventory->place_id,
            $inventory->request_user_id,
            $inventory->user_responsible_id,
            $inventory->user_using_id,
            $inventory->observations,
            $inventory->po_price,
            $inventory->accounting_code_id,
            $inventory->dte_number,
            //$inventory->lastMovement?->reception_date,
            $receptionDate,
            $inventory->old_number,
        ];
    }
    
}
