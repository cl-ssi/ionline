<?php

namespace App\Models\RequestForms;

use App\Models\Parameters\Parameter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequestForms\RequestForm;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Str;

class EventRequestForm extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'arq_event_request_forms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'signer_user_id',
        'request_form_id',
        'ou_signer_user',
        'position_signer_user',
        'cardinal_number',
        'status',
        'comment',
        'signature_date',
        'event_type',
        'purchaser_id',
        'purchaser_amount',
        'purchaser_observation',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'signature_date' => 'datetime',
    ];

    /**
     * Get the user that signed the event request form.
     *
     * @return BelongsTo
     */
    public function signerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'signer_user_id')->withTrashed();
    }

    /**
     * Get the purchaser for the event request form.
     *
     * @return BelongsTo
     */
    public function purchaser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'purchaser_id')->withTrashed();
    }

    /**
     * Get the organizational unit of the signer user.
     *
     * @return BelongsTo
     */
    public function signerOrganizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'ou_signer_user')->withTrashed();
    }

    /**
     * Get the request form associated with the event request form.
     *
     * @return BelongsTo
     */
    public function requestForm(): BelongsTo
    {
        return $this->belongsTo(RequestForm::class, 'request_form_id');
    }

    /**
     * Get the files for the event request form.
     *
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(EventRequestFormFile::class);
    }

    public function getStatusValueAttribute(){
        switch ($this->status) {
            case "pending":
                return 'Pendiente';
            case "rejected":
                return 'Rechazado';
            case "approved":
                return 'Aprobado';
            case "does_not_apply":
                return 'No aplica';
        }
    }

    public function getEventTypeValueAttribute(){
        switch ($this->event_type) {
            case "technical_review_event":
                return 'Evaluación Técnica';
            case "leader_ship_event":
                return 'Jefatura Directa';
            case "superior_leader_ship_event":
                return 'Jefatura Superior';
            case "pre_finance_event":
                return 'Refrendación Presupuestaria';
            case "finance_event":
                return 'Finanzas';
            case "supply_event":
                return 'Abastecimiento';
            case "pre_budget_event":
                return 'Solicitud Nuevo Presupuesto';
            case "pre_finance_budget_event":
                return 'Solicitud Nuevo Presupuesto';
            case "budget_event":
                return 'Solicitud Nuevo Presupuesto';
        }
    }

    public static function createTechnicalReviewEvent(RequestForm $requestForm){
        $event                      =   new EventRequestForm();
        $event->ou_signer_user      =   $requestForm->technical_review_ou_id;
        $event->cardinal_number     =   0;
        $event->status              =   'pending';
        $event->event_type          =   'technical_review_event';
        $event->requestForm()->associate($requestForm);
        $event->save();
    }

    public static function createLeadershipEvent(RequestForm $requestForm){
        $count = 1;
        $contractManagerBelongsHAH  = $requestForm->contractOrganizationalUnit->establishment_id == Parameter::get('establishment', 'HospitalAltoHospicio');
        $event                      =   new EventRequestForm();
        $event->ou_signer_user      =   $contractManagerBelongsHAH 
                                        ? ($requestForm->contractOrganizationalUnit->level > 2 ? $requestForm->contractOrganizationalUnit->getOrganizationalUnitByLevel(2)->id : ($requestForm->contractOrganizationalUnit->father->id ?? $requestForm->contract_manager_ou_id) ) 
                                        : $requestForm->contract_manager_ou_id;
        $event->cardinal_number     =   $count++;
        $event->status              =   'pending';
        $event->event_type          =   'leader_ship_event';
        $event->requestForm()->associate($requestForm);
        $event->save();

        $tic_sst = Parameter::get('establishment', 'SSTarapaca');
        $tic_hah = Parameter::get('establishment', 'HospitalAltoHospicio');

        if( $requestForm->contract_manager_ou_id == Parameter::get('ou', 'DeptoTIC', $tic_sst) && $requestForm->request_user_ou_id == Parameter::get('ou', 'DeptoTIC', $tic_hah)){
            $event                      =   new EventRequestForm();
            $event->ou_signer_user      =   Parameter::get('ou', 'DeptoRRFF');
            $event->cardinal_number     =   $count++;
            $event->status              =   'pending';
            $event->event_type          =   'leader_ship_event';
            $event->requestForm()->associate($requestForm);
            $event->save();
        }

        if($requestForm->superior_chief == 1 || $contractManagerBelongsHAH){
            $event                      =   new EventRequestForm();
            $event->ou_signer_user      =   $contractManagerBelongsHAH
                                            ? Parameter::get('ou', 'SDAHAH') 
                                            : ($requestForm->contractOrganizationalUnit->father->id ?? $requestForm->contract_manager_ou_id);
            $event->cardinal_number     =   $count++;
            $event->status              =   'pending';
            $event->event_type          =   'superior_leader_ship_event';
            $event->requestForm()->associate($requestForm);
            $event->save();
        }

        return true;
    }

    public static function createPreFinanceEvent(RequestForm $requestForm) {
        $next_event_number = $requestForm->eventRequestForms()->latest('id')->first()->cardinal_number + 1;
        // SST = prefinance_ou_id = 40
        // HAH = prefinance_ou_id = 339
        // HETG = prefinance_ou_id = 111

        // SST = prefinance_sub_31_ou_id = 40
        // HAH = prefinance_sub_31_ou_id = 40
        // HETG = prefinance_sub_31_ou_id = 111

        if($requestForm->associateProgram->Subtitle->name == 31) {
            // Obtener la ou_id del la unidad "prefinance" del establecimiento al que pertenece el administrador de contrato para subtitulo 31
            $ou_id = Parameter::get('Abastecimiento','prefinance_sub_31_ou_id', $requestForm->contractOrganizationalUnit->establishment_id);
        }
        else {
            // Obtener la ou_id del la unidad "prefinance" del establecimiento al que pertenece el administrador de contrato para los demás subtitulos
            $ou_id = Parameter::get('Abastecimiento','prefinance_ou_id', $requestForm->contractOrganizationalUnit->establishment_id); 
        }

        $event                      =   new EventRequestForm();
        $event->ou_signer_user      =   $ou_id;
        $event->cardinal_number     =   $next_event_number; //$requestForm->superior_chief == 1 ? 3 : 2;
        $event->status              =   'pending';
        $event->event_type          =   'pre_finance_event';
        $event->requestForm()->associate($requestForm);
        $event->save();
        return true;
    }

    public static function createFinanceEvent(RequestForm $requestForm) {
        $next_event_number = $requestForm->eventRequestForms()->latest('id')->first()->cardinal_number + 1;
        // SST = finance_ou_id = 40
        // HAH = finance_ou_id = 337
        // HETG = finance_ou_id = 87

        // SST = finance_sub_31_ou_id = 40
        // HAH = finance_sub_31_ou_id = 40
        // HETG = finance_sub_31_ou_id = 87

        if($requestForm->associateProgram->Subtitle->name == 31) {
            // Obtener la ou_id del la unidad "prefinance" del establecimiento al que pertenece el administrador de contrato para subtitulo 31
            $ou_id = Parameter::get('Abastecimiento','finance_sub_31_ou_id', $requestForm->contractOrganizationalUnit->establishment_id);
        }
        else {
            // Obtener la ou_id del la unidad "prefinance" del establecimiento al que pertenece el administrador de contrato para los demás subtitulos
            $ou_id = Parameter::get('Abastecimiento','finance_ou_id', $requestForm->contractOrganizationalUnit->establishment_id); 
        }

        $event                      =   new EventRequestForm();
        $event->ou_signer_user      =   $ou_id;
        $event->cardinal_number     =   $next_event_number; //$requestForm->superior_chief == 1 ? 4 : 3;
        $event->status              =   'pending';
        $event->event_type          =   'finance_event';
        $event->requestForm()->associate($requestForm);
        $event->save();
        return true;
    }

    public static function createSupplyEvent(RequestForm $requestForm) {
        $next_event_number = $requestForm->eventRequestForms()->latest('id')->first()->cardinal_number + 1;
        // SST = supply_sub_31_ou_id = 37
        // SST = supply_ou_id = 37

        // HAH = supply_sub_31_ou_id = 37
        // HAH = supply_ou_id = 334

        // HETG = supply_sub_31_ou_id = 112
        // HETG = supply_ou_id = 112

        if($requestForm->associateProgram->Subtitle->name == 31) {
            // Obtener la ou_id del la unidad "prefinance" del establecimiento al que pertenece el administrador de contrato para subtitulo 31
            $ou_id = Parameter::get('Abastecimiento','supply_sub_31_ou_id', $requestForm->contractOrganizationalUnit->establishment_id);
        }
        else {
            // Obtener la ou_id del la unidad "prefinance" del establecimiento al que pertenece el administrador de contrato para los demás subtitulos
            $ou_id = Parameter::get('Abastecimiento','supply_ou_id', $requestForm->contractOrganizationalUnit->establishment_id); 
        }

        $event                      =   new EventRequestForm();
        $event->ou_signer_user      =   $ou_id;
        $event->cardinal_number     =   $next_event_number;//$requestForm->superior_chief == 1 ? 5 : 4;
        $event->status              =   'pending';
        $event->event_type          =   'supply_event';
        $event->requestForm()->associate($requestForm);
        $event->save();
        return true;
    }

    public static function createNewBudgetEvent(RequestForm $requestForm)
    {
        $next_event_number = $requestForm->eventRequestForms()->latest('id')->first()->cardinal_number + 1;
        // TODO: Cambiar a parametros sin nombre de establecimiento, ver ejemplo arriba
        // $result = $requestForm->associateProgram->Subtitle->name != 31 && $requestForm->contractOrganizationalUnit->establishment_id == Parameter::where('parameter', 'HospitalAltoHospicio')->first()->value;

        // $parameter = $result ? 'AbastecimientoHAH' : 'AbastecimientoSSI';
        // $ouSearch = Parameter::where('module', 'ou')->where('parameter', $parameter)->first()->value;

        if($requestForm->associateProgram->Subtitle->name == 31) {
            // Obtener la ou_id del la unidad "supply" del establecimiento al que pertenece el administrador de contrato para subtitulo 31
            $ou_id = Parameter::get('Abastecimiento','supply_sub_31_ou_id', $requestForm->contractOrganizationalUnit->establishment_id);
        }
        else {
            // Obtener la ou_id del la unidad "supply" del establecimiento al que pertenece el administrador de contrato para los demás subtitulos
            $ou_id = Parameter::get('Abastecimiento','supply_ou_id', $requestForm->contractOrganizationalUnit->establishment_id); 
        }

        $event                      = new EventRequestForm();
        $event->ou_signer_user      =   $ou_id; // Abastecimiento SSI o HAH
        $event->cardinal_number     =   $next_event_number++;//$requestForm->superior_chief == 1 ? 6 : 5;
        $event->status              =   'pending';
        $event->event_type          =   'pre_budget_event';
        $event->purchaser_amount    =   $requestForm->newBudget - $requestForm->estimated_expense;
        $event->purchaser_observation = request()->purchaser_observation;
        $event->purchaser_id        =   auth()->user()->id;
        $event->requestForm()->associate($requestForm);
        $event->save();

        self::createFile($event);

        // $parameter = $result ? 'RefrendacionHAH' : 'FinanzasSSI';
        // $ouSearch = Parameter::where('module', 'ou')->where('parameter', $parameter)->first()->value;
        if($requestForm->associateProgram->Subtitle->name == 31) {
            // Obtener la ou_id del la unidad "prefinance" del establecimiento al que pertenece el administrador de contrato para subtitulo 31
            $ou_id = Parameter::get('Abastecimiento','prefinance_sub_31_ou_id', $requestForm->contractOrganizationalUnit->establishment_id);
        }
        else {
            // Obtener la ou_id del la unidad "prefinance" del establecimiento al que pertenece el administrador de contrato para los demás subtitulos
            $ou_id = Parameter::get('Abastecimiento','prefinance_ou_id', $requestForm->contractOrganizationalUnit->establishment_id); 
        }
        $event                      =   new EventRequestForm();
        $event->ou_signer_user      =   $ou_id; // Refrendacion SSI o HAH
        $event->cardinal_number     =   $next_event_number++; //$requestForm->superior_chief == 1 ? 7 : 6;
        $event->status              =   'pending';
        $event->event_type          =   'pre_finance_budget_event';
        $event->purchaser_amount    =   $requestForm->newBudget - $requestForm->estimated_expense;
        $event->purchaser_observation = request()->purchaser_observation;
        $event->purchaser_id        =   auth()->user()->id;
        $event->requestForm()->associate($requestForm);
        $event->save();

        self::createFile($event);

        // $parameter = $result ? 'FinanzasHAH' : 'FinanzasSSI';
        // $ouSearch = Parameter::where('module', 'ou')->where('parameter', $parameter)->first()->value;
        if($requestForm->associateProgram->Subtitle->name == 31) {
            // Obtener la ou_id del la unidad "finance" del establecimiento al que pertenece el administrador de contrato para subtitulo 31
            $ou_id = Parameter::get('Abastecimiento','finance_sub_31_ou_id', $requestForm->contractOrganizationalUnit->establishment_id);
        }
        else {
            // Obtener la ou_id del la unidad "prefinance" del establecimiento al que pertenece el administrador de contrato para los demás subtitulos
            $ou_id = Parameter::get('Abastecimiento','finance_ou_id', $requestForm->contractOrganizationalUnit->establishment_id); 
        }
        $event                      = new EventRequestForm();
        $event->ou_signer_user      =   $ou_id; //Finanzas
        $event->cardinal_number     =   $next_event_number; //$requestForm->superior_chief == 1 ? 8 : 7;
        $event->status              =   'pending';
        $event->event_type          =   'budget_event';
        $event->purchaser_amount    =   $requestForm->newBudget - $requestForm->estimated_expense;
        $event->purchaser_observation = request()->purchaser_observation;
        $event->purchaser_id        =   auth()->user()->id;
        $event->requestForm()->associate($requestForm);
        $event->save();

        self::createFile($event);

        return true;
    }

    /**
     * @param EventRequestForm $event
     * @return void
     */
    public static function createFile(EventRequestForm $event)
    {
        if (request()->hasFile('files')) {
            foreach (request()->file('files') as $file) {
                $eventRequestFormFile = new EventRequestFormFile();
                $eventRequestFormFile->extension = '.' . $file->extension();
                $eventRequestFormFile->name = $file->getClientOriginalName();
                $eventRequestFormFile->event_request_form_id = $event->id;
                $eventRequestFormFile->file = $file->storeAs('ionline/event_request_forms', Str::uuid() . $eventRequestFormFile->extension, ['disk' => 'gcs']);
                $eventRequestFormFile->save();
            }
        }
    }

    /**
     * Verifica si el evento actual es el último
     * @return bool
     */
    public function isLast()
    {
        $eventQuantity = $this->requestForm->eventRequestForms()->count();
        return ($eventQuantity === $this->cardinal_number);
    }

}
