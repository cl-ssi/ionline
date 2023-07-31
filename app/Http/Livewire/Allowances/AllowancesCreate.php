<?php

namespace App\Http\Livewire\Allowances;

use Livewire\Component;

use App\Models\Allowances\Allowance;
use App\Models\Allowances\Destination;
use App\Models\Allowances\AllowanceFile;
use App\Models\Allowances\AllowanceSign;

use App\Models\Parameters\AllowanceValue;
use App\Models\Parameters\ContractualCondition;
use App\Models\ClCommune;
use App\User;
use App\Notifications\Allowances\NewAllowance;
use App\Rrhh\Authority;
use App\Models\Parameters\Parameter;
use App\Models\ClLocality;


use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AllowancesCreate extends Component
{
    use WithFileUploads;

    public $idAllowance, $userAllowance, $contractualConditionId, $position, $cfgAllowanceValue, $allowanceValueId, 
        $grade, $law, $reason, 

        $originCommune, $destinations,
        
        $meansOfTransport, $roundTrip, $passage, $overnight, $from, $to, $halfDaysOnly,
        $dayValue, $halfDayValue;
    
    public $disabledLaw = '';

    /* Archivo */
    public $idFile;
    public $file;
    public $fileName;
    public $fileAttached;
    public $files, $key;

    /* Destinos */
    /* Listeners */
    public $selectedCommuneId;
    public $searchedCommune;

    public $i;
    public $communeInputId;
    public $localities;
    public $selectedLocality;
    public $description;
    public $validateMessages;
    public $destinationCommune;

    /* Aprobaciones */
    public $positionFinance;

    /* Allowance to edit */
    public $allowanceToEdit;
    // public $userAllowance

    protected $listeners = ['emitPosition', 'emitPositionValue', 'userSelected', 'savedDestinations', 'selectedInputId',
        'searchedCommune'];
    
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
            
            'from.required'                     => 'Debe ingresar Fecha Desde.',
            'to.required'                       => 'Debe ingresar Fecha Hasta.',

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
            'grade'                                                 => 'required',
            ($this->contractualConditionId == "2") ? 'law' : 'law'  => ($this->contractualConditionId == "2") ? '' : 'required',
            'reason'                                                => 'required',

            'originCommune'                                         => 'required',
            'destinations'                                          => 'required',

            'meansOfTransport'                                      => 'required',
            'roundTrip'                                             => 'required',
            'passage'                                               => 'required',
            'overnight'                                             => 'required',

            'from'                                                  => 'required',
            'to'                                                    => 'required',

            'files'                                                 => 'required'
        ]);

        $currentAllowances = Allowance::where('user_allowance_id', $this->userAllowance->id)
                ->whereDate('from', '>=', $this->from)
                ->WhereDate('to', '<=', $this->to)
                ->get();
        
        if($currentAllowances->count() > 0){
            // return back()->with('error', 'El funcionario ya dispone de viático(s) para la fecha solicitada, favor consulta historial de funcionario');;
            dd('Aquí');
        }
        else{
            /* SE GUARDA EL NUEVO VIÁTICO */
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
                        'grade'                             => $this->grade,
                        'law'                               => $this->law,
                        'establishment_id'                  => $this->userAllowance->organizationalUnit->establishment->id,
                        'organizational_unit_allowance_id'  => $this->userAllowance->organizationalUnit->id, 
                        'reason'                            => $this->reason,
                        'overnight'                         => $this->overnight, 
                        'passage'                           => $this->passage, 
                        'means_of_transport'                => $this->meansOfTransport, 
                        'origin_commune_id'                 => $this->originCommune->id,
                        'round_trip'                        => $this->roundTrip,
                        'from'                              => $this->from, 
                        'to'                                => $this->to,
                        'total_days'                        => $this->allowanceTotalDays(),
                        'half_days_only'                    => $this->halfDaysOnly,
                        'day_value'                         => $this->allowanceDayValue(),
                        'half_day_value'                    => $this->allowanceHalfDayValue(),
                        'total_value'                       => $this->allowanceTotalValue(),
                        'creator_user_id'                   => Auth::user()->id, 
                        'creator_ou_id'                     => Auth::user()->organizationalUnit->id
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
                        'locality_id'   => $destination['locality_id'], 
                        'description'   => $destination['description'],
                        'allowance_id'  => $alw->id
                    ]
                );
            }

            /* SE GUARDAN LOS ARCHIVOS DEL VIÁTICO */
            foreach($this->files as $keyFiles => $allowanceFile){
                AllowanceFile::updateOrCreate(
                    [
                        'id' => $this->idFile,
                    ],
                    [
                        'name'          => $allowanceFile['fileName'],
                        'file'          => $allowanceFile['file'], 
                        'allowance_id'  => $alw->id, 
                        'user_id'       => Auth::user()->id, 
                    ]
                );
            }

            /* APROBACION SIRH */
            $this->sirhSign($alw);

            /* APROBACION U.O. DE ACUERDO SOLICITANTE */
            $this->ouSign($alw);

            /* APROBACION U.O. DE FINANZAS */
            $this->financeSign($alw);

            session()->flash('success', 'Estimados Usuario, se ha creado exitosamente la solicitud de viatico N°'.$alw->id);
            return redirect()->route('allowances.index');
        }
    }

    /* Listeners */
    public function userSelected($userAllowance)
    {
        $this->userAllowance = User::find($userAllowance);
        $this->prueba        = $this->userAllowance->id;
    }

    public function emitPosition($emitPosition)
    {
        $this->position = $emitPosition;
    }

    public function emitPositionValue($emitPositionValue)
    {
        $this->position = $emitPositionValue;
    }

    /* Cálculo de días */
    public function allowanceTotalDays(){

            if($this->from == $this->to){
                return 0.5;
            }
            else{
                if($this->halfDaysOnly == 1){
                    return Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to)) + 1;
                }
                else{
                    return Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to)) + 0.5;
                }
            }
    }

    public function allowanceValueId(){
        $this->cfgAllowanceValue = AllowanceValue::find($this->allowanceValueId);
        return $this->cfgAllowanceValue->id;
    }

    public function allowanceDayValue(){
        if($this->allowanceTotalDays() >= 1){
            $this->dayValue = $this->cfgAllowanceValue->value;
            return $this->cfgAllowanceValue->value;
        }
    }

    public function allowanceHalfDayValue(){
        $this->halfDayValue = $this->cfgAllowanceValue->value * 0.4;
        return $this->cfgAllowanceValue->value * 0.4;
    }

    public function allowanceTotalValue(){
        if($this->allowanceTotalDays() >= 1){
            return ($this->allowanceDayValue() * intval($this->allowanceTotalDays())) + $this->allowanceHalfDayValue();
        }
        else{
            return $this->allowanceHalfDayValue();
        }
    }

    /* Métodos de Aprobación */

    public function sirhSign(Allowance $alw)
    {
        //SE AGREGA AL PRINCIPIO VISACIÓN SIRH
        $allowance_sing_sirh                            = new AllowanceSign();
        $allowance_sing_sirh->position                  = 1;
        $allowance_sing_sirh->event_type                = 'sirh';
        $allowance_sing_sirh->status                    = 'pending';
        $allowance_sing_sirh->allowance_id              = $alw->id;
        $allowance_sing_sirh->organizational_unit_id    = 40;
        $allowance_sing_sirh->save();

        //SE NOTIFICA PARA INICIAR EL PROCESO DE APROBACIONES
        $notificationSirhPermissionUsers = User::permission('Allowances: sirh')->get();
        foreach($notificationSirhPermissionUsers as $notificationSirhPermissionUser){
            $notificationSirhPermissionUser->notify(new NewAllowance($alw));
        }
    }

    public function ouSign(Allowance $alw){
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
    }

    public function financeSign(Allowance $alw){
        $allowance_sing_finance = new AllowanceSign();
        $allowance_sing_finance->position = $this->positionFinance;
        $allowance_sing_finance->event_type = 'chief financial officer';
        $allowance_sing_finance->organizational_unit_id = Parameter::where('module', 'ou')->where('parameter', 'FinanzasSSI')->first()->value;
        $allowance_sing_finance->allowance_id = $alw->id;
        $allowance_sing_finance->save();
    }

    public function updatedContractualConditionId($contractualConditionId){
        if($contractualConditionId == '2'){
            $this->disabledLaw = 'disabled';
        }
        else{
            $this->disabledLaw = '';
        }
    }

    /*  Metodos para Destino */

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

    public function savedDestinations($destinations)
    {
        $this->destinations = $destinations; 
    }

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
        $this->emit('onClearUserSearch');
    }

    public function cleanDestination()
    {
        $this->selectedLocality = null;
        $this->description = null;
    }

    public function deleteDestination($key)
    {
        /* SOLO PARA EL ELIMINAR EN CREATE */
        unset($this->destinations[$key]);
    }

    private function setDestination($destination)
    {
        $this->destinations[] = [
            'id'            => $destination->id,
            'commune_id'    => $destination->commune->id,
            'commune_name'  => $destination->commune->name,
            'locality_id'   => $destination->locality->id,
            'locality_name' => $destination->locality->name,
            'description'   => $destination->description
        ];
    }

    /* Metodos para Archivos */
    public function addFile()
    {
        // dd($this->file);
        $this->validateMessage = 'file';
        $validatedData = $this->validate([
            'fileName'                                      => 'required',
            ($this->file) ? 'fileAttached' : 'fileAttached' => ($this->file) ? '' : 'required' 
        ]);

        $now = Carbon::now()->format('Y_m_d_H_i_s');
        $this->fileAttached = $this->file ? $this->file->storeAs('/ionline/allowances/allowance_docs', $now.'_alw_file.'.$this->file->extension(), 'gcs') : null;

        $this->files[] = [
            'id'        => '',
            'fileName'  => $this->fileName,
            'file'      => $this->fileAttached
        ];

        $this->cleanFile();
    }

    public function cleanFile()
    {   
        $this->fileName = null;
        $this->file     = null;
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
            $this->allowanceValueId         =   $this->allowanceToEdit->allowance_value_id;
            $this->grade                    =   $this->allowanceToEdit->grade;
            $this->law                      =   $this->allowanceToEdit->law;
            $this->reason                   =   $this->allowanceToEdit->reason;

            foreach($this->allowanceToEdit->destinationCommune as $destination){
                $this->setDestination($destination);
            }

            $this->meansOfTransport         =   $this->allowanceToEdit->means_of_transport;
            $this->roundTrip                =   $this->allowanceToEdit->round_trip;
            $this->passage                  =   $this->allowanceToEdit->passage;
            $this->overnight                =   $this->allowanceToEdit->overnight;
            $this->from                     =   $this->allowanceToEdit->from;
            $this->to                       =   $this->allowanceToEdit->to;
            $this->halfDayValue             =   $this->allowanceToEdit->halfDayValue;

            foreach($this->allowanceToEdit->files as $file){
                $this->setFile($file);
            }
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

    public function mount($allowanceToEdit){
        if(!is_null($allowanceToEdit)){
            $this->allowanceToEdit = $allowanceToEdit;
            $this->setAllowance();
        }
    }
}
