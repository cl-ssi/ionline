<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use Carbon\Carbon;
use App\User;
class ModalShiftControlForm extends Component
{	
	public $userModal;
	public $actuallyMonth;
	public $actuallyYears;
	public $days;
	public $log;
    public $months = array(

        '01'=>'Enero',
        '02'=>'Febrero',
        '03'=>'Marzo',
        '04'=>'Abril',
        '05'=>'Mayo',
        '06'=>'Junio',
        '07'=>'Julio',
        '08'=>'Agosto',
        '09'=>'Septiembre',
        '10'=>'Octubre',
        '11'=>'Noviembre',
        '12'=>'Diciembre',
    );
 	public $listeners = ["setValueToShiftForm"=>"setModalValue"];
    public function mount(){

    	$userModal = 0;
		$actuallyMonth = 0;
		$actuallyYears = 0;
		$days = 0;
		$log = 0;

    }
    
    public function downloadShiftControlForm(){
		// echo json_encode("module" );
		// $signer = auth()->user();
        // $pdf = app('dompdf.wrapper');
        // $userModal = $this->userModal;
        // $pdf->loadView('rrhh.shift_management.shift_control_form',compact('userModal','signer'));

        // return $pdf->stream('mi-archivo.pdf');

  		//       $pdfContent = PDF::loadView('view', $viewData)->output();
		// return response()->streamDownload(
  		//    		fn () => print($pdfContent),
  		//    		"filename.pdf"
		// );
		$this->log ="enter";
     //    $pdf = PDF::loadView('rrhh.shift_management.shift_control_form');
    	// return response()->streamDownload(function () use ($pdf) {
     //    	echo $pdf->stream();
    	// }, 'invoice.pdf'); 

	}
	public function setModalValue($actuallyYears,$actuallyMonth,$usr,$days){
		
		$this->actuallyYears = $actuallyYears;
		$this->actuallyMonth = $actuallyMonth;
		$this->userModal = $userModal;


		$dateFiltered = Carbon::createFromFormat('Y-m-d',  $this->actuallyYears."-".$this->actuallyMonth."-01", 'Europe/London');
		$this->userModal = User::find($this->userModal);
        $this->days = $dateFiltered->daysInMonth;
	}
	public function cancel(){
		$this->days = 0;

	}
    public function render()
    {
        return view('livewire.rrhh.modal-shift-control-form');
    }
}
