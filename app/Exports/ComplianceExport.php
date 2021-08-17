<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, ShouldAutoSize};
use App\Models\ServiceRequests\Fulfillment;
use Illuminate\Http\Request;


class ComplianceExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{

    // private $request;
    // public function __construct(Request $request)
    // {
    //     $this->request = $request;
    // }



    public function collection()
    {
        
        return Fulfillment::
        whereHas('ServiceRequest')
        ->orderBy('id','Desc')->get();
        //return $this->fulfillment->all();
    }


    public function headings(): array
    {
        return [
          'ID',
          'Rut',
          'Nombre',
          'Unidad',
          'Periodo',
          'Tipo',
          'Tipo de Contrato',
          'Tipo de Jornada',
        ];
    }

    public function map($fulfillment): array
    {
        return [
            $fulfillment->id,
            ($fulfillment->servicerequest)?$fulfillment->servicerequest->employee->runFormat(): '',
            ($fulfillment->servicerequest->employee)? strtoupper($fulfillment->servicerequest->employee->fullname) : '',
            $fulfillment->servicerequest->responsabilityCenter->name,
            $fulfillment->year-$fulfillment->month,
            $fulfillment->servicerequest->type,
            $fulfillment->servicerequest->program_contract_type,
            $fulfillment->servicerequest->working_day_type            
        ];
    }
}