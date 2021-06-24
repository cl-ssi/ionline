<?php

namespace App\Http\Controllers\Rrhh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\User;
use App\Holiday;
use App\Models\Rrhh\ShiftTypes;
use App\Models\Rrhh\ShiftUser;
use App\Models\Rrhh\ShiftUserDay;
use App\Models\Rrhh\ShiftDayHistoryOfChanges;   
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

    private $groupsnames = array(
            '',
            'enfermeros',
            'tp4turno',
            'tp3turno',
            'auxiliares',
            'administrativos',
            'auxiliar de servicio TA',
    );
    public function index(Request $r, $groupname=null){
    	// echo "Shift Management";
        // echo "<h1>".$groupname."</h1>";
        $months = (object) $this->months;

        if(Session::has('days') && Session::get('days') != "")
            $days = Session::get('days');
        else
    	   $days = Carbon::now()->daysInMonth;

        if(Session::has('actuallyMonth') && Session::get('actuallyMonth') != "")
            $actuallyMonth = Session::get('actuallyMonth');
        else
            $actuallyMonth = Carbon::now()->format('m');

        if(Session::has('actuallyDay') && Session::get('actuallyDay') != "")
            $actuallyDay = Session::get('actuallyDay');
        else
            $actuallyDay = Carbon::now()->format('d');
        
        if(Session::has('actuallyYear') && Session::get('actuallyYear') != "")
            $actuallyYear = Session::get('actuallyYear');
        else
            $actuallyYear = Carbon::now()->format('Y');

        if(Session::has('sTypes') && Session::get('sTypes') != "")
            $sTypes = Session::get('sTypes');
        else
            $sTypes = ShiftTypes::all(); 

        if(Session::has('users') && Session::get('users') != "")
            $users = Session::get('users');
        else
    	   $users = User::Search($r->get('name'))->orderBy('name','Asc')->paginate(500);

        if(Session::has('cargos') && Session::get('cargos') != "")
            $cargos = Session::get('cargos');
        else
    	   $cargos = OrganizationalUnit::all();
        
        if(Session::has('actuallyOrgUnit') && Session::get('actuallyOrgUnit') != "")
            $actuallyOrgUnit = Session::get('actuallyOrgUnit');
        else    
            $actuallyOrgUnit = $cargos->first();

        if(Session::has('actuallyShift') && Session::get('actuallyShift') != "")
            $actuallyShift = Session::get('actuallyShift');
        else
            $actuallyShift=$sTypes->first();
        // Inicio groupname dinamico
        
        // Fin groupname dinamico

        // if(Session::has('staff') && Session::get('staff') != "")
        //     $staff = Session::get('staff');
        // else
            $staff = User::where('organizational_unit_id', $actuallyOrgUnit->id )->get();

        // if(Session::has('staffInShift') && Session::get('staffInShift') != "")
        //     $staffInShift = Session::get('staffInShift');
        // else
            // echo "H:".htmlentities($groupname);$this->groupsnames

        if($actuallyShift->id != 0){ // un turno en especifico

            $this->groupsnames = array(); 
            array_push($this->groupsnames, ""); //agregos los sin grupo

            // $groupsnames = array(); 
            foreach(ShiftUser::where('organizational_units_id', $actuallyOrgUnit->id )->where('shift_types_id',$actuallyShift->id)->groupBy("groupname")->get() as $g){
                    
                    array_push($this->groupsnames, $g->groupname);
                // echo json_encode($g->groupname);
            }

            $staffInShift = ShiftUser::where('organizational_units_id', $actuallyOrgUnit->id )->where('shift_types_id',$actuallyShift->id)->where('date_up','>=',$actuallyYear."-".$actuallyMonth."-".$days)->where('date_from','<=',$actuallyYear."-".$actuallyMonth."-".$days)->where('groupname',htmlentities($groupname))->get();
       
        }else{ // Todos los turnos

            //  $this->groupsnames = array(); 
            // foreach(ShiftUser::where('organizational_units_id', $actuallyOrgUnit->id )->groupBy("groupname")->get() as $g){
            //     array_push($this->groupsnames, $g);
            // }
           $staffInShift = ShiftUser::where('organizational_units_id', $actuallyOrgUnit->id )->where('date_up','>=',$actuallyYear."-".$actuallyMonth."-".$days)->where('date_from','<=',$actuallyYear."-".$actuallyMonth."-".$days)->where('groupname',htmlentities($groupname))->get();

        }
        // echo "SISH: ". $staffInShift;
        
        $months = $this->months;
        $ouRoots = OrganizationalUnit::where('level', 1)->get();
        $holidays = Holiday::all();
        
        $filter ="";
        Session::put('users',$users);
        Session::put('ouRoots',$ouRoots);
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

        Session::put('groupname',$groupname);

        // $dateFiltered = Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-".$actuallyDay, 'Europe/London');   
        if(!isset($groupname) || $groupname =="")
            $groupname = $this->groupsnames[0];
        $groupsnames =$this->groupsnames;
        return view('rrhh.shift_management.index', compact('users','cargos','sTypes','days','actuallyMonth','actuallyDay','actuallyYear','months','actuallyOrgUnit','staff','actuallyShift','staffInShift','filter','groupname','groupsnames','ouRoots','holidays'));
    }

 	public function indexfiltered(Request $r){
        
     
        // echo "filteresd";
        $months = (object) $this->months;
        $actuallyDay = Carbon::now()->format('d');
        $sTypes = ShiftTypes::all(); 
        $cargos = OrganizationalUnit::all();
        $filter = "on";

        $dateFiltered = Carbon::createFromFormat('Y-m-d',  $r->yearFilter."-".$r->monthFilter."-".$actuallyDay, 'Europe/London');

        $days = $dateFiltered->daysInMonth;
        $actuallyMonth = $dateFiltered->format('m');
        $actuallyYear = $dateFiltered->format('Y');
        
        

         
        $actuallyOrgUnit =  OrganizationalUnit::find($r->orgunitFilter);
        $staff = User::where('organizational_unit_id', $actuallyOrgUnit->id )->get();

        // echo "4To:".htmlentities(Session::get('groupname'));
        if($r->turnFilter!=0){
            $actuallyShift=ShiftTypes::find($r->turnFilter);
            $staffInShift = ShiftUser::where('organizational_units_id', $actuallyOrgUnit->id )->where('shift_types_id',$actuallyShift->id)->where("groupname",htmlentities(Session::get('groupname')) )->get();
        } else {
             $actuallyShift=  (object) array('id' =>0,'name'=>"Todos" );
            $staffInShift = ShiftUser::where('organizational_units_id', $actuallyOrgUnit->id )->get();
        }

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
        
        return redirect()->route('rrhh.shiftManag.index',["groupname"=>Session::get('groupname')]);

            // return redirect('/rrhh/shift-management/'.Session::get('groupname'));

        // return view('rrhh.shift_management.index', compact('cargos','sTypes','days','actuallyMonth','actuallyDay','actuallyYear','months','actuallyOrgUnit','staff','actuallyShift','staffInShift','filter'));
 	}

 	public function shiftstypesindex(){
        // return view('rrhh.shift_management.shiftstypes', compact('users'));
        $sTypes = ShiftTypes::all(); 
        // $sTypes = 1;
        return view('rrhh.shift_management.shiftstypes', compact('sTypes'));
    }

    public function editshifttype(Request $r){	

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
        $nShift->groupname = htmlentities($r->groupname);
        $nShift->save();
        // echo "staff assigned to shift";
        $nUser = User::find($nShift->user_id);
        $ranges = CarbonPeriod::create($nShift->date_from, $nShift->date_up);
        $actuallyShift = ShiftTypes::find( $r->shiftId );
        $currentSeries =  explode(",", $actuallyShift->day_series); 
        $i = 0;
        foreach ($ranges as $date) {


                $nShiftD = new ShiftUserDay;
                $nShiftD->day = $date->format('Y-m-d');
                $nShiftD->status = 1;//assgined
               

                if(isset($currentSeries[$i]) && $currentSeries[$i] != ""){
                    $nShiftD->working_day = $currentSeries[$i]; 
                    // echo "if";

                }
                else{
                    // echo "else";
                    while( !isset($currentSeries[$i])  ||  (isset($currentSeries[$i]) && $currentSeries[$i] == "") ){
                       // echo "currentSeries[i]:".$currentSeries[$i]."<br>";
                        if(isset($currentSeries[$i]) && $currentSeries[$i] != "")
                            $previous = $currentSeries[$i];
                        if( $i <  ( sizeof($currentSeries) - 1) ){
                            $i++;
                        }else{
                            $i=0;
                        }
                    }
                    if(isset($currentSeries[$i]) && $currentSeries[$i] != "")
                        $nShiftD->working_day = $currentSeries[$i]; 
                    else
                         $nShiftD->working_day =$previous;

                }
                $nShiftD->commentary = "// Automatically added by the shift ".$nShift->id."//"; 
                $nShiftD->shift_user_id = $nShift->id;
                $nShiftD->save();

                $nHistory = new ShiftDayHistoryOfChanges;
                $nHistory->commentary = "El usuario \"".Auth()->user()->name." ". Auth()->user()->fathers_family." ". Auth()->user()->mothers_family."\" ha <b>asignado la jornada</b> del \"".$date->format('Y-m-d')."\" de tipo  \"".$nShiftD->working_day."\" al usuario ID: \"". $nUser->runFormat() ."\" - ".$nUser->name." ".$nUser->fathers_family." ".$nUser->mothers_family;
                $nHistory->shift_user_day_id = $nShiftD->id;
                $nHistory->modified_by = Auth()->user()->id;
                $nHistory->change_type = 0;//0_asignado 1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario
                $nHistory->day =  $date->format('Y-m-d');
                $nHistory->previous_value = "";
                $nHistory->current_value = "1";
                $nHistory->save();
           
            if( $i <  ( sizeof($currentSeries) - 1) ){
                $i++;
            }else{
                $i=0;
            }
        }
            return redirect('/rrhh/shift-management/'.Session::get('groupname'));
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

    public function goToNextMonth(){

        if(Session::get('actuallyMonth')){
            if(Session::get("actuallyMonth") != 12){

                $nMonth  = intval(Session::get('actuallyMonth')) + 1;
                
                
            }else{
                $nMonth = 1;
            }
                $dateFormat = Carbon::createFromFormat('Y-m-d',  "2021-".$nMonth."-01", 'Europe/London');
                $nMonth = $dateFormat->format('m');
                Session::put('actuallyMonth',$nMonth);
                

        }
        return redirect()->route('rrhh.shiftManag.index',["groupname"=>Session::get("groupname") ]);
    }

    public function goToPreviousMonth(){
        
        if(Session::get('actuallyMonth')){
            if(Session::get("actuallyMonth") != 1 ) {  

                $pMonth  = intval(Session::get('actuallyMonth')) - 1;
            }else{
                
                $pMonth = 12;
            }
            $dateFormat = Carbon::createFromFormat('Y-m-d',  "2021-".$pMonth."-01", 'Europe/London');
            $pMonth = $dateFormat->format('m');
            Session::put('actuallyMonth',$pMonth);

        }
                
        return redirect()->route('rrhh.shiftManag.index',["groupname"=>Session::get("groupname") ]);
    }

    public function downloadShiftControlInPdf(Request $r){
        // header("Content-type:application/pdf");
        // $filename = "test";
        // header("Content-Disposition:inline;filename='$filename");
        // echo "download ".$r->days;
        $days= 0;
        $dateFiltered = Carbon::createFromFormat('Y-m-d',  $r->actuallyYears."-".$r->actuallyMonth."-01", 'Europe/London');
        $days = $dateFiltered->daysInMonth;

        $actuallyYears =$r->actuallyYears;
        $actuallyMonth  = $r->actuallyMonth;
        $actuallyUser =  $r->actuallyUser ;

        $actuallyOrgUnit = $r->actuallyOrgUnit;
        // $actuallyUser = explode();$actuallyUser[0];
        // $actuallyUser =  str_replace("}","", $actuallyUser);

        // $actuallyUser =  str_replace('"',"", $actuallyUser[0]);
        
        $usr = User::find($actuallyUser->id);
        // $shifsUsr = ShiftUser::where('date_up','>=',$actuallyYears."-".$actuallyMonth."-".$days)->where('date_from','<=',$actuallyYears."-".$actuallyMonth."-".$days)->where("user_id",$actuallyUser->id)->first();
        $shifsUsr = ShiftUser::where('date_up','>=',$actuallyYears."-".$actuallyMonth."-".$days)->where("user_id",$actuallyUser)->first();
      
        // dd($actuallyUser);

      return view('rrhh.shift_management.shift_control_form',['days'=>$days,'actuallyYears'=>$actuallyYears,'actuallyMonth'=>$actuallyMonth ,'shifsUsr'=>$shifsUsr,'usr'=>$usr  ]);

       // $pdf = app('dompdf.wrapper');
       //  $pdf->loadView('rrhh.shift_management.shift_control_form',['days'=>$days,'actuallyYears'=>$actuallyYears,'actuallyMonth'=>$actuallyMonth ,'shifsUsr'=>$shifsUsr  ]);
       //  return $pdf->stream('mi-archivo.pdf');
    }

    public function myShift(){
        // echo "myShift";

        if(Session::has('days') && Session::get('days') != "")
            $days = Session::get('days');
        else
           $days = Carbon::now()->daysInMonth;

        if(Session::has('actuallyMonth') && Session::get('actuallyMonth') != "")
            $actuallyMonth = Session::get('actuallyMonth');
        else
            $actuallyMonth = Carbon::now()->format('m');

        if(Session::has('actuallyDay') && Session::get('actuallyDay') != "")
            $actuallyDay = Session::get('actuallyDay');
        else
            $actuallyDay = Carbon::now()->format('d');
        
        if(Session::has('actuallyYear') && Session::get('actuallyYear') != "")
            $actuallyYear = Session::get('actuallyYear');
        else
            $actuallyYear = Carbon::now()->format('Y');

        if(Session::has('sTypes') && Session::get('sTypes') != "")
            $sTypes = Session::get('sTypes');
        else
            $sTypes = ShiftTypes::all(); 

        if(Session::has('users') && Session::get('users') != "")
            $users = Session::get('users');
        else
           $users = "";//User::Search($r->get('name'))->orderBy('name','Asc')->paginate(500);

        $status = 4;    
        $userId = Auth()->user()->id;
        // echo "aut: ". Auth()->user()->id;
        //v1
        /* $myConfirmationEarrings = ShiftUserDay::where("shift_user_id",Auth()->user()->id)->whereHas("shiftUserDayLog", function($q) use($status){
                                           $q->where('change_type',$status);
                                         })->get(); */
        //v2
       /* $myConfirmationEarrings = ShiftUserDay::where("shift_user_id",Auth()->user()->id)->whereHas("ShiftUser",  function($q) use($userId){
                $q->where('shift_user_id',$userId);
            })->whereHas("shiftUserDayLog",  function($q) use($status){
                $q->where('change_type',$status);
            })->get();*/
        // $myConfirmationEarrings = ShiftUserDay::where("status",3)->whereHas("ShiftUser",  function($q) use($userId){
        //         $q->where('user_id',$userId);
        //     })->whereHas("shiftUserDayLog",  function($q) use($status){
        //         $q->without('change_type,"4');
        //     })->get();
        
        // $myConfirmationEarrings = ShiftUserDay::where("status",3)->whereHas("ShiftUser",  function($q) use($userId){
        //         $q->where('user_id',$userId);
        //     })->get();

        $myConfirmationEarrings = array();
        foreach (ShiftUserDay::where("status",3)->whereHas("ShiftUser",  function($q) use($userId){ // Busco todos los dias que esten en estado 3 que es turno extra,  
                $q->where('user_id',$userId);
            })->get() as $myChangeDay) 
            {
            // if(  $myChangeDay->whereHas("shiftUserDayLog",  function($q) use($status){
            //     $q->where('change_type',4);
            //         })   ){

            //    echo   json_encode( $myChangeDay->whereHas("shiftUserDayLog",  function($q) use($status){
            //     $q->where('change_type',1);
            //         }) );

            //     array_push($myConfirmationEarrings, $myChangeDay) ;
            // }
                // echo json_encode($myChangeDay->shiftUserDayLog);
                $confirmed= false;
                foreach ($myChangeDay->shiftUserDayLog as $history) {
                   if($history->change_type == 4 || $history->change_type == 5  || $history->change_type == 6) // 4 confirmado por usuario -  confirmado por administrador  - 6 reject
                        $confirmed= true;
                }
                if(!$confirmed)
                    array_push($myConfirmationEarrings, $myChangeDay) ;
            }
            $myConfirmationEarrings = (object) $myConfirmationEarrings;
        $months = $this->months;
        $tiposJornada = $this->tiposJornada;
         return view('rrhh.shift_management.my-shift',compact('days','actuallyMonth','actuallyDay','actuallyYear','sTypes','users','months','myConfirmationEarrings','tiposJornada'));
    }

    public function myShiftConfirm($day){

        $d = ShiftUserDay::find($day);
        echo "R".json_encode($d); 

        $nHistory = new ShiftDayHistoryOfChanges;
        $nHistory->commentary = "El usuario \"".Auth()->user()->name." ". Auth()->user()->fathers_family." ". Auth()->user()->mothers_family."\" ha <b>confirmado la jornada</b> del \"".$d->day;
        $nHistory->shift_user_day_id = $d->id;
        $nHistory->modified_by = Auth()->user()->id;
        $nHistory->change_type = 4;//0_asignado 1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario
        $nHistory->day =  $d->day;
        $nHistory->previous_value = "";
        $nHistory->current_value = "";
        $nHistory->save();
        
           session()->flash('success', 'Se ha confirmado el turno extra del dia '.$d->day);
        return redirect()->route('rrhh.shiftManag.myshift');
    }
      
    public function myShiftReject($day){
        $d = ShiftUserDay::find($day);
       // echo "C".json_encode($d); 

               $nHistory = new ShiftDayHistoryOfChanges;
        $nHistory->commentary = "El usuario \"".Auth()->user()->name." ". Auth()->user()->fathers_family." ". Auth()->user()->mothers_family."\" ha <b>rechazado la jornada</b> del \"".$d->day;
        $nHistory->shift_user_day_id = $d->id;
        $nHistory->modified_by = Auth()->user()->id;
        $nHistory->change_type = 6;//0_asignado 1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario
        $nHistory->day =  $d->day;
        $nHistory->previous_value = "";
        $nHistory->current_value = "";
        $nHistory->save();
        session()->flash('danger', 'Se ha rechazado el turno extra del dia '.$d->day);
        return redirect()->route('rrhh.shiftManag.myshift');
    }


    public function adminShiftConfirm($day){

        $d = ShiftUserDay::find($day);
        // echo "R".json_encode($day); 

        $nHistory = new ShiftDayHistoryOfChanges;
        $nHistory->commentary = "El administrador ha <b>confirmado la jornada</b> del \"".$d->day;
        $nHistory->shift_user_day_id = $d->id;
        $nHistory->modified_by = Auth()->user()->id;
        $nHistory->change_type = 5;//0_asignado 1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario
        $nHistory->day =  $d->day;
        $nHistory->previous_value = $d->status;
        $nHistory->current_value = $d->status;
        $nHistory->save();
        
        return redirect()->route('rrhh.shiftManag.index');
    }
      
}
