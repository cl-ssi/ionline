<?php

namespace App\Exports\ServiceRequest;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\ServiceRequests\ServiceRequest;
use Illuminate\Support\Collection;

class ConsolidatedReport implements FromCollection, WithTitle, WithHeadings
{
    protected $establishment_id;
    protected $year;
    protected $semester;

    public function __construct($establishment_id, $year, $semester)
    {
        $this->establishment_id = $establishment_id;
        $this->year = $year;
        $this->semester = $semester;
    }

    public function collection()
    {
        set_time_limit(7200);
        ini_set('memory_limit', '2048M');

        $establishment_id = $this->establishment_id;
        $year = $this->year;
        $semester = $this->semester;

        $serviceRequests = ServiceRequest::whereDoesntHave("SignatureFlows", function ($subQuery) {
            $subQuery->where('status', 0);
            })
            // ->when($establishment_id == 38, function ($q) {
            //     return $q->whereNotIn('establishment_id', [1, 41]);
            // })
            ->when($establishment_id != 38, function ($q) use ($establishment_id) {
                return $q->where('establishment_id',$establishment_id);
            })
            ->whereYear('start_date',$year)
            ->whereMonth('start_date',$semester)
            ->with('SignatureFlows','shiftControls','fulfillments','establishment','employee','profession','responsabilityCenter')
            ->orderBy('request_date', 'asc')
            ->get();

        
        $array = array();
        foreach($serviceRequests as $key => $serviceRequest){
            foreach($serviceRequest->fulfillments as $key2 => $fulfillment){
                $sirh_code="";
                $establishment_name = "";
                $profession = "";
                $birthday = "";
                $estamento = "";
                $apoyo = "";
                $sirh_contract_registration = "";
                $resolution_number_status = "";
                $resolution_number = "";
                $total_paid = "";
                $payment_date = "";
                $sr_status = "";

                if($serviceRequest->establishment){$sirh_code=$serviceRequest->establishment->sirh_code;}
                if($serviceRequest->establishment){$establishment_name = $serviceRequest->establishment->name;}
                if($serviceRequest->employee->birthday){
                    $birthday = $serviceRequest->employee->birthday->format('d-m-Y');
                }
                if($serviceRequest->profession){
                    $profession = $serviceRequest->profession->name . "-" . $serviceRequest->working_day_type;
                }else{
                    $profession = $serviceRequest->rrhh_team;
                }
                if($serviceRequest->profession){
                    $estamento = $serviceRequest->profession->estamento;
                    if($serviceRequest->profession->category == "E" || $serviceRequest->profession->category == "F"){
                        $apoyo = 'Apoyo Administrativo';
                    }else{
                        $apoyo = 'Apoyo Clínico';
                    }
                }else{
                    $estamento = $serviceRequest->estate;
                    if($serviceRequest->estate == "Administrativo"){
                        $apoyo = 'Apoyo Administrativo';
                    }else{
                        $apoyo = 'Apoyo Clínico';
                    }
                }
                if($serviceRequest->sirh_contract_registration === 1){$sirh_contract_registration = 'Sí';}
                elseif($serviceRequest->sirh_contract_registration === 0){$sirh_contract_registration = 'No';}
                if($serviceRequest->resolution_number){$resolution_number_status = 'Sí';}else{$resolution_number_status = 'No';}
                if($serviceRequest->resolution_number){$resolution_number = $serviceRequest->resolution_number;}else{$resolution_number = 'En trámite';}
                if($fulfillment->total_paid){$total_paid = $fulfillment->total_paid;}else{$total_paid = 'En proceso de pago';}
                if($fulfillment->payment_date){$payment_date = $fulfillment->payment_date->format('Y-m-d');}
                if($serviceRequest->SignatureFlows->where('status','===',0)->count()){$sr_status = 'Rechazada';}
                elseif($serviceRequest->SignatureFlows->whereNull('status')->count() > 0){$sr_status = 'Pendiente';}
                else{$sr_status = 'Finalizada';}

                $array[] = [
                    $serviceRequest->id,
                    $serviceRequest->contract_number,
                    $fulfillment->MonthOfPayment(),
                    12,
                    'SERVICIO DE SALUD DE IQUIQUE',
                    $sirh_code,
                    $establishment_name,
                    $serviceRequest->employee->runNotFormat(),
                    $serviceRequest->employee->fullName,
                    $birthday,
                    $serviceRequest->employee->country->name,
                    $serviceRequest->employee->phone_number,
                    $serviceRequest->employee->email,
                    $serviceRequest->programm_name,
                    $serviceRequest->digera_strategy,
                    $profession,
                    $serviceRequest->weekly_hours,
                    $serviceRequest->responsabilityCenter->name,
                    $estamento, 
                    $apoyo,
                    $serviceRequest->gross_amount,
                    $sirh_contract_registration,
                    $resolution_number_status,
                    $resolution_number,
                    $serviceRequest->start_date->format('d-m-Y'),
                    $serviceRequest->end_date->format('d-m-Y'),
                    $fulfillment->bill_number,
                    $fulfillment->total_hours_paid,
                    $total_paid,
                    $payment_date,
                    $serviceRequest->program_contract_type,
                    $sr_status,
                    $serviceRequest->working_day_type,
                    $serviceRequest->type,
                    $fulfillment->quit_status()
                ];
            }
        }
        
        $array = collect($array);
        return $array;

        return $serviceRequests;
    }

    public function title(): string
    {
        return 'REPORTE CONSOLIDADO';
    }

    // public function startCell(): string
    // {
    //     return 'B8';
    // }

    public function headings(): array
    {
        return  ['ID','N° CONTRATO','MES PAGO','COD. SIRH S.S.','SERVICIO DE SALUD','COD EST.','ESTABLECIMIENTO','RUT','APELLIDOS Y NOMBRES','FEC NAC.',
                'NACIONALIDAD','TELEFONO','CORREO','NOMBRE DEL PROGRAMA SIRH','ESTRATEGIA DIGERA COVID','EQUIPO RRHH','HORAS SEMANALES CONTRATADAS','UNIDAD','ESTAMENTO',
                'FUNCIÓN','MONTO BRUTO','CONTRATO REGISTRADO EN SIRH','RESOLUCIÓN TRAMITADA','N° RESOLUCIÓN','FECHA INICIO','FECHA TÉRMINO','BOLETA Nº',
                'TOTAL HORAS PAGADAS PERIODO','TOTAL PAGADO','FECHA PAGO','T.CONTRATO','ESTADO.SOLICITUD','JORNADA TRABAJO','TIPO','RENUNCIA'];
    }


    // public function map($serviceRequests): array
    // {
    //     dd($serviceRequests);
    //     return [
    //         $serviceRequests[0]
            
    //     ];
    // }
}
