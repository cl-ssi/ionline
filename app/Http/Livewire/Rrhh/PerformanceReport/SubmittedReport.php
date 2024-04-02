<?php

namespace App\Http\Livewire\Rrhh\PerformanceReport;

use Livewire\Component;
use App\User;
use App\Models\Rrhh\PerformanceReportPeriod;
use App\Models\Rrhh\PerformanceReport;
use Barryvdh\DomPDF\Facade\Pdf;

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
        // Asignar los demás valores del formulario
        $report->created_user_id = auth()->user()->id;
        $report->created_ou_id = auth()->user()->organizational_unit_id;
        $report->received_user_id = $this->selectedUser->id;
        $report->received_ou_id = $this->selectedUser->organizational_unit_id;
        $report->save();
    
        // Restablecer los campos del formulario después de guardar y mostrar un mensaje de éxito
        $this->resetFormFields();
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
            $report->delete();
            session()->flash('success', 'Informe de desempeño eliminado exitosamente');
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
