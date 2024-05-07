<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{WithHeadings, WithMapping, ShouldAutoSize};
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use App\Models\Inv\Inventory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class InventoriesExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithChunkReading
{
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     $establishmentId = auth()->user()->organizationalUnit->establishment_id;

    //     $inventories = new Collection();

    //     Inventory::with('unspscProduct', 'lastMovement', 'lastMovement.place', 'lastMovement.place.location')
    //         ->where('establishment_id', $establishmentId)
    //         ->whereNotNull('number')
    //         ->chunk(50, function ($chunk) use ($inventories) {
    //             $inventories->push($chunk);
    //         });

    //     return $inventories->flatten();
    // }

    public function query()
    {
        $establishmentId = auth()->user()->organizationalUnit->establishment_id;

        return Inventory::query()
            ->with('unspscProduct', 'lastMovement', 'lastMovement.place', 'lastMovement.place.location')
            ->where('establishment_id', $establishmentId)
            ->whereNotNull('number');
    }
    

    public function headings(): array
    {
        return [
            "código de inventario",
            "Std-Descripcion",
            "código producto estandar ONU (productUNSPSC)",
            "marca",
            "modelo",
            "serial",
            "vida_util",
            "orden de compra",
            "estado del producto",
            "ubicacion",
            "lugar id",
            "lugar",
            "Código interno Arquitectura",
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


        $unspscProductInfo = optional($inventory->unspscProduct)->name ? 'Std: ' . rtrim($inventory->unspscProduct->name) : '';
        $productInfo = $inventory->product ? 'Bodega: ' . rtrim($inventory->product->name) : 'Desc: ' . rtrim($inventory->description);



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
            //$inventory->description,
            $unspscProductInfo . ' ' . $productInfo,
            optional($inventory->unspscProduct)->code,
            $inventory->brand,
            $inventory->model,
            $inventory->serial_number,
            $inventory->useful_life,
            $inventory->po_code,
            //$inventory->status,
            $status,
            $inventory->lastMovement?->place?->location->name,
            $inventory->lastMovement?->place?->id,
            $inventory->lastMovement?->place?->name,
            $inventory->lastMovement?->place?->architectural_design_code,
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

    
    public function chunkSize(): int
    {
        return 100;
    }
    
}
