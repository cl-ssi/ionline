<?php

namespace App\Livewire\Allowances;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Allowances\Allowance;
use App\Models\Allowances\Destination;
use App\Models\Allowances\AllowanceFile;
use App\Models\Allowances\AllowanceSign;
use App\Models\Parameters\AllowanceValue;
use App\Models\Parameters\ContractualCondition;
use App\Models\ClCommune;
use App\Models\User;
use App\Notifications\Allowances\NewAllowance;
use App\Models\Parameters\Parameter;
use App\Models\ClLocality;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class AllowancesCreate extends Component
{
    use WithFileUploads;

    public $idAllowance, $userAllowance, $contractualConditionId, $position, $cfgAllowanceValue, $allowanceValueId, 
        $grade, $law, $reason, 

        $originCommune, $destinations,
        
        $meansOfTransport, $roundTrip, $passage, $overnight, $accommodation, $food, $from, $to, 
        $total_days = 0, $total_half_days = 0, $fifty_percent_total_days = 0, $halfDaysOnly,
        $dayValue, $halfDayValue, $fifty_percent_day_value,
        
        $MaxDaysStraight = 0;

    public $disabledHalfDayOnly;
    public $accommodationSelected = null;
    public $foodSelected = null;

    public $disabledLaw = '';

    /* Archivo */
    public $idFile;
    // public $file;
    public $fileName;
    public $fileAttached;
    public $files = array();
    public $key;
    public $deleteFileMessage;

    /* Destinos */
    /* Listeners */
    public $selectedCommuneId;
    public $searchedCommune;

    public $i;
    public $communeInputId;
    public $localities;
    public $selectedLocality;
    public $description;
    public $validateMessage;
    public $destinationCommune;
    public $deleteDestinationMessage;

    /* Aprobaciones */
    public $positionFinance;

    /* Allowance to edit */
    public $allowanceToEdit;

    /* Allowance to replicate */
    public $allowanceToReplicate;

    /* Total dias completos en el año */
    public $totalCurrentAllowancesDaysByUser = 0;
    /* Total dias completos en el mes */
    public $totalCurrentMonthAllowancesDaysByUser = 0;
    /* Total días disponibles */
    public $allowancesAvailableDays = 0;
    /* Total días disponibles */
    public $allowancesExceededDays = 0;

    /* Variable de pantalla */
    public $form;

    // VARIABLE DE MENSAJE MEDIO DE TRANSPORTE 
    public $messageMeansOfTransport = NULL;

    //SELECCION DE LEY MEDICA
    public $disabledAllowanceValueId = '';
    public $disabledGrade = '';

    public $iterationFileClean = 0;

    public $restrict = [];

    public $bheFile = null;
    public $bheFileStatus = null;
    public $messageBhe = null;
    
    protected function messages(){
        return [
            /* Mensajes para Allowance */
            'userAllowance.required'            => 'Debe ingresar Usuario al cual se extiende Viático.',
            'contractualConditionId.required'   => 'Debe ingresar Calidad Contractual.',
            'position.required'                 => 'Debe ingresar Función o Cargo',
            'allowanceValueId.required'         => 'Debe ingresar Rengo Grado E.U.S.',
            'grade.required'                    => 'Debe ingresar Grado.',
            'law.required'                      => 'Debe ingresar Ley.',
            'reason.required'                   => 'Debe ingresar Motivo.',

            'originCommune.required'            => 'Debe ingresar Comuna de origen.',
            'destinations.required'             => 'Debe ingresar al menos una Comuna de destino.',
            
            'meansOfTransport.required'         => 'Debe ingresar Medio de Transporte.',
            'roundTrip.required'                => 'Debe ingresar Itinerario.',
            'passage.required'                  => 'Debe ingresar Derecho de Pasaje.',

            'overnight.required'                => 'Debe ingresar Pernocta Fuera de Residencia.',
            'accommodation.required'            => 'Debe ingresar si Incluye Alojamiento.',
            'food.required'                     => 'Debe ingresar si Incluye Alimentación.',
            
            'from.required'                     => 'Debe ingresar Fecha Desde.',
            'to.required'                       => 'Debe ingresar Fecha Hasta.',
            'to.after_or_equal'                 => 'Debe ingresar una Fecha Hasta, posterior o igual a Fecha Desde.',

            'files.required'                    => 'Debe ingresar al menos un Archivo Adjunto.',

            /* Mensajes para destinos */

            'destinationCommune.required'       => 'Debe ingresar una Comuna de destino.',
            'selectedLocality.required'         => 'Debe ingresar una Localidad de destino.',

            /* Mensajes para archivos */
            'fileName.required'                 => 'Debe ingresar un nombre para el archivo.',
            'fileAttached.required'             => 'Debe ingresar un archivo adjunto.',
        ];
    }

    public function saveAllowance(){
        $this->validateMessage = 'allowance';
        $validatedData = $this->validate([
            'userAllowance'                                         => 'required',
            'contractualConditionId'                                => 'required',
            'position'                                              => 'required',
            'allowanceValueId'                                      => 'required',
            ($this->law == "19664" || $this->contractualConditionId == "2") ? 'grade' : 'grade' => ($this->law == "19664" || $this->contractualConditionId == "2") ? '' : 'required',
            ($this->contractualConditionId == "2") ? 'law' : 'law'  => ($this->contractualConditionId == "2") ? '' : 'required',
            'reason'                                                => 'required',

            'originCommune'                                         => 'required',
            'destinations'                                          => 'required',

            'meansOfTransport'                                      => 'required',
            'roundTrip'                                             => 'required',
            'passage'                                               => 'required',

            'overnight'                                             => 'required',
            'accommodation'                                         => 'required',
            'food'                                                  => 'required',

            'from'                                                  => 'required',
            'to'                                                    => 'required|after_or_equal:from',

            'files'                                                 => 'required',

            // 'fileAttached'                                          => 'required'
        ]);

        /* Buscar si existen viáticos en fecha indicada */
        if($this->allowanceToEdit != null){
            $currentAllowances = Allowance::where('user_allowance_id', $this->userAllowance->id)
                ->where('id', '!=', $this->allowanceToEdit->id)
                ->where('status', '!=', 'rejected')
                ->whereYear('from', Carbon::parse($this->from)->year)
                ->WhereYear('to', Carbon::parse($this->to)->year)
                ->get();
        }
        else{
            $currentAllowances = Allowance::where('user_allowance_id', $this->userAllowance->id)
                ->where('status', '!=', 'rejected')
                ->whereYear('from', Carbon::parse($this->from)->year)
                ->WhereYear('to', Carbon::parse($this->to)->year)
                ->get();
        }
        $periodo = CarbonPeriod::create($this->from, $this->to);
        // Se itera por PERIODO
        foreach ($periodo as $fecha) {
            // Se itera por VIATICOS AÑO EN CURSO
            foreach($currentAllowances as $currentAllowance){
                if($currentAllowance->from == $fecha->format('Y-m-d') || $currentAllowance->to == $fecha->format('Y-m-d')){
                    return back()->with('current', 'Estimado Usuario: El funcionario ya dispone de viático(s) para la fecha solicitada.');
                }
            }
        }

        /* SET NUMERO DE VIATICOS PARA PRUEBAS */
        // $this->totalCurrentAllowancesDaysByUser = $this->totalCurrentAllowancesDaysByUser + 87;

        $alw = DB::transaction(function () {
            $alw = Allowance::updateOrCreate(
                [
                    'id'  =>  $this->idAllowance,
                ],
                [
                    'status'                            => 'pending',
                    'user_allowance_id'                 => $this->userAllowance->id,
                    'contractual_condition_id'          => $this->contractualConditionId,
                    'position'                          => $this->position,
                    'allowance_value_id'                => $this->allowanceValueId(),
                    'grade'                             => ($this->law != "19664" || $this->contractualConditionId != "2") ? $this->grade : null,
                    'law'                               => $this->law,
                    'establishment_id'                  => $this->userAllowance->organizationalUnit->establishment->id,
                    'organizational_unit_allowance_id'  => $this->userAllowance->organizationalUnit->id, 
                    'reason'                            => $this->reason,
                    'overnight'                         => $this->overnight,
                    'accommodation'                     => $this->accommodation,
                    'food'                              => $this->food,
                    'passage'                           => $this->passage, 
                    'means_of_transport'                => $this->meansOfTransport, 
                    'origin_commune_id'                 => $this->originCommune->id,
                    'round_trip'                        => $this->roundTrip,
                    'from'                              => $this->from, 
                    'to'                                => $this->to,
                    'total_days'                        => $this->totalDays(),
                    'total_half_days'                   => $this->totalHalfDays(),
                    'fifty_percent_total_days'          => $this->totalFiftyPercentDays(),
                    'sixty_percent_total_days'          => $this->totalSixtyPercentDays(),
                    'half_days_only'                    => $this->halfDaysOnly,
                    'day_value'                         => $this->allowanceDayValue(),
                    'half_day_value'                    => $this->allowanceHalfDayValue(),
                    'fifty_percent_day_value'           => $this->allowanceFiftyPercentDayValue(),
                    'sixty_percent_day_value'           => $this->allowanceSixtyPercentDayValue(),
                    'total_value'                       => $this->allowanceTotalValue(),
                    'creator_user_id'                   => auth()->id(), 
                    'creator_ou_id'                     => auth()->user()->organizationalUnit->id
                ]
            );

            return $alw;
        });

        /* SE GUARDAN LOS DESTINOS DEL VIÁTICO */
        foreach($this->destinations as $destination){
            Destination::updateOrCreate(
                [
                    'id' => $destination['id'],
                ],
                [
                    'commune_id'    => $destination['commune_id'], 
                    'locality_id'   => ($destination['locality_id'] != null) ? $destination['locality_id'] : null, 
                    'description'   => $destination['description'],
                    'allowance_id'  => ($this->allowanceToEdit) ? $this->allowanceToEdit->id : $alw->id
                ]
            );
        }

        //Si es Honorarios seteo el archivo

        if($this->bheFileStatus == 'active' && $this->bheFile){
            if(!is_string($this->bheFile)){
                $this->bheFile = $this->bheFile ? $this->bheFile->storeAs('/ionline/allowances/bhe', $alw->id.'.'.$this->bheFile->extension(), 'gcs') : null;
                $this->files[] = [
                    'id'        => '',
                    'fileName'  => 'bhe',
                    'file'      => $this->bheFile
                ];
            }
        }

        /* SE GUARDAN LOS ARCHIVOS DEL VIÁTICO */
        foreach($this->files as $keyFiles => $allowanceFile){
            AllowanceFile::updateOrCreate(
                [
                    // 'id' => $this->idFile,
                    'id' => $allowanceFile['id']
                ],
                [
                    'name'          => $allowanceFile['fileName'],
                    'file'          => $allowanceFile['file'], 
                    'allowance_id'  => $alw->id, 
                    'user_id'       => auth()->id(), 
                ]
            );
        }

        // APROBACION SIRH
        if($this->allowanceToEdit == null){
            $sirh_approval = $this->sirhSign($alw);
        }

        /*
        // APROBACION U.O. DE ACUERDO SOLICITANTE 
        $ou_approval = $this->ouSign($alw, $sirh_approval);

        // APROBACION U.O. DE FINANZAS
        $this->financeSign($alw, $ou_approval);
        */

        session()->flash('success', 'Estimados Usuario, se ha creado exitosamente la solicitud de viatico N°'.$alw->id);
        return redirect()->route('allowances.index');
    }

    /* Listeners */
    #[On('userSelected')]
    public function userSelected(User $user)
    {
        $this->userAllowance = $user;
        
        if($this->userAllowance){
            //  Buscar si los viáticos del usuario no exceden 90 días en el presente año 
            $this->totalCurrentAllowancesDaysByUser = 0;
            $this->totalCurrentMonthAllowancesDaysByUser = 0;   

            //CONSULTA POR VIATICOS MENSUALES
            $allowancesCount = Allowance::select('total_days')
                ->where('user_allowance_id', $this->userAllowance->id)
                ->whereDate('from', '>=', now()->startOfYear())
                ->WhereDate('to', '<=', now()->endOfYear())
                ->where('half_days_only', null)
                ->where('total_days', '>=', 1.0)
                ->get();
            foreach($allowancesCount as $allowanceDays){
                $this->totalCurrentAllowancesDaysByUser = $this->totalCurrentAllowancesDaysByUser + $allowanceDays->total_days;
            }

            $allowancesMonthCount = Allowance::select('total_days')
                ->where('user_allowance_id', $this->userAllowance->id)
                ->whereDate('from', '>=', now()->startOfMonth())
                ->WhereDate('to', '<=', now()->endOfMonth())
                ->where('half_days_only', null)
                ->where('total_days', '>=', 1.0)
                ->get();
                
            foreach($allowancesMonthCount as $allowancesMonthDays){
                $this->totalCurrentMonthAllowancesDaysByUser = $this->totalCurrentMonthAllowancesDaysByUser + $allowancesMonthDays->total_days;
            }
        
            if($this->userAllowance->organizationalUnit->establishment->id != Parameter::get('establishment', 'HospitalAltoHospicio') &&
                $this->userAllowance->organizationalUnit->establishment->id != Parameter::get('establishment', 'SSTarapaca')){
                return redirect()->route('allowances.create')->with('warning', 'Estimado Usuario: El funcionario seleccionado no pertenece a Servicio de Salud Tarapacá o Hospital de Alto Hospicio (Favor contactar a su administrativo).');
            }
        }
        
    }

    #[On('emitPosition')]
    public function emitPosition($position)
    {
        $this->position = $position;
    }

    #[On('emitPositionValue')]
    public function emitPositionValue($positionValue)
    {
        $this->position = $positionValue;
    }

    /* Cálculo de días completos */
    public function totalDays(){
        /*if($this->halfDaysOnly != 1){
            if($this->from == $this->to){
                return null;
            }
            else{
                //  LÍMITE MÁXIMO DE VIATICOS AL AÑO 
                $allowanceMaxValue = Parameter::where('module', 'allowance')
                    ->where('parameter', 'AllowanceMaxValue')
                    ->first()
                    ->value;
                    
                //  SE CALCULA LOS DIAS DISPONIBLES 
                $this->allowancesAvailableDays = $allowanceMaxValue - $this->totalCurrentAllowancesDaysByUser;

                if(Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to)) > $this->allowancesAvailableDays){
                    if($this->allowancesAvailableDays > 0){
                        $this->allowancesExceededDays = Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to)) - $this->allowancesAvailableDays;
                        return $this->allowancesAvailableDays;
                    }
                    else{
                        return null;
                    }
                }
                else{
                    return Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to));
                }
            }
        }*/

        if($this->halfDaysOnly == 1){
            return null;
        }
        else{
            //  LÍMITE MÁXIMO DE VIATICOS AL AÑO 
            $allowanceMaxValue = Parameter::where('module', 'allowance')
                ->where('parameter', 'AllowanceMaxValue')
                ->first()
                ->value;
            
            //  SE CALCULA LOS DIAS DISPONIBLES 
            $this->allowancesAvailableDays = $allowanceMaxValue - $this->totalCurrentAllowancesDaysByUser;

            // DIAS SOLICITADOS ES MAYOR A LOS DISPONIBLES? 
            // OPCION: SI
            if(Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to)) > $this->allowancesAvailableDays){
                if($this->allowancesAvailableDays > 0){
                    $this->allowancesExceededDays = Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to)) - $this->allowancesAvailableDays;
                    return $this->allowancesAvailableDays;
                }
            }
            // OPCION: NO
            else{
                if(Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to)) > 10){
                    $this->MaxDaysStraight = 10;
                    $this->allowancesExceededDays = Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to)) - $this->MaxDaysStraight;
                    return $this->MaxDaysStraight;
                }
                else{
                    // COMETIDO O ACTIVIDAD NO INCLUYE NI ALOJAMIENTO NI ALIMENTACIÓN
                    if($this->accommodation == 0 && $this->food == 0){
                        return Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to)) - $this->MaxDaysStraight;
                    }
                    // COMETIDO INCLUYE SOLO ALOJAMIENTO
                    if($this->accommodation == 1 && $this->food == 0){
                        // SOLO MEDIOS DIAS
                        return null;
                    }
                    if($this->accommodation == 0 && $this->food == 1){
                        return null;
                    }
                }
            }
        }
    }

    /* Cálculo de medios días */
    public function totalHalfDays(){
        //Viático tradicional 
        if(($this->halfDaysOnly == null || $this->halfDaysOnly == false) && 
                $this->from != $this->to &&
                $this->accommodation == 0 && 
                $this->food == 0){

            return 1;
        }

        //Viático sólo alojamiento
        if($this->from != $this->to &&
            $this->accommodation == 1 && 
            $this->food == 0){
                return Carbon::parse($this->from." 00:00:00")
                    ->diffInDays(Carbon::parse($this->to." 23:59:59")->addDay()->startOfDay());
        }

        //Viático sólo alimentacion
        if($this->from != $this->to &&
            $this->accommodation == 0 && 
            $this->food == 1){

            return null;
        }

        //Viático sólo medios días
        if($this->halfDaysOnly != null || ($this->from == $this->to)){
            return Carbon::parse($this->from)
                ->diffInDays(Carbon::parse($this->to)->addDay()->startOfDay());
        }
    }

    /* Cálculo de días 50 porciento */
    public function totalFiftyPercentDays(){
        return $this->allowancesExceededDays;
    }

    public function totalSixtyPercentDays(){
        if($this->accommodation == 0 && $this->food == 1){
            return Carbon::parse($this->from." 00:00:00")->diffInDays(Carbon::parse($this->to." 23:59:59")->startOfDay());
        }
    }


    public function allowanceValueId(){
        $this->cfgAllowanceValue = AllowanceValue::find($this->allowanceValueId);
        return $this->cfgAllowanceValue->id;
    }

    public function allowanceDayValue(){
        if($this->totalDays() >= 1 && $this->halfDaysOnly == 0){
            $this->dayValue = $this->cfgAllowanceValue->value;
            return $this->cfgAllowanceValue->value;
        }
    }

    public function allowanceHalfDayValue(){
        $this->halfDayValue = $this->cfgAllowanceValue->value * 0.4;
        return round($this->cfgAllowanceValue->value * 0.4, 0);
    }

    public function allowanceFiftyPercentDayValue(){
        return round($this->cfgAllowanceValue->value * 0.5, 0);
    }

    public function allowanceSixtyPercentDayValue(){
        return round($this->cfgAllowanceValue->value * 0.6, 0);
    }

    public function allowanceTotalValue(){
        if($this->halfDaysOnly == 1 || ($this->from == $this->to)){
            return ($this->allowanceHalfDayValue() * $this->totalHalfDays());
        }
        else{
            if($this->totalDays()){
                $allowanceTotalValue =  $this->allowanceDayValue() * $this->totalDays();
            }
            if($this->totalHalfDays()){
                // COMETIDO INCLUYE SOLO ALOJAMIENTO
                if($this->accommodation == 1 && $this->food == 0){
                    $allowanceTotalValue = $this->allowanceHalfDayValue() * $this->totalHalfDays();
                }
                else{
                    $allowanceTotalValue =  $allowanceTotalValue + ($this->allowanceHalfDayValue() * $this->totalHalfDays());
                }
            }
            if($this->totalFiftyPercentDays()){
                $allowanceTotalValue =  $allowanceTotalValue + ($this->allowanceFiftyPercentDayValue() * $this->totalFiftyPercentDays());
            }
            if($this->totalSixtyPercentDays()){
                $allowanceTotalValue =  $this->allowanceSixtyPercentDayValue() * $this->totalSixtyPercentDays();
            }
            return $allowanceTotalValue;
        }
    }

    /* Métodos de Aprobación */

    public function sirhSign(Allowance $alw)
    {
        // ANTIGUAS VISACIONES

        //EN CASO DE SER HAH SE AGREGA APROBACION CONTABILIDAD
        if($alw->establishment_id == Parameter::get('establishment', 'HospitalAltoHospicio')){
            $ou_contabilidad = Parameter::get('allowance', 'contablidad', $alw->userAllowance->organizationalUnit->establishment->id);

            $allowance_sing_sirh                            = new AllowanceSign();
            $allowance_sing_sirh->position                  = 1;
            $allowance_sing_sirh->event_type                = 'contabilidad';
            $allowance_sing_sirh->status                    = 'pending';
            $allowance_sing_sirh->allowance_id              = $alw->id;
            $allowance_sing_sirh->organizational_unit_id    = $ou_contabilidad;
            $allowance_sing_sirh->save();
        }

        //U.O. QUE REFERENCIA A QUE ESTABLECIMIENTO APRUEBA
        $ou_sirh = Parameter::get('allowance', 'sirh_sign', $alw->userAllowance->organizationalUnit->establishment->id);
    
        //SE AGREGA AL PRINCIPIO VISACIÓN SIRH
        $allowance_sing_sirh                            = new AllowanceSign();
        $allowance_sing_sirh->position                  = ($alw->establishment_id == Parameter::get('establishment', 'HospitalAltoHospicio')) ? 2 : 1;
        $allowance_sing_sirh->event_type                = 'sirh';
        $allowance_sing_sirh->status                    = ($alw->establishment_id == Parameter::get('establishment', 'HospitalAltoHospicio')) ? null : 'pending';
        $allowance_sing_sirh->allowance_id              = $alw->id;
        $allowance_sing_sirh->organizational_unit_id    = $ou_sirh;
        $allowance_sing_sirh->save();

        //SE NOTIFICA PARA INICIAR EL PROCESO DE APROBACIONES
        $notificationSirhPermissionUsers = ($alw->establishment_id == Parameter::get('establishment', 'HospitalAltoHospicio')) ? User::permission('Allowances: contabilidad')->get() : User::permission('Allowances: sirh')->get();
        foreach($notificationSirhPermissionUsers as $notificationSirhPermissionUser){
            $notificationSirhPermissionUser->notify(new NewAllowance($alw));
        }
        
        
    }

    public function ouSign(Allowance $alw, $sirh_approval){
        /*

        //CONSULTO SI EL VIATICO ES PARA UNA AUTORIDAD
        $iam_authorities = Authority::getAmIAuthorityFromOu(Carbon::now(), 'manager', $alw->userAllowance->id);

        //AUTORIDAD
        if($iam_authorities->isNotEmpty()){
            foreach($iam_authorities as $iam_authority){
                if($alw->userAllowance->organizationalUnit->id == $iam_authority->organizational_unit_id){
                    //SE RESTA UNA U.O. POR SER AUTORIDAD
                    $level_allowance_ou = $iam_authority->organizationalUnit->level - 1;
                    
                    $nextLevel = $iam_authority->organizationalUnit->father;
                    $position = 2;

                    if($iam_authority->organizationalUnit->level == 2){
                        for ($i = $level_allowance_ou; $i >= 1; $i--){
                            $allowance_sing = new AllowanceSign();
                            $allowance_sing->position = $position;
                            if($i >= 3){
                                $allowance_sing->event_type = 'boss';
                            }
                            if($i == 2){
                                $allowance_sing->event_type = 'sub-dir or boss';
                            }
                            if($i == 1){
                                $allowance_sing->event_type = 'dir';
                            }
                            $allowance_sing->organizational_unit_id = $nextLevel->id;
                            $allowance_sing->allowance_id = $alw->id;

                            $allowance_sing->save();

                            $nextLevel = $allowance_sing->organizationalUnit->father;
                            $position = $position + 1;

                            $this->positionFinance = $position;
                        }
                    }
                    else{
                        for ($i = $level_allowance_ou; $i >= 2; $i--){
                            $allowance_sing = new AllowanceSign();
                            $allowance_sing->position = $position;
                            if($i >= 3){
                                $allowance_sing->event_type = 'boss';
                            }
                            if($i == 2){
                                $allowance_sing->event_type = 'sub-dir or boss';
                            }
                            $allowance_sing->organizational_unit_id = $nextLevel->id;
                            $allowance_sing->allowance_id = $alw->id;

                            $allowance_sing->save();

                            $nextLevel = $allowance_sing->organizationalUnit->father;
                            $position = $position + 1;

                            $this->positionFinance = $position;
                        }
                    } 
                }
            }
        }
        //NO AUTORIDAD
        else{
            $level_allowance_ou = $alw->organizationalUnitAllowance->level;
            $position = 2;

            for ($i = $level_allowance_ou; $i >= 2; $i--){

                $allowance_sign = new AllowanceSign();
                $allowance_sign->position = $position;

                if($i >= 3){
                    $allowance_sign->event_type = 'boss';
                    if($i == $level_allowance_ou){
                        $allowance_sign->organizational_unit_id = $alw->organizationalUnitAllowance->id;
                    }
                    else{
                        $allowance_sign->organizational_unit_id = $nextLevel->id;
                    }
                    
                }
                if($i == 2){
                    $allowance_sign->event_type = 'sub-dir or boss';
                    if($i == $level_allowance_ou){
                        $allowance_sign->organizational_unit_id = $alw->organizationalUnitAllowance->id;
                    }
                    else{
                        $allowance_sign->organizational_unit_id = $nextLevel->id;
                    }
                }
                
                $allowance_sign->allowance_id = $alw->id;

                $allowance_sign->save();

                $nextLevel = $allowance_sign->organizationalUnit->father;
                $position = $position + 1;

                $this->positionFinance = $position;
            }
        }
        */

        /*
        if(count($alw->userAllowance->manager) > 0){
            foreach($alw->userAllowance->manager as $manager){
                if($alw->userAllowance->organizational == $manager->organizational_unit_id){
                    $currentManager = $manager;
                }
            }
        }
        */

        // $cont = 0;
        $ous_to_approval = array();
        $currentOu = $alw->userAllowance->organizationalUnit;

        $lastApprovalId = $sirh_approval;
        
        for ($i = $alw->userAllowance->organizationalUnit->level; $i >= 2; $i--){
            $approval = $alw->approvals()->create([
                "module"                            => "Viáticos",
                "module_icon"                       => "bi bi-wallet",
                "subject"                           => 'Solicitud de Viático: ID '.$alw->id.'<br>
                                                        Funcionario: '.$alw->userAllowance->fullName,
                "sent_to_ou_id"                     => $currentOu->id,
                "document_route_name"               => "allowances.show_approval",
                "document_route_params"             => json_encode([
                    "allowance_id" => $alw->id
                ]),
                "active"                            => false,
                "previous_approval_id"              => $lastApprovalId,
                "callback_controller_method"        => "App\Http\Controllers\Allowances\AllowanceController@approvalCallback",
                "callback_controller_params"        => json_encode([
                    'allowance_id'  => $alw->id,
                    'process'       => null
                ])
            ]);
            $currentOu = $currentOu->father;
            $lastApprovalId = $approval->id;
        }

        return $approval->id;
    }

    public function financeSign(Allowance $alw, $ou_approval){
        /*
        $allowance_sing_finance = new AllowanceSign();
        $allowance_sing_finance->position = $this->positionFinance;
        $allowance_sing_finance->event_type = 'chief financial officer';
        $allowance_sing_finance->organizational_unit_id = Parameter::where('module', 'ou')->where('parameter', 'FinanzasSSI')->first()->value;
        $allowance_sing_finance->allowance_id = $alw->id;
        $allowance_sing_finance->save();
        */

        $approval = $alw->approvals()->create([
            "module"                            => "Viáticos",
            "module_icon"                       => "bi bi-wallet",
            "subject"                           => 'Solicitud de Viático: ID '.$alw->id.'<br>
                                                    Funcionario: '.$alw->userAllowance->fullName,
            "sent_to_ou_id"                     => Parameter::get('ou','FinanzasSSI'),
            "document_route_name"               => "allowances.show_approval",
            "document_route_params"             => json_encode([
                "allowance_id" => $alw->id
            ]),
            "active"                            => false,
            "previous_approval_id"              => $ou_approval,
            "callback_controller_method"        => "App\Http\Controllers\Allowances\AllowanceController@approvalCallback",
            "callback_controller_params"        => json_encode([
                'allowance_id'  => $alw->id,
                'process'       => 'end'
            ]),
            "digital_signature"                 => true,
            "position"                          => "right",
            "filename"                          => "ionline/allowances/resol_pdf/".$alw->id.".pdf"
        ]);
    }

    public function updatedContractualConditionId($contractualConditionId){
        if($contractualConditionId == '2'){
            //OPCION HONORARIOS: INHABILITO CAMPO LEY, GRADO Y DETALLE DE GRADO
            $this->disabledLaw = 'disabled';
            $this->disabledAllowanceValueId = 'disabled';
            $this->allowanceValueId = 9;
            $this->grade = null;
            $this->disabledGrade = 'disabled';

            $this->bheFileStatus = 'active';
            $this->messageBhe = "<b>Estimado Usuario</b>: Usted ha seleccionado la calidad contractual <b>Honorarios</b>, favor adjuntar
                dicho documento.";
        }
        else{
            $this->disabledLaw = '';
            $this->disabledAllowanceValueId = '';
            $this->disabledGrade = '';
            $this->allowanceValueId = null;

            $this->bheFileStatus = 'disabled';
            $this->messageBhe = null;
        }
    }

    /*  Metodos para Destino */
    #[On('selectedInputId')]
    public function selectedInputId($communeInputId)
    {
        $this->communeInputId = $communeInputId;
        if($this->communeInputId == 'origin_commune_id'){
            $this->originCommune = $this->searchedCommune;
        }
        if($this->communeInputId == 'destination_commune_id'){
            $this->destinationCommune = $this->searchedCommune;
        }
    }

    #[On('savedDestinations')]
    public function savedDestinations($destinations)
    {
        $this->destinations = $destinations; 
    }

    #[On('searchedCommune')] 
    public function searchedCommune(ClCommune $commune)
    {
        $this->searchedCommune = $commune;
        
        $this->localities = ClLocality::
            where('commune_id', $this->searchedCommune->id)
            ->get();
    }

    public function addDestination()
    {
        $this->validateMessage = 'destination';
        if($this->communeInputId == 'destination_commune_id'){
            $validatedData = $this->validate([
                'destinationCommune'    => 'required',
                (in_array($this->searchedCommune->id, [5,6,8,9,19,11])) ? 'selectedLocality' : 'selectedLocality'  => (in_array($this->searchedCommune->id, [5,6,8,9,19,11])) ? 'required' : ''
            ]);
        }
        else{
            $validatedData = $this->validate([
                'destinationCommune'    => 'required',
            ]);
        }

        if($this->selectedLocality){
            $selectedLocalityName = ClLocality::find($this->selectedLocality)->name;
        }

        $this->destinations[] = [
            'id'            => '',
            'commune_id'    => $this->searchedCommune->id,
            'commune_name'  => $this->searchedCommune->name,
            'locality_id'   => $this->selectedLocality ? $this->selectedLocality : null,
            'locality_name' => $this->selectedLocality ? $selectedLocalityName : null,
            'description'   => $this->description
        ];

        $this->cleanDestination();
        $this->dispatch('onClearUserSearch');
    }

    public function cleanDestination()
    {
        $this->selectedLocality = null;
        $this->description = null;
    }

    public function deleteDestination($key)
    {
        $itemToDelete = $this->destinations[$key];

        if($itemToDelete['id'] != ''){
            if(count($this->destinations) > 1){
                unset($this->destinations[$key]);
                $objectToDelete = Destination::find($itemToDelete['id']);
                $objectToDelete->delete();
            }
            else{
                $this->deleteDestinationMessage = "Estimado Usuario: No es posible eliminar el registro, el Viático debe incluír al menos un destino";
            }
        }
        else{
            unset($this->destinations[$key]);
        }
    }

    private function setDestination($destination)
    {
        $this->destinations[] = [
            'id'            => $destination->id,
            'commune_id'    => $destination->commune->id,
            'commune_name'  => $destination->commune->name,
            'locality_id'   => ($destination->locality) ? $destination->locality->id : '',
            'locality_name' => ($destination->locality) ? $destination->locality->name : '',
            'description'   => $destination->description
        ];
    }

    /* Metodos para Archivos */
    public function addFile(){
        $this->validateMessage = 'file';
        $validatedData = $this->validate([
            'fileName'      => 'required',
            'fileAttached'  => 'required' 
        ]);

        $count = ($this->files == null) ? 0 : count($this->files); 

        $now = Carbon::now()->format('Y_m_d_H_i_s');
        $this->fileAttached = $this->fileAttached ? $this->fileAttached->storeAs('/ionline/allowances/allowance_docs', $now.'_'.$count.'_alw_file.'.$this->fileAttached->extension(), 'gcs') : null;

        $this->files[] = [
            'id'        => '',
            'fileName'  => $this->fileName,
            'file'      => $this->fileAttached
        ];

        $this->cleanFile();
    }

    public function cleanFile(){   
        $this->fileName     = null;
        $this->fileAttached = null;
        $this->iterationFileClean++;
    }

    public function deleteFile($key){
        $itemToDelete = $this->files[$key];

        if($itemToDelete['id'] != ''){
            if(count($this->files) > 1){
                unset($this->files[$key]);
                $objectToDelete = AllowanceFile::find($itemToDelete['id']);
                $objectToDelete->delete();
            }
            else{
                $this->deleteFileMessage = "Estimado Usuario: No es posible eliminar el adjunto, el Viático debe incluír al menos un archivo adjunto.";
            }
        }
        else{
            unset($this->files[$key]);
        }
    }

    private function setFile($file)
    {
        $this->files[] = [
            'id'        => $file->id,
            'fileName'  => $file->name,
            'file'      => $file->file
        ];
    }

    /* Set Allowance */
    private function setAllowance(){
        if($this->allowanceToEdit){
            $this->idAllowance              =   $this->allowanceToEdit->id;
            $this->userAllowance            =   $this->allowanceToEdit->userAllowance;
            $this->contractualConditionId   =   $this->allowanceToEdit->contractual_condition_id;
            $this->position                 =   $this->allowanceToEdit->position;
            $this->allowanceValueId         =   $this->allowanceToEdit->allowance_value_id;
            $this->grade                    =   $this->allowanceToEdit->grade;
            $this->law                      =   $this->allowanceToEdit->law;
            $this->reason                   =   $this->allowanceToEdit->reason;
            $this->originCommune            =   $this->allowanceToEdit->origin_commune_id;
            foreach($this->allowanceToEdit->destinationCommune as $destination){
                $this->setDestination($destination);
            }

            $this->meansOfTransport         =   $this->allowanceToEdit->means_of_transport;
            $this->roundTrip                =   $this->allowanceToEdit->round_trip;
            $this->passage                  =   $this->allowanceToEdit->passage;
            $this->overnight                =   $this->allowanceToEdit->overnight;
            $this->accommodation            =   $this->allowanceToEdit->accommodation;
            $this->food                     =   $this->allowanceToEdit->food;
            $this->from                     =   $this->allowanceToEdit->from->format('Y-m-d');
            $this->to                       =   $this->allowanceToEdit->to->format('Y-m-d');
            $this->halfDaysOnly             =   $this->allowanceToEdit->half_days_only;

            foreach($this->allowanceToEdit->files as $file){
                if($file->name == 'bhe'){
                    $this->bheFile          =   $file->file;
                }
                $this->setFile($file);
            }
        }
    }

    /* Set Allowance To Replicate */
    private function setAllowanceToReplicate(){
        if($this->allowanceToReplicate){
            $this->userAllowance            =   $this->allowanceToReplicate->userAllowance;
            $this->contractualConditionId   =   $this->allowanceToReplicate->contractual_condition_id;
            $this->position                 =   $this->allowanceToReplicate->position;
            $this->allowanceValueId         =   $this->allowanceToReplicate->allowance_value_id;
            $this->grade                    =   $this->allowanceToReplicate->grade;
            $this->law                      =   $this->allowanceToReplicate->law;
            $this->reason                   =   $this->allowanceToReplicate->reason;
            $this->originCommune            =   $this->allowanceToReplicate->origin_commune_id;
            foreach($this->allowanceToReplicate->destinationCommune as $destination){
                $this->setDestination($destination);
            }
            /*
            $this->meansOfTransport         =   $this->allowanceToEdit->means_of_transport;
            $this->roundTrip                =   $this->allowanceToEdit->round_trip;
            $this->passage                  =   $this->allowanceToEdit->passage;
            $this->overnight                =   $this->allowanceToEdit->overnight;
            $this->accommodation            =   $this->allowanceToEdit->overnight;
            $this->overnight                =   $this->allowanceToEdit->accommodation;
            $this->food                     =   $this->allowanceToEdit->food;
            $this->from                     =   $this->allowanceToEdit->from;
            $this->to                       =   $this->allowanceToEdit->to;
            $this->halfDaysOnly              =   $this->allowanceToEdit->half_days_only;

            foreach($this->allowanceToEdit->files as $file){
                $this->setFile($file);
            }
            */
        }
    }

    public function render()
    {
        $allowanceValues = AllowanceValue::where('year', Carbon::now()->year)->get();
        $contractualConditions = ContractualCondition::orderBy('id')->get();

        return view('livewire.allowances.allowances-create', [
            'allowanceValues'       => $allowanceValues,
            'contractualConditions' => $contractualConditions
        ]);
    }

    public function mount($allowanceToEdit, $allowanceToReplicate){
        if(!is_null($allowanceToEdit)){
            $this->allowanceToEdit = $allowanceToEdit;
            $this->setAllowance();

            if($this->allowanceToEdit->contractual_condition_id == '2'){
                //OPCION HONORARIOS: INHABILITO CAMPO LEY, GRADO Y DETALLE DE GRADO
                $this->disabledLaw = 'disabled';
                $this->disabledAllowanceValueId = 'disabled';
                $this->allowanceValueId = 9;
                $this->grade = null;
                $this->disabledGrade = 'disabled';
    
                $this->bheFileStatus = 'active';
                $this->messageBhe = "<b>Estimado Usuario</b>: Usted ha seleccionado la calidad contractual <b>Honorarios</b>, favor adjuntar
                    dicho documento.";
            }
        }
        if(!is_null($allowanceToReplicate)){
            $this->allowanceToReplicate = $allowanceToReplicate;
            $this->setAllowanceToReplicate();
        }

        //UNIDADES ORGANIZACIONALES RESTRINGIDAS PARA VIATICOS
        $this->restrict[] = Parameter::get('ou', 'Externos');
        $this->restrict[] = Parameter::get('ou', 'ExternosAPS');
    }

    public function updatedmeansOfTransport($meansOfTransportId){
        if($meansOfTransportId == "plane" || $meansOfTransportId == "bus"){
            $this->messageMeansOfTransport = "<b>Estimado Usuario</b>: Usted ha seleccionado como medio de 
                transporte Avión o Bus, por lo que debe adjuntar la aprobación de dirección.";
        }
        else{
            $this->messageMeansOfTransport = null;
        }
    }

    public function updatedAccommodation($accomodationId){
        if($accomodationId == 1){
            $this->accommodationSelected = 1;
            if($this->accommodationSelected == 1 || $this->foodSelected == 1){
                $this->disabledHalfDayOnly = "disabled";
                $this->halfDaysOnly = null;
            }
        }
        else{
            $this->accommodationSelected = 0;
            if($this->accommodationSelected == 0 && $this->foodSelected == 0){
                $this->disabledHalfDayOnly = null;
                $this->halfDaysOnly = null;
            }
        }
    }

    public function updatedFood($foodId){
        if($foodId == 1){
            $this->foodSelected = 1;
            if($this->accommodationSelected == 1 || $this->foodSelected == 1){
                $this->disabledHalfDayOnly = "disabled";
                $this->halfDaysOnly = null;
            }
        }
        else{
            $this->foodSelected = 0;
            if($this->accommodationSelected == 0 && $this->foodSelected == 0){
                $this->disabledHalfDayOnly = null;
                $this->halfDaysOnly = null;
            }
        }
    }

    public function updatedLaw($lawId){
        if($lawId == "19664"){
            $this->disabledAllowanceValueId = 'disabled';
            $this->allowanceValueId = 9;
            $this->grade = null;
            $this->disabledGrade = 'disabled';
        }
        else{
            $this->disabledAllowanceValueId = '';
            $this->disabledGrade = '';
        }
    }
}
