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
use App\Models\Rrhh\UserShiftTypeMonths;
use App\Models\Rrhh\ShiftDayHistoryOfChanges;  
use App\Models\Rrhh\UserRequestOfDay; 
use App\Models\Rrhh\ShiftDateOfClosing;
use App\Models\Rrhh\ShiftClose;
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
    private $monthsNumber = array(

        1=>'Enero',
        2=>'Febrero',
        3=>'Marzo',
        4=>'Abril',
        5=>'Mayo',
        6=>'Junio',
        7=>'Julio',
        8=>'Agosto',
        9=>'Septiembre',
        10=>'Octubre',
        11=>'Noviembre',
        12=>'Diciembre',
    );
    private $tiposJornada = array(
            'F' => "Libre",
            'D' => "Dia",
            'L' => "Largo",
            'N' => "Noche",
            "MD" => "Media jornada dia",
            "MN" => "Media jornada nocuturna",
            "MD2" => "Media jornada dia 2",
            "MN2" => "Media jornada nocuturna 2",
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
    private $weekMap = [
            0 => 'DOM',
            1 => 'LUN',
            2 => 'MAR',
            3 => 'MIE',
            4 => 'JUE',
            5 => 'VIE',
            6 => 'SAB',
    ];
    public $shiftStatus = array(
        1=>"asignado",
        2=>"completado",
        3=>"turno extra",
        4=>"cambio turno con",
        5=>"licencia medica",
        6=>"fuero gremial",
        7=>"feriado legal",
        8=>"permiso excepcional",
        9 => "Permiso sin goce de sueldo",
        10 => "Descanzo Compensatorio",
        11 => "Permiso Administrativo Completo",
        12 => "Permiso Administrativo Medio Turno Diurno",
        13 => "Permiso Administrativo Medio Turno Nocturno",
        14 => "Permiso a Curso",
        15 => "Ausencia sin justificar",
        16 => "Cambiado por necesidad de servicio",
    );   
    public $timePerDay = array(
       
        'L' => array("from"=>"08:00","to"=>"20:00","time"=>12),
        'N' => array("from"=>"20:00","to"=>"08:00","time"=>12),
        'D' => array("from"=>"08:00","to"=>"17:00","time"=>8),
        'F' => array("from"=>"","to"=>"","time"=>0),
        'MD' => array("from"=>"","to"=>"","time"=>0),
        'MN' => array("from"=>"","to"=>"","time"=>0),
        'MD2' => array("from"=>"","to"=>"","time"=>0),
        'MN2' => array("from"=>"","to"=>"","time"=>0),
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

     
        $staff = User::where('organizational_unit_id', $actuallyOrgUnit->id )->get();

  
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

          
           $staffInShift = ShiftUser::where('organizational_units_id', $actuallyOrgUnit->id )->where('date_up','>=',$actuallyYear."-".$actuallyMonth."-".$days)->where('date_from','<=',$actuallyYear."-".$actuallyMonth."-".$days)->where('groupname',htmlentities($groupname))->get();

        }
        // echo "SISH: ". $staffInShift;
        
        $months = $this->months;
        $ouRoots = OrganizationalUnit::where('level', 1)->get();
        $holidays = Holiday::all();
        $actuallyShiftMonthsList = array();
        foreach($sTypes as $sType){
            //Nuevo filtrar por mes cada serie por usuario
            $actuallyShiftMonths = UserShiftTypeMonths::where("user_id",Auth()->user()->id)->where("shift_type_id",$sType->id)->get();
            if( !isset($actuallyShiftMonths) || $actuallyShiftMonths =="" || sizeof($actuallyShiftMonths) < 1 ){
                $actuallyShiftMonths = array();
                for($i=1;$i<13;$i++){
                    $aMonth = (object) array("month" => $i,"user_id" =>Auth()->user()->id ,'shift_type_id' => $sType->id );
                    // $aMonth = (object) $actuallyShiftMonths;
                    array_push($actuallyShiftMonths,$aMonth);
                }
                // $actuallyShiftMonths = (object) $actuallyShiftMonths;

                array_push($actuallyShiftMonthsList,$actuallyShiftMonths);

            }else{

                array_push($actuallyShiftMonthsList,$actuallyShiftMonths);
            } 
        };
        $actuallyShiftMonthsList = (object) $actuallyShiftMonthsList;
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
        return view('rrhh.shift_management.index', compact('users','cargos','sTypes','days','actuallyMonth','actuallyDay','actuallyYear','months','actuallyOrgUnit','staff','actuallyShift','staffInShift','filter','groupname','groupsnames','ouRoots','holidays','actuallyShiftMonthsList'));
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
            if($r->turnFilter == 999){
                $actuallyShift = (object) array('id'=>99,'name' => "T.Personalizado",'shortname' =>"TP" ,'day_series' =>",,,,,," ,'status' =>1 );
            }else{

                $actuallyShift=ShiftTypes::find($r->turnFilter);

            }
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

 	public function shiftstypesindex(){ // pantalla principal tipos de series, 
        // return view('rrhh.shift_management.shiftstypes', compact('users'));
        $sTypes = ShiftTypes::all(); 
        // $sTypes = 1;
        return view('rrhh.shift_management.shiftstypes', compact('sTypes'));
    }

    public function editshifttype(Request $r){	

    	$tiposJornada =   $this->tiposJornada;
        $sType = ShiftTypes::findOrFail($r->id); 
        $idUser = Auth()->user()->id;
        $actuallyMonths = UserShiftTypeMonths::where("user_id",Auth()->user()->id)->where("shift_type_id",$r->id)->get();
        $months = (object) $this->months;
        // echo "MOnths : ".json_encode($actuallyMonths);
        if( !isset($actuallyMonths) || count($actuallyMonths ) <1  ){
            echo "if";
            $actuallyMonths = array();
            for($i=1;$i<13;$i++){

                $aMonth = (object) array('month' => $i,'user_id' =>Auth()->user()->id ,'shift_type_id' => $r->id );
              
                // $aMonth =  $actuallyMonths;

                array_push($actuallyMonths,$aMonth);

            }
            // $actuallyMonths = (object) $actuallyMonths;
        }
        return view('rrhh.shift_management.editshiftstype', compact('sType','tiposJornada','actuallyMonths','idUser','months'));
    }

    public function newshifttype(){
    	// echo "create";
        $tiposJornada =   $this->tiposJornada;
    	
        return view('rrhh.shift_management.createshifttype', compact('tiposJornada'));
    }

    public function storenewshift(Request $r){

        // dd($r->months);
        $nSType = new ShiftTypes; 
        $nSType->name = $r->name;
        $nSType->shortname = $r->shortname;
        $nSType->day_series = implode(",", $r->day_series);
        $nSType->save();

        for($i=0;$i<sizeof($r->months);$i++){
            $nUShiftTypesMonts = new UserShiftTypeMonths;
            $nUShiftTypesMonts->month =$r->months[$i] ;
            $nUShiftTypesMonts->user_id =  Auth()->user()->id; 
            $nUShiftTypesMonts->shift_type_id = $nSType->id;
            $nUShiftTypesMonts->save();
        }
        // session()->flash('info', 'El Turno tipo <i>"'.$r->name.'"</i> ha sido creado.');
        // return redirect()->route('rrhh.shiftsTypes.index');
    }

    public function updateshifttype(Request $r){
    	// echo "updateshifttype ".implode(",", $r->day_series); 

    	$fSType = ShiftTypes::find($r->id);
    	$fSType->name = $r->name;
		$fSType->shortname = $r->shortname;
		$fSType->day_series = implode(",", $r->day_series);
		$fSType->update();

        $actaullyMonths = UserShiftTypeMonths::where("user_id",Auth()->user()->id)->where("shift_type_id",$r->id)->get();
        foreach($actaullyMonths as $months){
            $months->delete();
        }
        for($i=0;$i<sizeof($r->months);$i++){
            $nUShiftTypesMonths = new UserShiftTypeMonths;
            $nUShiftTypesMonths->month =$r->months[$i] ;
            $nUShiftTypesMonths->user_id =  Auth()->user()->id; 
            $nUShiftTypesMonths->shift_type_id = $fSType->id;
            $nUShiftTypesMonths->save();
        }
        session()->flash('info', 'El Turno tipo <i>"'.$r->name.'"</i> ha sido modificado.');
        return redirect()->route('rrhh.shiftsTypes.index');
    } 

    public function assignStaff(Request $r){ // crea un shift user y le crea dias de acuerdo al sifttype
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
        $i = $r->initialSerie;
        if($r->shiftId != 99 ){ // si no es turno personalizado, agrego los dias segun las serie

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

        }

            return redirect('/rrhh/shift-management/'.Session::get('groupname'));
    }

    public function downloadShiftInXls(Request $r){// Funcion para descargar los turnos en formato excel


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
        $writer->save('php://output'); //funcion qe permite descarar la tabla con los turnos visibles actualmete
    }

    //function for move to the next month with arrow in shiftManagement.index
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
    //function for move to the previous month with arrow in shiftManagement.index
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

    //route for for download actually shift table in pdf formatm with button in right upper corner from shiftManagement.index
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

        $actuallyUser = User::find($r->actuallyUser);
        // $actuallyUser = str_replace('{"', " ",$actuallyUser);
        // $actuallyUser = str_replace("{","",$actuallyUser);
        // $actuallyUser =  explode (",",$actuallyUser );

        // dd( $actuallyUser );
        $actuallyOrgUnit = $r->actuallyOrgUnit;
        // $actuallyUser = explode();$actuallyUser[0];
        // $actuallyUser =  str_replace("}","", $actuallyUser);

        // $actuallyUser =  str_replace('"',"", $actuallyUser[0]);
        
        $usr = User::find($actuallyUser->id);
        // $shifsUsr = ShiftUser::where('date_up','>=',$actuallyYears."-".$actuallyMonth."-".$days)->where('date_from','<=',$actuallyYears."-".$actuallyMonth."-".$days)->where("user_id",$actuallyUser->id)->first();
        $shifsUsr = ShiftUser::where('date_up','>=',$actuallyYears."-".$actuallyMonth."-".$days)->where("user_id",$actuallyUser)->first();

        $shifsUsr = ShiftUser::where('date_up','>=',$actuallyYears."-".$actuallyMonth."-".$days)->where("user_id",$actuallyUser->id)->first();
      
        // dd($actuallyUser);
            $months = $this->months ;

        //  return view('rrhh.shift_management.shift_control_form',['days'=>$days,'actuallyYears'=>$actuallyYears,'actuallyMonth'=>$actuallyMonth ,'shifsUsr'=>$shifsUsr,'usr'=>$usr,'months'=>$months  ]);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('rrhh.shift_management.shift_control_form',['days'=>$days,'actuallyYears'=>$actuallyYears,'actuallyMonth'=>$actuallyMonth ,'shifsUsr'=>$shifsUsr,'usr'=>$usr,'months'=>$months  ,'timePerDay' =>$this->timePerDay,'shiftStatus' => $this->shiftStatus]);
        return $pdf->stream('mi-archivo.pdf');
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
        $nHistory->change_type = 4;//0_asignado 1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario;4:Confirmado por el usuario 5: confirmado por el administrador, 6:rechazado por usuario?
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
        $nHistory->change_type = 6;//0_asignado 1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario; 5: confirmado por el administrador, 6:rechazado por usuario?
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
        $nHistory->change_type = 5;//0_asignado 1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario; 5: confirmado por el administrador
        $nHistory->day =  $d->day;
        $nHistory->previous_value = $d->status;
        $nHistory->current_value = $d->status;
        $nHistory->save();
        
        return redirect()->route('rrhh.shiftManag.index');
    }
    
    public function closeShift(){ // direcciona a vista para cerrar los turnos, utilizado por rrhh del hospital.


        $ouRoots = OrganizationalUnit::where('level', 1)->get();
        $cargos = OrganizationalUnit::all();
        $months = $this->months;

        if(Session::has('actuallyYear') && Session::get('actuallyYear') != "")
            $actuallyYear = Session::get('actuallyYear');
        else
            $actuallyYear = Carbon::now()->format('Y');
        
        if(Session::has('actuallyOrgUnit') && Session::get('actuallyOrgUnit') != "")
            $actuallyOrgUnit = Session::get('actuallyOrgUnit');
        else    
            $actuallyOrgUnit = $cargos->first();

        if(Session::has('actuallyMonth') && Session::get('actuallyMonth') != "")
            $actuallyMonth = Session::get('actuallyMonth');
        else
            $actuallyMonth = Carbon::now()->format('m');

        if(Session::has('days') && Session::get('days') != "")
            $days = Session::get('days');
        else
           $days = Carbon::now()->daysInMonth;

        $staffInShift = ShiftUser::where('organizational_units_id', $actuallyOrgUnit->id )->where('date_up','>=',$actuallyYear."-".$actuallyMonth."-01")->where('date_from','<=',$actuallyYear."-".$actuallyMonth."-".$days)->get();

        // ShiftDateOfClosing
        // ShiftClose
        $cierreDelMes = ShiftDateOfClosing::where('close_date','<=',Carbon::now()->format('Y-m-d'))->latest()->first();
        if(isset($cierreDelMes) && $cierreDelMes !="" ){
            // echo "Cierre del mes econtrad";

        }else{
            $cierreDelMes = (object) array("user_id"=>1,"commentary"=>"","init_date"=>$actuallyYear."-".$actuallyMonth."-01","close_date"=>$actuallyYear."-".$actuallyMonth."-".$days);
        }

        $staffInShift = ShiftUser::where('organizational_units_id', $actuallyOrgUnit->id )->whereHas("days",  function($q) use($cierreDelMes){
                
                    $q->where('day','<=',$cierreDelMes->close_date)->where('day','>=',$cierreDelMes->init_date)->whereNull('shift_close_id'); // Para filtrar solo los dias de la unidad organizacional del usuario
            
            })->groupBy("user_id")->get(); // busco todos aqellos dias entre las fechas de cierre la unidad or qe  
        // hacer foreach y revisar quien se cierra
        $firstConfirmations = ShiftClose::whereNotNull("first_confirmation_date")->whereNull("close_date")->get();
        $closed= ShiftClose::whereNotNull("close_date")->get();
        $cierres = ShiftDateOfClosing::all();
        // foreach ($staffInShift as $s ) {
        //     if( $s->shift_close_id != 0 && $s->shift_close_id != ""){
        //         if( $s->closeStatus->close_status != "" && $s->closeStatus->close_status == 1 )
        //             array_push($closed,$s);
        //         else
        //             array_push($firstConfirmations,$s);
        //     }
        // }

        return view('rrhh.shift_management.close-shift', compact('ouRoots','actuallyOrgUnit','actuallyYear','months','actuallyMonth','staffInShift','closed','cierreDelMes','firstConfirmations',"cierres" ));
    }

    public function shiftReports(Request $r){
        // echo "shiftReports";
       

        $ouRoots = OrganizationalUnit::where('level', 1)->get();
        $cargos = OrganizationalUnit::all();
        $months = $this->months;
        $shiftDayPerStatus =  array();
        $shiftDayPerJournalType =  array();
        foreach($this->shiftStatus as $s){

            array_push($shiftDayPerStatus,  array('name' =>  $s,'cant'=>10 ));

            
        };

        foreach($this->tiposJornada  as $index => $s){
           array_push($shiftDayPerJournalType,  array('name' =>$s,'id' =>  $index,'cant'=>10 ));

        };
        
        $chartpeoplecant = array();
        foreach($this->weekMap as $index => $w){
            
            array_push($chartpeoplecant,  array('id' => $index,'name' =>  $w,'cant'=>random_int(5, 18) ));

            
        };
        if( Session::has('actuallyShift') && Session::get('actuallyShift') )
            $actuallyShift =  Session::get('actuallyShift');
        else
            $actuallyShift = ShiftTypes::first();

        if(Session::has('actuallyYear') && Session::get('actuallyYear') != "")
            $actuallyYear = Session::get('actuallyYear');
        else
            $actuallyYear = Carbon::now()->format('Y');
        
        // if(Session::has('actuallyOrgUnit') && Session::get('actuallyOrgUnit') != "")
        //     $actuallyOrgUnit = Session::get('actuallyOrgUnit');
        // else    
        //     $actuallyOrgUnit = $cargos->first();
        

        if(Session::has('actuallyMonth') && Session::get('actuallyMonth') != "")
            $actuallyMonth = Session::get('actuallyMonth');
        else
            $actuallyMonth = Carbon::now()->format('m');

        if(Session::has('days') && Session::get('days') != "")
            $days = Session::get('days');
        else
           $days = Carbon::now()->daysInMonth;

        if(Session::has('sTypes') && Session::get('sTypes') != "")
            $sTypes = Session::get('sTypes');
        else
            $sTypes = ShiftTypes::all(); 



        //nueva forma
        if(isset($r) && isset($r->turnFilter) )
            $actuallySerie = $r->turnFilter;
        else
            $actuallySerie = 0;

        if(isset($r) && $r->orgunitFilter && $r->orgunitFilter != 0)
            $actuallyOrgUnit =  OrganizationalUnit::find($r->orgunitFilter);
        // elseif(isset($r) && $r->orgunitFilter && $r->orgunitFilter == 0)
        //     $actuallyOrgUnit = (object) array('id' => 0,'name'  => 'Todos');
        // else    
        //     $actuallyOrgUnit = $cargos->first();
        else
            $actuallyOrgUnit = (object) array('id' => 0,'name'  => 'Todos');


        if(isset($r) && isset($r->dayStatus) )
            $actuallyDayStatus = $r->dayStatus;
        else
           $actuallyDayStatus =  0;

        if(isset($r) && isset($r->journalType) )
            $actuallyJournalType = $r->journalType;
        else
            $actuallyJournalType =  "0";

        if( isset($r) && $r->datefrom )
            $datefrom = $r->datefrom;   
        else
            $datefrom = Carbon::now()->format("Y-m-d");

        if(isset($r) && $r->dateto ) 
            $dateto = $r->dateto; 
        else
            $dateto = Carbon::now()->format("Y-m-d"); 

        $staffInShift = 1;//ShiftUser::where('organizational_units_id', $actuallyOrgUnit->id )->where('date_up','>=',$actuallyYear."-".$actuallyMonth."-01")->where('date_from','<=',  {{{$actuallyYear."-".$actuallyMonth."-".$days)->get();
        
        $tiposJornada = $this->tiposJornada;
        $shiftStatus = $this->shiftStatus;
        
        // echo $actuallyJournalType;
        // echo "gere";
        if($actuallyOrgUnit->id!="0"){

            $reportResult = ShiftUserDay::where('day','>=',$datefrom)->where('day','<=',$dateto)->orderBy("day","ASC")->whereHas("ShiftUser",  function($q) use($actuallyOrgUnit){ // Busco todos los dias que esten en estado 3 que es turno extra,  
                $q->where('organizational_units_id',$actuallyOrgUnit->id);
            })->get();
        }else{

            $reportResult = ShiftUserDay::where('day','>=',$datefrom)->where('day','<=',$dateto)->orderBy("day","ASC")->get();  
        }

        if($actuallyJournalType!="0")
            $reportResult = $reportResult->where("working_day",$actuallyJournalType);

        if($actuallyDayStatus!="0")
            $reportResult = $reportResult->where("status",$actuallyDayStatus);

       return view('rrhh.shift_management.reports', compact('ouRoots','actuallyOrgUnit','actuallyYear','months','actuallyMonth','staffInShift','shiftDayPerStatus' , 'shiftDayPerJournalType','chartpeoplecant','sTypes','actuallyShift','tiposJornada','shiftStatus','actuallyDayStatus','actuallyJournalType','datefrom','dateto','actuallySerie','reportResult'));
    }

    public function shiftDashboard(){
        // echo "shiftReports";
        $ouRoots = OrganizationalUnit::where('level', 1)->get();
        $cargos = OrganizationalUnit::all();
        $months = $this->months;
        $shiftDayPerStatus =  array();
        $shiftDayPerJournalType =  array();
        foreach($this->shiftStatus as $s){

            array_push($shiftDayPerStatus,  array('name' =>  $s,'cant'=>10 ));

            
        };

        foreach($this->tiposJornada  as $index => $s){
           array_push($shiftDayPerJournalType,  array('name' =>$s,'id' =>  $index,'cant'=>10 ));

        };
        
        $chartpeoplecant = array();
        foreach($this->weekMap as $index => $w){
            
            array_push($chartpeoplecant,  array('id' => $index,'name' =>  $w,'cant'=>random_int(5, 18) ));

            
        };


        if(Session::has('actuallyYear') && Session::get('actuallyYear') != "")
            $actuallyYear = Session::get('actuallyYear');
        else
            $actuallyYear = Carbon::now()->format('Y');
        
        if(Session::has('actuallyOrgUnit') && Session::get('actuallyOrgUnit') != "")
            $actuallyOrgUnit = Session::get('actuallyOrgUnit');
        else    
            $actuallyOrgUnit = $cargos->first();

        if(Session::has('actuallyMonth') && Session::get('actuallyMonth') != "")
            $actuallyMonth = Session::get('actuallyMonth');
        else
            $actuallyMonth = Carbon::now()->format('m');

        if(Session::has('days') && Session::get('days') != "")
            $days = Session::get('days');
        else
           $days = Carbon::now()->daysInMonth;
        $staffInShift = ShiftUser::where('organizational_units_id', $actuallyOrgUnit->id )->where('date_up','>=',$actuallyYear."-".$actuallyMonth."-01")->where('date_from','<=',$actuallyYear."-".$actuallyMonth."-".$days)->get();

       return view('rrhh.shift_management.reports', compact('ouRoots','actuallyOrgUnit','actuallyYear','months','actuallyMonth','staffInShift','shiftDayPerStatus' , 'shiftDayPerJournalType','chartpeoplecant'));
    }

    public function availableShifts(){
        
        $ouRoots = OrganizationalUnit::where('level', 1)->get();
        $cargos = OrganizationalUnit::all();
        $months = $this->months;
        if(Session::has('actuallyYear') && Session::get('actuallyYear') != "")
            $actuallyYear = Session::get('actuallyYear');
        else
            $actuallyYear = Carbon::now()->format('Y');
        
        if(Session::has('actuallyOrgUnit') && Session::get('actuallyOrgUnit') != "")
            $actuallyOrgUnit = Session::get('actuallyOrgUnit');
        else    
            $actuallyOrgUnit = $cargos->first();

        $actuallyOrgUnit =    Auth()->user()->organizationalUnit; // porque solo puedo ver los turnos disponibles de mi unidad (momentaneamente)

        if(Session::has('actuallyMonth') && Session::get('actuallyMonth') != "")
            $actuallyMonth = Session::get('actuallyMonth');
        else
            $actuallyMonth = Carbon::now()->format('m');

        if(Session::has('days') && Session::get('days') != "")
            $days = Session::get('days');
        else
           $days = Carbon::now()->daysInMonth;

        $tiposJornada = $this->tiposJornada;
        $weekMap = $this->weekMap;
        $months = $this->monthsNumber;
        $timePerDay = $this->timePerDay;
        $dummyVar ="only for recordatory";

        // $availableDays = ShiftUserDay::where("status",4) .... antes 
        //aora
        $availableDays = ShiftUserDay::where('day','>=',$actuallyYear."-".$actuallyMonth."-01")->where('day','<=',$actuallyYear."-".$actuallyMonth."-".$days)->whereHas("shiftUserDayLog",  function($q) use($dummyVar){
                // Busco todos los dias que esten en estado 4 que cambio turno con,  
                $q->where('change_type',7); // este mismo cambiar  el change type y agregarle una "nuevo salto de linea" para escribir un nuevo mensaje qe ya fue confirmado
        })->whereHas("ShiftUser",  function($q) use($actuallyOrgUnit){
                
                $q->where('organizational_units_id',$actuallyOrgUnit->id); // Para filtrar solo los dias de la unidad organizacional del usuario
        })->get();//aqui faltan agregar los turnos qe dejan disponibles a partir de otro estado
        
             /*doesntHave("shiftUserDayLog",  function($q) use($userId){
                
                $q->where('change_type',8);
        
            })->get();*/

          $misSolicitudes =   UserRequestOfDay::where("user_id",Auth()->user()->id)->where("created_at",">=", $actuallyYear."-".$actuallyMonth."-01")->where("created_at","<=", $actuallyYear."-".$actuallyMonth."-31")->get();
          $solicitudesPorAprobar ="";
        // if( $user->can("Shift Management: approval extra day request") ){
            $orgForAprove = Auth()->user()->organizational_unit_id;
            $solicitudesPorAprobar =  UserRequestOfDay::where("created_at",">=", $actuallyYear."-".$actuallyMonth."-01")->where("created_at","<=", $actuallyYear."-".$actuallyMonth."-31")->whereHas("ShiftUserDay",  function($q) use($orgForAprove){
                
                // $q->where('organizational_units_id',$actuallyOrgUnit->id);

                $q->whereHas("ShiftUser",  function($r) use($orgForAprove){
                
                            $r->where('organizational_units_id',$orgForAprove);
           
                });
           
            })->get(); 
            

        // }

           return view('rrhh.shift_management.available-shifts', compact('ouRoots','actuallyOrgUnit','actuallyYear','months','actuallyMonth','availableDays','tiposJornada','weekMap','months','timePerDay','misSolicitudes','solicitudesPorAprobar'));
    }

    public function applyForAvailableShifts(Request $r){
        // dd($r->input("idShiftUserDay"));
        $sUserDay = ShiftUserDay::find($r->input("idShiftUserDay"));
        $nRqst = new UserRequestOfDay;
        $nRqst->status = "pendiente";
        $nRqst->commentary = "";
        $nRqst->shift_user_day_id =  $sUserDay->id;
        $nRqst->user_id =  Auth()->user()->id;
        $nRqst->status_change_by =  Auth()->user()->id;
        $nRqst->save();
        // dd($nRqst);

        session()->flash('success', 'Se ha realizado la solicitud del día extra del '.$sUserDay->day);
        return redirect()->route('rrhh.shiftManag.availableShifts');
    }

    public function cancelShiftRequest(Request $r){
        // dd($r->input("solicitudId"));
        $fSolicitud = UserRequestOfDay::find($r->input("solicitudId"));
        $fSolicitud->status = "cancelado";
        $fSolicitud->status_change_by  = Auth()->user()->id;
        $fSolicitud->save();

        session()->flash('warning', 'Se ha cancelado la solicitud del día extra del '.$fSolicitud->ShiftUserDay->day);
        return redirect()->route('rrhh.shiftManag.availableShifts');
    }

    public function approveShiftRequest(Request $r){
        // 1) confirmar solicitud
        $fSolicitud = UserRequestOfDay::find($r->input("solicitudId"));
        $fSolicitud->status = "confirmado";
        $fSolicitud->status_change_by  = Auth()->user()->id;
        $fSolicitud->save();
        
        // 2) buscar solicitudes del mismo dia y rechazarlas
        $fSolicitudARechazar =  UserRequestOfDay::where("shift_user_day_id",$fSolicitud->shift_user_day_id)->where("status","pendiente")->get();
        foreach($fSolicitudARechazar as $sol){

            $sol->status = "rechazado";
            $sol->status_change_by  = Auth()->user()->id;
            $sol->save();
        
        }

        // agregar dia extra a usuario correspondiente a la solicitud aprobada
        // $fSolicitud->ShiftUserDay->shiftUserDayLog->where(); // cambiar cahge_tyoe al id
       
        $daysOfMonth = Carbon::createFromFormat('Y-m-d',  $fSolicitud->ShiftUserDay->day, 'Europe/London');
        $splitDay = explode("-", $fSolicitud->ShiftUserDay->day);
        $from = date($splitDay[0].'-'.$splitDay[1].'-01');
        $to = date($splitDay[0].'-'.$splitDay[1].'-'.$daysOfMonth->daysInMonth);
        $days = $daysOfMonth->daysInMonth;
        $bTurno = ShiftUser::where("user_id",$fSolicitud->user_id)->where("date_from",">=",$from)->where("date_up","<=",$to)->where("organizational_units_id",$fSolicitud->ShiftUserDay->ShiftUser->organizational_units_id)->first(); 
        if( !isset($bTurno) || $bTurno == ""){ // si no tiene ningun turno asociado a ese rango, se le crea
            $bTurno = new ShiftUser;
            $bTurno->date_from = $from;
            $bTurno->date_up = $to; 
            $bTurno->asigned_by = Auth::user()->id;
            $bTurno->user_id = $fSolicitud->user_id;
            $bTurno->shift_types_id = $fSolicitud->ShiftUserDay->ShiftUser->shift_types_id;
            $bTurno->organizational_units_id = $fSolicitud->ShiftUserDay->ShiftUser->organizational_units_id;
            $bTurno->groupname ="";
            $bTurno->save();
        }

        $nDay = new ShiftUserDay;
        $nDay->day = $fSolicitud->ShiftUserDay->day;
        $nDay->commentary = "Dia extra agregado, perteneciente al usuario ".$fSolicitud->ShiftUserDay->ShiftUser->user_id;
        $nDay->status = 3;
        $nDay->shift_user_id = $bTurno->id;
        $nDay->working_day = $fSolicitud->ShiftUserDay->working_day;
        $nDay->derived_from = $fSolicitud->ShiftUserDay->id;
        $nDay->save();  
        //si tiene turno creado para ese mes y ese tipo de turno

        $nHistory = new ShiftDayHistoryOfChanges;
        $nHistory->commentary = "El usuario \"".Auth()->user()->name." ". Auth()->user()->fathers_family ." ". Auth()->user()->mothers_family ."\" <b>ha cambiado la asignacion del dia</b> del usuario \"". $fSolicitud->ShiftUserDay->ShiftUser->user_id . "\" al usuario \"" .$fSolicitud->user_id."\"";
        $nHistory->shift_user_day_id = $fSolicitud->ShiftUserDay->id;
        $nHistory->modified_by = Auth()->user()->id;
        $nHistory->change_type = 2;//1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario
        $nHistory->day =  $fSolicitud->ShiftUserDay->day;
        $nHistory->previous_value = 2;
        $nHistory->current_value = 2;
        $nHistory->save();

        session()->flash('success', 'Se ha confirmado la solicitud del día extra del '.$fSolicitud->ShiftUserDay->day);
        return redirect()->route('rrhh.shiftManag.availableShifts');
    }
    
    public function rejectShiftRequest(Request $r){
        // dd($r->input("solicitudId"));
        $fSolicitud = UserRequestOfDay::find($r->input("solicitudId"));
        $fSolicitud->status = "rechazado";
        $fSolicitud->status_change_by  = Auth()->user()->id;
        $fSolicitud->save();

        session()->flash('warning', 'Se ha rechazado la solicitud del día extra del '.$fSolicitud->ShiftUserDay->day);
        return redirect()->route('rrhh.shiftManag.availableShifts');
    }
    
    public function firstConfirmation(Request $r){
        // dd($r->input("comment"));
        $total_hours = 0;
        $cierreDelMes = ShiftDateOfClosing::find($r->input("cierreId"));
        $idUser = $r->input("userId");
        $daysForClose = ShiftUserDay::where('day','>=',$cierreDelMes->init_date)->where('day','<=',$cierreDelMes->close_date)->whereNull('shift_close_id')->whereHas("ShiftUser",  function($q) use($idUser){
                
                    $q->where('user_id',$idUser); // Para filtrar solo los dias de la unidad organizacional del usuario
        })->get();

        foreach($daysForClose as $dd){

            if(  substr($dd->working_day,0, 1) != "+" )
                $total_hours+=   (isset($this->timePerDay[$dd->working_day]))?$this->timePerDay[$dd->working_day]["time"]:0  ;
            else
                $total_hours+= intval( substr( $dd->working_day,1,2) );

        }


        $n = new ShiftClose;
        $n->status = 1;
        $n->total_hours = $total_hours;
        $n->first_confirmation_commentary = $r->input("comment");
        $n->first_confirmation_status = 1;
        $n->first_confirmation_date =  Carbon::now()->format('Y-m-d');
        $n->first_confirmation_user_id = Auth()->user()->id; 
        $n->date_of_closing_id = $r->input("cierreId");
        $n->owner_of_the_days_id = $r->input("userId");
        $n->save();

        foreach($daysForClose as $d){
            $d->shift_close_id = $n->id;
            $d->save();
        }

        session()->flash('success', 'Se han confirmado los días ');
        return redirect()->route('rrhh.shiftManag.closeShift');
    }

    public function closeDaysConfirmation(Request $r){

       $f =  ShiftClose::find($r->input("ShiftCloseId"));
        $f->close_commentary = "";
        $f->close_status = 1;
        $f->close_date = Carbon::now()->format('Y-m-d');;
        $f->close_user_id =  Auth()->user()->id; ;
       $f->save();
       session()->flash('success', 'Se han cerrado los días ');
        return redirect()->route('rrhh.shiftManag.closeShift');
    }
}
