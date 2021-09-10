<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, ShouldAutoSize};
use App\Models\ServiceRequests\ServiceRequest;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Http\Request;


class ContractExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{

    // private $request;
    
    use Exportable;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }



    public function collection()
    {        
        
        
        // $srs = ServiceRequest::whereDate('start_date','<=',$request->from)
        // ->whereDate('end_date','>=',$request->to)
        // ->when($request->uo != null, function ($q) use ($request) {
        //   return $q->where('responsability_center_ou_id', $request->uo);
        // })
        // ->orderBy('start_date')
        // ->get();
        
        return 
        ServiceRequest::
        //whereDate('start_date','<=',$this->request->from)
        where('type','Covid')
        ->whereHas("SignatureFlows", function ($subQuery) {
            $subQuery->where('status','<>', 0);
          })
        ->whereDate('end_date','<=','2021-09-30')        
        ->orderBy('start_date')
        ->get();
    }


    public function headings(): array
    {
        return [
          'ID',
          'Tipo',
          'Origen Financiamiento',
          'Rut',
          'Nombre',
          'Dirección',
          'Unidad Organizacional',
          'Fecha Solicitud',
          'F.Inicio de Contrato',
          'F.Término de Contrato',
        ];
    }

    public function map($sr): array
    {
        return [
            $sr->id,
            $sr->program_contract_type??'',
            $sr->type?? '',
            $sr->id?$sr->employee->runFormat():'',
            $sr->employee->fullname?? '',
            $sr->employee->address?? '',
            $sr->responsabilityCenter->name,
            $sr->request_date?$sr->request_date->format('d-m-Y'):'',
            $sr->start_date ? $sr->start_date->format('d-m-Y'):'',
            $sr->end_date ? $sr->end_date->format('d-m-Y'): '',
        ];
    }
}