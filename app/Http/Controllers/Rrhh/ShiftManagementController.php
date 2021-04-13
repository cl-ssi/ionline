<?php

namespace App\Http\Controllers\Rrhh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\User;
use App\Models\Rrhh\ShiftTypes;
use App\Models\Rrhh\ShiftUser;
use App\Models\Rrhh\ShiftUserDay;
use App\Rrhh\OrganizationalUnit;
use App\Programmings\Professional;
use Spatie\Permission\Models\Role;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Session;


class ShiftManagementController extends Controller
{   


    private $months = array(

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

    private $tiposJornada = array(
            'F' => "Libre",
            'D' => "Dia",
            'L' => "Largo",
            'N' => "Noche"
    );

     public function index(Request $r)
    {
    	// echo "Shift Management";
        $months = (object) $this->months;


    	$days = Carbon::now()->daysInMonth;
        $actuallyMonth = Carbon::now()->format('m');
        $actuallyDay = Carbon::now()->format('d');
        $actuallyYear = Carbon::now()->format('Y');
        $sTypes = ShiftTypes::all(); 
    	$users = User::Search($r->get('name'))->orderBy('name','Asc')->paginate(500);
    	$cargos = OrganizationalUnit::all();
        $actuallyOrgUnit = $cargos->first();
        $actuallyShift=$sTypes->first();
        $staff = User::where('organizational_unit_id', $actuallyOrgUnit->id )->get();
        
        $staffInShift = ShiftUser::where('organizational_units_id', $actuallyOrgUnit->id )->get();

        Session::put('users',$users);
        Session::put('cargos',$cargos);
        Session::put('sTypes',$sTypes);
        Session::put('days',$days);
        Session::put('actuallyMonth',$actuallyMonth);
        Session::put('actuallyDay',$actuallyDay);
        Session::put('actuallyYear',$actuallyYear);
        Session::put('months',$months);
        Session::put('actuallyOrgUnit',$actuallyOrgUnit);
        Session::put('staff',$staff);
        Session::put('actuallyShift',$actuallyShift);
        Session::put('staffInShift',$staffInShift);

        // $dateFiltered = Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-".$actuallyDay, 'Europe/London');   

        return view('rrhh.shift_management.index', compact('users','cargos','sTypes','days','actuallyMonth','actuallyDay','actuallyYear','months','actuallyOrgUnit','staff','actuallyShift','staffInShift'));
    }
 	public function indexfiltered(Request $r){
        
     

        $months = (object) $this->months;
        $actuallyDay = Carbon::now()->format('d');
        $sTypes = ShiftTypes::all(); 
        $cargos = OrganizationalUnit::all();


        $dateFiltered = Carbon::createFromFormat('Y-m-d',  $r->yearFilter."-".$r->monthFilter."-".$actuallyDay, 'Europe/London');

        $days = $dateFiltered->daysInMonth;
        $actuallyMonth = $dateFiltered->format('m');
        $actuallyYear = $dateFiltered->format('Y');
        
        

        $actuallyShift=ShiftTypes::find($r->turnFilter);
         
        $actuallyOrgUnit =  OrganizationalUnit::find($r->orgunitFilter);
        $staff = User::where('organizational_unit_id', $actuallyOrgUnit->id )->get();
        $staffInShift = ShiftUser::where('organizational_units_id', $actuallyOrgUnit->id )->get();
        // $dateFiltered = Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-".$actuallyDay, 'Europe/London');   
        Session::put('cargos',$cargos);
        Session::put('sTypes',$sTypes);
        Session::put('days',$days);
        Session::put('actuallyMonth',$actuallyMonth);
        Session::put('actuallyDay',$actuallyDay);
        Session::put('actuallyYear',$actuallyYear);
        Session::put('months',$months);
        Session::put('actuallyOrgUnit',$actuallyOrgUnit);
        Session::put('staff',$staff);
        Session::put('actuallyShift',$actuallyShift);
        Session::put('staffInShift',$staffInShift);

        return view('rrhh.shift_management.index', compact('cargos','sTypes','days','actuallyMonth','actuallyDay','actuallyYear','months','actuallyOrgUnit','staff','actuallyShift','staffInShift'));

 	}
 	public function shiftstypesindex()
    {
        // return view('rrhh.shift_management.shiftstypes', compact('users'));
        $sTypes = ShiftTypes::all(); 
        // $sTypes = 1;
        return view('rrhh.shift_management.shiftstypes', compact('sTypes'));
    }
    public function editshifttype(Request $r)
    {	

    	$tiposJornada =   $this->tiposJornada;
        $sType = ShiftTypes::findOrFail($r->id); 
        return view('rrhh.shift_management.editshiftstype', compact('sType','tiposJornada'));

    }
    public function newshifttype(){
    	// echo "create";
        $tiposJornada =   $this->tiposJornada;
    	
        return view('rrhh.shift_management.createshifttype', compact('tiposJornada'));

    }
    public function storenewshift(Request $r){

        $nSType = new ShiftTypes; 
        $nSType->name = $r->name;
        $nSType->shortname = $r->shortname;
        $nSType->day_series = implode(",", $r->day_series);
        $nSType->save();
        session()->flash('info', 'El Turno tipo <i>"'.$r->name.'"</i> ha sido creado.');
        return redirect()->route('rrhh.shiftsTypes.index');

    }
    public function updateshifttype(Request $r){
    	// echo "updateshifttype ".implode(",", $r->day_series); 

    	$fSType = ShiftTypes::find($r->id);
    	$fSType->name = $r->name;
		$fSType->shortname = $r->shortname;
		$fSType->day_series = implode(",", $r->day_series);
		$fSType->update();
        session()->flash('info', 'El Turno tipo <i>"'.$r->name.'"</i> ha sido modificado.');
        return redirect()->route('rrhh.shiftsTypes.index');

    } 
    public function assignStaff(Request $r){
        $nShift = new ShiftUser;
        $nShift->date_from = $r->dateFromAssign;
        $nShift->date_up = $r->dateUpAssign;
        $nShift->asigned_by = Auth()->user()->id; 
        $nShift->user_id = $r->slcStaff;
        $nShift->shift_types_id = $r->shiftId;
        $nShift->organizational_units_id = $r->orgUnitId;
        $nShift->save();
        echo "staff assigned to shift";

        $ranges = CarbonPeriod::create($nShift->date_from, $nShift->date_up);
        $actuallyShift = ShiftTypes::find( $r->shiftId );
        $currentSeries =  explode(",", $actuallyShift->day_series); 
        $i = 0;
        foreach ($ranges as $date) {
            $nShiftD = new ShiftUserDay;
            $nShiftD->day = $date->format('Y-m-d');
            $nShiftD->status = 1;//assgined
            $nShiftD->working_day = $currentSeries[$i]; 
            $nShiftD->commentary = "// Automatically added by the shift ".$nShift->id."//"; 
            $nShiftD->shift_user_id = $nShift->id;
            $nShiftD->save();
            // echo $date->format('Y-m-d');
            if( $i <  ( sizeof($currentSeries) - 1) ){
                $i++;
            }else{
                $i=0;
            }
        }
    }

    public function downloadShiftInXls(Request $r){


        $users = Session::get('users');
        $cargos = Session::get('cargos');
        $sTypes = Session::get('sTypes');
        $days = Session::get('days');
        $actuallyMonth = Session::get('actuallyMonth');
        $actuallyDay = Session::get('actuallyDay');
        $actuallyYear = Session::get('actuallyYear');
        $months = $this->months;
        $actuallyOrgUnit = Session::get('actuallyOrgUnit');
        $staff = Session::get('staff');
        $actuallyShift = Session::get('actuallyShift');
        $staffInShift = Session::get('staffInShift');
        // Session::flush();
        


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1',  strtoupper($months[$actuallyMonth]).' '.$actuallyYear);
        if($days==28)
            $sheet->MergeCells('A1:AE1');
        elseif($days==29)
            $sheet->MergeCells('A1:AF1');
        elseif($days==30)
            $sheet->MergeCells('A1:AG1');
        elseif($days==31)
            $sheet->MergeCells('A1:AH1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        $sheet->setCellValue('A2', 'CARGO');
        $sheet->setCellValue('B2', '');
        $index = 67;
        $index2 = 65;
        $cell = "";
        for ($i=1; $i < ($days+1) ; $i++) { 
           
            if($index<91){
                $cell = chr($index);
                $index++;
            }  else{
                $cell = "A".chr($index2);
                $index2++;
            }
            $sheet->setCellValue($cell."2", $i);
            $sheet->getColumnDimension($cell)->setAutoSize(true);
        }   



        $sheet->getStyle('A1:AH1')->applyFromArray(
                array(
                    'font' => array(
                    'bold' => true
                    )
                )
            );
        $sheet->getStyle('A2:AH2')->applyFromArray(
                array(
                    'font' => array(
                    'bold' => true
                    )
                )
            );
        $i=3;
        $staffType="Titular";
        foreach ($staffInShift as $sis) {
            $sheet->setCellValue("A".$i, $sis->user->runFormat()." - ".$sis->user->name." ".$sis->user->fathers_family);
             $sheet->setCellValue("B".$i, $staffType);
            $index = 67;// lleter C in ascii
            $index2 = 65; //letter A in ascii
            $cell = "";
            for ($j=1; $j < ($days+1) ; $j++) { 
           
                if($index<91){
                    $cell = chr($index);
                    $index++;
                }  else{
                    $cell = "A".chr($index2);
                    $index2++;
                }
                $date = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-".$j);
                $date =explode(" ",$date);
                $d = $sis->days->where('day',$date[0]);

                $sheet->setCellValue($cell.$i, 
                ( ( isset($d) && count($d) )? ( ($d->first()->working_day!="F")?$d->first()->working_day:"-" ) :"n/a" )
                 );
                $sheet->getColumnDimension($cell)->setAutoSize(true);
            }   
            $i++;
            
        }

         $sheet->getColumnDimension("A")->setAutoSize(true);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="turnos20210413-113325.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

    }
}
