<?php

namespace App\Livewire\Rrhh\PerformanceReport;

use Livewire\Component;
use App\Models\User;
use App\Models\Rrhh\PerformanceReportPeriod;
use App\Models\Rrhh\PerformanceReport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Documents\Approval;
use App\Notifications\Rrhh\NewPerformanceReport;

class SubmittedReport extends Component
{


    public $users;
    public $organizationalUnit;
    public $year;
    public $periods;
    public $selectedUserData;
    public $selectedUser = null;
    public $selectedPeriod = null;
    public $cantidad_de_trabajo;
    public $conocimiento_del_trabajo;
    public $interes_por_el_trabajo;
    public $calidad_del_trabajo;
    public $capacidad_trabajo_en_grupo;
    public $asistencia;
    public $puntualidad;
    public $cumplimiento_normas_e_instrucciones;
    public $creator_user_observation;
    public $reportDetails = null;


    

    public function mount()
    {
        $loggedInUser = auth()->user();
        $this->organizationalUnit = $loggedInUser->organizationalUnit->name;
        $this->users = User::whereHas('contracts')
        ->where('organizational_unit_id', $loggedInUser->organizational_unit_id)
        ->where('id', '!=', $loggedInUser->id)
        ->orderBy('name')
        ->get();

                // Obtener el año seleccionado
        // Obtener el año seleccionado
        $year = $this->year ?? now()->year;
        $this->periods = PerformanceReportPeriod::where('year', $year)->get();
        $this->periods = $this->periods->sortBy('start_at');
        $this->selectedUser = null;
        $this->selectedPeriod = null;
    }


    public function render()
    {
        return view('livewire.rrhh.performance-report.submitted-report');
    }

    public function showForm($userId, $periodId)
    {
        $this->selectedUser = User::find($userId);
        $this->selectedPeriod = PerformanceReportPeriod::find($periodId);
    }

    public function showModal($userId, $periodId)
    {
        $this->selectedUser = User::find($userId);
        $this->selectedPeriod = PerformanceReportPeriod::find($periodId);
        $this->reportDetails = PerformanceReport::where('received_user_id', $userId)
            ->where('period_id', $periodId)
            ->first();
    }



    public function saveReport()
    {
        $validatedData = $this->validate([
            'cantidad_de_trabajo' => 'required',
            'calidad_del_trabajo' => 'required',
            'conocimiento_del_trabajo' => 'required',
            'interes_por_el_trabajo' => 'required',
            'capacidad_trabajo_en_grupo' => 'required',
            'asistencia' => 'required',
            'puntualidad' => 'required',
            'cumplimiento_normas_e_instrucciones' => 'required',
        ]);
    
        $report = new PerformanceReport();
        $report->period_id = $this->selectedPeriod->id;
        $report->cantidad_de_trabajo = $this->cantidad_de_trabajo;
        $report->calidad_del_trabajo = $this->calidad_del_trabajo;
        $report->conocimiento_del_trabajo = $this->conocimiento_del_trabajo;
        $report->interes_por_el_trabajo = $this->interes_por_el_trabajo;
        $report->capacidad_trabajo_en_grupo = $this->capacidad_trabajo_en_grupo;
        $report->asistencia = $this->asistencia;
        $report->puntualidad = $this->puntualidad;
        $report->cumplimiento_normas_e_instrucciones = $this->cumplimiento_normas_e_instrucciones;
        $report->creator_user_observation = $this->creator_user_observation;
        // Asignar los demás valores del formulario
        $report->created_user_id = auth()->user()->id;
        $report->created_ou_id = auth()->user()->organizational_unit_id;
        $report->received_user_id = $this->selectedUser->id;
        $report->received_ou_id = $this->selectedUser->organizational_unit_id;
        $report->save();
        $this->resetFormFields();


        $approval = Approval::withoutEvents(function () use ($report) {
            return $report->approvals()->create([
           "module"        => "Calificaciones",
            "module_icon"   => "bi bi-graph-up-arrow",
            "subject"       => "Reporte de Calificación de funcionario: ".$report->receivedUser->tinyName,
            "document_route_name" => "rrhh.performance-report.show",
            "document_route_params"             => json_encode
            ([
                "userId" => $report->received_user_id,
                "periodId"                    => $report->period_id,
            ]),
            "sent_to_user_id" => $report->created_user_id,
            "approver_id" => $report->created_user_id,
            "approver_ou_id" => $report->created_ou_id,
            "approver_at" => $report->created_at,
            "status"        => 1,
            "digital_signature"                 => false,
            "position"      => "left",
            "active"    =>false
            ]);
        });


        // $approval = Approval::create
        

        // $approval = $report->approvals()->Create([
        //     "module"        => "Calificaciones",
        //     "module_icon"   => "bi bi-graph-up-arrow",
        //     "subject"       => "Reporte de Calificación de funcionario: ".$report->receivedUser->tinyName,
        //     "document_route_name" => "rrhh.performance-report.show",
        //     "document_route_params"             => json_encode
        //     ([
        //         "userId" => $report->received_user_id,
        //         "periodId"                    => $report->period_id,
        //     ]),
        //     "sent_to_user_id" => $report->created_user_id,
        //     "approver_id" => $report->created_user_id,
        //     "approver_ou_id" => $report->created_ou_id,
        //     "approver_at" => $report->created_at,
        //     "status"        => 1,
        //     "digital_signature"                 => false,
        //     "position"      => "left",
        //     "active"    =>false
        // ]);

        $report->approvals()->Create([
            "module"        => "Calificaciones",
            "module_icon"   => "bi bi-graph-up-arrow",
            "subject"       => "Reporte de Calificación de funcionario: ".$report->receivedUser->tinyName,
            "document_route_name" => "rrhh.performance-report.show",
            "document_route_params"             => json_encode
            ([
                "userId" => $report->received_user_id,
                "periodId"                    => $report->period_id,
            ]),
            "sent_to_user_id" => $report->received_user_id,
            "digital_signature"                 => false,
            "position"      => "right",            
            "previous_approval_id"  => $approval->id,
            "active"    => true
        ]);

        

        
            if($report->receivedUser && $report->receivedUser->email != null){
                $report->receivedUser->notify(new NewPerformanceReport($report));
            } 
        

        $this->mount();
        session()->flash('success', 'Informe de desempeño guardado exitosamente');
    }
    
    

    private function resetFormFields()
    {
        $this->cantidad_de_trabajo = '';
        $this->calidad_del_trabajo = '';
        $this->conocimiento_del_trabajo = '';
        $this->interes_por_el_trabajo = '';
        $this->capacidad_trabajo_en_grupo = '';
        $this->asistencia = '';
        $this->puntualidad = '';
        $this->cumplimiento_normas_e_instrucciones = '';
        $this->selectedUser = null;
        $this->selectedPeriod = null; 
    }

    public function hasExistingReport($userId, $periodId)
    {
        return PerformanceReport::where('received_user_id', $userId)
            ->where('period_id', $periodId)
            ->exists();
    }

    public function deleteReport($userId, $periodId)
    {
        $report = PerformanceReport::where('received_user_id', $userId)
            ->where('period_id', $periodId)
            ->first();
    
        if ($report) {
            // Verificar si todos los aprobadores han aprobado el informe
            if ($report->allApprovalsOk()) {
                session()->flash('success', 'No se puede eliminar el informe de desempeño, ya que el funcionario tomó conocimiento');
            } else {
                $report->delete();
                session()->flash('success', 'Informe de desempeño eliminado exitosamente');
            }
        }
    }
    

    public function viewReport($userId, $periodId)
    {
        $this->reportDetails = PerformanceReport::where('received_user_id', $userId)
            ->where('period_id', $periodId)
            ->first();
    }
    

    public function closeReport()
    {
        $this->reportDetails = null;
    }


    public function show($userId, $periodId)
    {
        $report = PerformanceReport::where('received_user_id', $userId)
        ->where('period_id', $periodId)
        ->first();

        $establishment = $report->createdUser->organizationalUnit->establishment;
        
        return Pdf::loadView('rrhh.performance_report.show', [
            'report' => $report,
            'establishment' => $establishment,
        ])->stream('download.pdf');


        // return Pdf::loadView('documents.templates.'.$document->viewName, [
        //     'document' => $document
        // ])->stream('download.pdf');

        // return view('finance.receptions.show', compact('reception'));
    }




    
    




}
