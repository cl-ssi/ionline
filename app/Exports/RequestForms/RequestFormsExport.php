<?php

namespace App\Exports\RequestForms;

// use App\Models\RequestForms\RequestForm;
// use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
// use Illuminate\Database\Eloquent\Collection;
// use Illuminate\Database\Query\Builder;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
// use Illuminate\Http\Request;
// use Livewire\Component;
// use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
// use Maatwebsite\Excel\Concerns\WithColumnFormatting;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RequestFormsExport implements FromView, ShouldAutoSize //FromQuery, WithMapping, WithHeadings, ShouldAutoSize //FromCollection, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;

    public $resultSearch;

    public function __construct($resultSearch)
    {
        $this->resultSearch = $resultSearch;
    }

    public function view(): View
    {
        set_time_limit(3600);
        ini_set('memory_limit', '1024M');
        
        return view('request_form.reports.all_forms', [
            'request_forms' => $this->resultSearch
        ]);
    }

    // public function query()
    // {
    //     return $this->query;
    //     // return RequestForm::with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'purchaseType', 'eventRequestForms.signerUser',
    //     // 'eventRequestForms.signerOrganizationalUnit', 'father:id,folio,has_increased_expense', 'purchasers', 'purchasingProcess');
    // }

    // public function headings(): array
    // {
    //     return [
    //         'ID',
    //         'Estado',
    //         'Folio',
    //         'Depende de folio',
    //         'Fecha Creación',
    //         'Tipo / Mecanismo de Compra',
    //         'Descripción',
    //         'Programa',
    //         'Usuario Gestor',
    //         'Comprador',
    //         'Items',
    //         '',
    //         'Presupuesto',
    //         'Estado Proceso compra',
    //         'Fecha de Aprobación Depto Abastecimiento'
    //     ];
    // }

    // public function map($requestForm): array
    // {
    //     // $dateSupplyEvent = $requestForm->eventRequestForms->where('event_type', 'supply_event')->where('status', 'approved')->last();

    //     return [
    //         $requestForm->id,
    //         $requestForm->getStatus(),
    //         $requestForm->folio,
    //         $requestForm->father ? $requestForm->father->folio : '',
    //         $requestForm->created_at->format('d-m-Y H:i'),
    //         ($requestForm->purchaseMechanism ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '').' '.$requestForm->SubtypeValue,
    //         $requestForm->name,
    //         $requestForm->associateProgram->alias_finance ?? $requestForm->program,
    //         ($requestForm->user ? $requestForm->user->fullName : 'Usuario eliminado').' '.($requestForm->userOrganizationalUnit ? $requestForm->userOrganizationalUnit->name : 'UO eliminado'),
    //         $requestForm->purchasers->first()->fullName ?? 'No asignado',
    //         $requestForm->quantityOfItems(),
    //         $requestForm->symbol_currency,
    //         number_format($requestForm->estimated_expense,$requestForm->precision_currency,".",""),
    //         $requestForm->getStatus() == 'Aprobado' ? ($requestForm->purchasingProcess ? $requestForm->purchasingProcess->getStatus() : 'En espera') : '',
    //         $requestForm->approved_at ? $requestForm->approved_at->format('d-m-Y H:i') : 'No se ha firmado Documento'
    //         // $dateSupplyEvent ? $dateSupplyEvent->signature_date->format('d-m-Y H:i') : 'No se ha firmado Documento'
    //     ];
    // }
}
