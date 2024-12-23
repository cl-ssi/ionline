<?php

namespace App\Exports\RequestForms;

// use App\Models\RequestForms\RequestForm;
// use App\Models\RequestForms\ItemRequestForm;

// use Illuminate\Database\Eloquent\Collection;

// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\Exportable;

// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\WithColumnFormatting;
// use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
// use PhpOffice\PhpSpreadsheet\Shared\Date;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

// use Illuminate\Http\Request;
// use Illuminate\Support\LazyCollection;
// use Livewire\Component;
use Maatwebsite\Excel\Concerns\Exportable;

class FormItemsExport implements FromView, ShouldAutoSize /*FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting*/
{
    use Exportable;
    
    public $resultSearch;
    public $type;

    public function __construct($resultSearch, $type)
    {
        $this->resultSearch = $resultSearch;
        $this->type = $type;
    }

    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View
    {
        set_time_limit(3600);
        ini_set('memory_limit', '1024M');
        
        return view('request_form.reports.items', [
            'request_forms' => $this->resultSearch,
            'type' => $this->type
        ]);
    }

    /*
    public function collection()
    {
        return $this->resultSearch;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Estado Fomulario',
            'Folio',
            'Depende de Folio',
            'Fecha Creación',
            'Tipo de Formulario',
            'Mecanismo de Compra',
            'Descripción',
            'Programa',
            'Usuario Gestor',
            'Unidad Organizacional',
            'Comprador',
            'Items',
            'Presupuesto',
            'Estado Proceso Compra',
            'Fecha de Aprobación Depto. Abastecimiento',

            'N° Item',
            'ID',
            'Item Presupuestario',
            'Artículo',
            'UM',
            'Especificaciones Técnicas',
            'Cantidad',
            'Valor U.',
            'Impuestos',
            'Total Item',

            'Estado compra',
            'Tipo compra',
            'ID Licitación',
            'Fechas',
            'Orden de compra',
            'Proveedor RUT - nombre',
            'Cotización',
            'N° res.',
            'Especificaciones Técnicas (COMPRADOR/PROVEEDOR)',
            'Cantidad',
            'Unidad de medida',
            'Moneda',
            'Precio neto',
            'Total cargos',
            'Total descuentos',
            'Total impuesto',
            'Monto Total'
        ];
    }

    public function map($detailsToExport): array
    {
        $dateSupplyEvent = $detailsToExport->requestForm->eventRequestForms->where('event_type', 'supply_event')->where('status', 'approved')->last();

        return [
            $detailsToExport->requestForm->id,
            $detailsToExport->requestForm->getStatus(),
            $detailsToExport->requestForm->folio,
            $detailsToExport->requestForm->father ? $detailsToExport->requestForm->father->folio : '',
            Date::dateTimeToExcel($detailsToExport->requestForm->created_at),
            $detailsToExport->requestForm->SubtypeValue,
            ($detailsToExport->requestForm->purchaseMechanism ? $detailsToExport->requestForm->purchaseMechanism->PurchaseMechanismValue : ''),
            $detailsToExport->requestForm->name,
            $detailsToExport->requestForm->associateProgram->alias_finance ?? $detailsToExport->requestForm->program,
            ($detailsToExport->requestForm->user ? $detailsToExport->requestForm->user->fullName : 'Usuario eliminado'),
            ($detailsToExport->requestForm->userOrganizationalUnit ? $detailsToExport->requestForm->userOrganizationalUnit->name : 'UO eliminado'),
            $detailsToExport->requestForm->purchasers->first()->fullName ?? 'No asignado',
            $detailsToExport->requestForm->quantityOfItems(),
            $detailsToExport->requestForm->estimated_expense,
            $detailsToExport->requestForm->getStatus() == 'Aprobado' ? ($detailsToExport->requestForm->purchasingProcess ? $detailsToExport->requestForm->purchasingProcess->getStatus() : 'En espera') : '',
            ($dateSupplyEvent ? Date::dateTimeToExcel($dateSupplyEvent->signature_date) : 'No se ha firmado Documento'),
            '',
            $detailsToExport->id ?? '',
            ($detailsToExport->budgetItem ? $detailsToExport->budgetItem->fullName() : ''),
            ($detailsToExport->product_id ? optional($detailsToExport->product)->code.' '.optional($detailsToExport->product)->name : $detailsToExport->article),
            $detailsToExport->unit_of_measurement,
            substr($detailsToExport->specification, 0, 100),
            $detailsToExport->quantity,
            str_replace(',00', '', $detailsToExport->unit_value),
            $detailsToExport->tax, // FORMAT NUMBER #.### PENDIENTE
            $detailsToExport->expense, // FORMAT NUMBER #.### PENDIENTE
            $detailsToExport->pivot->getStatus(),
            $detailsToExport->pivot->getPurchasingTypeName(),
            $detailsToExport->pivot->tender ? $detailsToExport->pivot->tender->tender_number : '-',
            '',
            ($detailsToExport->pivot->tender && $detailsToExport->pivot->tender->oc ? $detailsToExport->pivot->tender->oc->po_id : ($detailsToExport->pivot->immediatePurchase ? $detailsToExport->pivot->immediatePurchase->po_id : '-')),
            ($detailsToExport->pivot->tender && $detailsToExport->pivot->tender->supplier ? $detailsToExport->pivot->tender->supplier->run.' - '.$detailsToExport->pivot->tender->supplier->name : $detailsToExport->pivot->supplier_run.' - '.$detailsToExport->pivot->supplier_name),
            ($detailsToExport->pivot->immediatePurchase ? $detailsToExport->pivot->immediatePurchase->cot_id : '-'),
            ($detailsToExport->pivot->directDeal ? $detailsToExport->pivot->directDeal->resol_direct_deal : '-'),
            'Comprador: '.substr($detailsToExport->specification, 0, 100), // proveedor: {{ substr($detail->pivot->supplier_specifications, 0, 100) }}
            $detailsToExport->pivot->quantity,
            $detailsToExport->unit_of_measurement,
            $detailsToExport->pivot->tender ? $detailsToExport->pivot->tender->currency : '',
            $detailsToExport->pivot->unit_value, //NUMBER
            $detailsToExport->pivot->charges,
            $detailsToExport->pivot->discounts,
            $detailsToExport->pivot->expense
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'N' => NumberFormat::FORMAT_NUMBER,
            'P' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'X' => NumberFormat::FORMAT_NUMBER,
            'Z' => NumberFormat::FORMAT_NUMBER
        ];
    }
    */
}
