<?php

namespace App\Exports\RequestForms;

use App\Models\RequestForms\RequestForm;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Http\Request;
use Livewire\Component;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RequestFormsExport implements FromCollection, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;

    public function __construct(Collection $resultSearch)
    {
        // dd($resultSearch);
        $this->resultSearch = $resultSearch;
    }

    public function collection()
    {
        return $this->resultSearch;
    }

    public function headings(): array
    {
        return [
          'ID',
          'Estado',
          'Folio',
          'Depende de folio',
          'Fecha Creación',
          'Tipo / Mecanismo de Compra',
          'Descripción',
          'Programa',
          'Usuario Gestor',
          'Comprador',
          'Items',
          '',
          'Presupuesto',
          'Estado Proceso compra'
        ];
    }

    public function map($requestForm): array
    {
        return [
            $requestForm->id,
            $requestForm->getStatus(),
            $requestForm->folio,
            $requestForm->father ? $requestForm->father->folio : '',
            $requestForm->created_at->format('d-m-Y H:i'),
            ($requestForm->purchaseMechanism ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '').' '.$requestForm->SubtypeValue,
            $requestForm->name,
            $requestForm->program,
            ($requestForm->user ? $requestForm->user->FullName : 'Usuario eliminado').' '.($requestForm->userOrganizationalUnit ? $requestForm->userOrganizationalUnit->name : 'UO eliminado'),
            $requestForm->purchasers->first()->FullName ?? 'No asignado',
            $requestForm->quantityOfItems(),
            $requestForm->symbol_currency,
            number_format($requestForm->estimated_expense,$requestForm->precision_currency,".",""),
            $requestForm->getStatus() == 'Aprobado' ? ($requestForm->purchasingProcess ? $requestForm->purchasingProcess->getStatus() : 'En espera') : '',
        ];
    }
}
