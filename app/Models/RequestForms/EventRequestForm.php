<?php

namespace App\Models\RequestForms;

use App\Models\Parameters\Parameter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequestForms\RequestForm;
use App\Rrhh\OrganizationalUnit;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

class EventRequestForm extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'signer_user_id', 'request_form_id', 'ou_signer_user', 'position_signer_user', 'cardinal_number', 'status',
        'comment', 'signature_date', 'event_type', 'purchaser_id', 'purchaser_amount','purchaser_observation'
    ];


    public function signerUser(){
        return $this->belongsTo(User::class, 'signer_user_id')->withTrashed();
    }

    public function purchaser(){
        return $this->belongsTo(User::class, 'purchaser_id')->withTrashed();
    }

    public function signerOrganizationalUnit(){
        return $this->belongsTo(OrganizationalUnit::class, 'ou_signer_user');
      }

    public function requestForm() {
        return $this->belongsTo(RequestForm::class, 'request_form_id');
    }

    public function files()
    {
        return $this->hasMany(EventRequestFormFile::class);
    }

    public function getStatusValueAttribute(){
      switch ($this->status) {
          case "pending":
              return 'Pendiente';
              break;
          case "rejected":
              return 'Rechazado';
              break;
          case "approved":
              return 'Aprobado';
              break;
          case "does_not_apply":
              return 'No aplica';
              break;
      }
    }

    public function getEventTypeValueAttribute(){
        switch ($this->event_type) {
            case "technical_review_event":
                return 'Evaluación Técnica';
                break;
            case "leader_ship_event":
                return 'Jefatura Directa';
                break;
            case "superior_leader_ship_event":
                return 'Jefatura Superior';
                break;
            case "pre_finance_event":
                return 'Refrendación Presupuestaria';
                break;
            case "finance_event":
                return 'Finanzas';
                break;
            case "supply_event":
                return 'Abastecimiento';
                break;
            case "pre_budget_event":
                return 'Solicitud Nuevo Presupuesto';
                break;
            case "budget_event":
                return 'Solicitud Nuevo Presupuesto';
                break;
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
        $contractManagerBelongsHAH  = $requestForm->contractOrganizationalUnit->establishment_id == Parameter::where('parameter', 'HospitalAltoHospicio')->first()->value;
        $event                      =   new EventRequestForm();
        $event->ou_signer_user      =   $contractManagerBelongsHAH 
                                        ? ($requestForm->contractOrganizationalUnit->level > 2 ? $requestForm->contractOrganizationalUnit->getOrganizationalUnitByLevel(2)->id : $requestForm->contractOrganizationalUnit->father->id ) 
                                        : $requestForm->contract_manager_ou_id;
        $event->cardinal_number     =   1;
        $event->status              =   'pending';
        $event->event_type          =   'leader_ship_event';
        $event->requestForm()->associate($requestForm);
        $event->save();

        if($requestForm->superior_chief == 1 || $contractManagerBelongsHAH){
            $event                      =   new EventRequestForm();
            $event->ou_signer_user      =   $contractManagerBelongsHAH
                                            ? Parameter::where('parameter', 'SDAHAH')->first()->value 
                                            : $requestForm->contractOrganizationalUnit->father->id;
            $event->cardinal_number     =   2;
            $event->status              =   'pending';
            $event->event_type          =   'superior_leader_ship_event';
            $event->requestForm()->associate($requestForm);
            $event->save();
        }

        return true;
    }

    public static function createPreFinanceEvent(RequestForm $requestForm){
        $ouSearch = Parameter::where('module', 'ou')->where('parameter', 'FinanzasSSI')->first()->value;
        $event                      =   new EventRequestForm();
        $event->ou_signer_user      =   $ouSearch;
        $event->cardinal_number     =   $requestForm->superior_chief == 1 ? 3 : 2;
        $event->status              =   'pending';
        $event->event_type          =   'pre_finance_event';
        $event->requestForm()->associate($requestForm);
        $event->save();
        return true;
    }

    public static function createFinanceEvent(RequestForm $requestForm){
        $ouSearch = Parameter::where('module', 'ou')->where('parameter', 'FinanzasSSI')->first()->value;
        $event                      =   new EventRequestForm();
        $event->ou_signer_user      =   $ouSearch;
        $event->cardinal_number     =   $requestForm->superior_chief == 1 ? 4 : 3;
        $event->status              =   'pending';
        $event->event_type          =   'finance_event';
        $event->requestForm()->associate($requestForm);
        $event->save();
        return true;
    }

    public static function createSupplyEvent(RequestForm $requestForm){
        $parameter = $requestForm->contractOrganizationalUnit->establishment_id == Parameter::where('parameter', 'HospitalAltoHospicio')->first()->value ? 'AbastecimientoHAH' : 'AbastecimientoSSI';
        $ouSearch = Parameter::where('module', 'ou')->where('parameter', $parameter)->first()->value;
        $event                      =   new EventRequestForm();
        $event->ou_signer_user      =   $ouSearch;
        $event->cardinal_number     =   $requestForm->superior_chief == 1 ? 5 : 4;
        $event->status              =   'pending';
        $event->event_type          =   'supply_event';
        $event->requestForm()->associate($requestForm);
        $event->save();
        return true;
    }

    public static function createNewBudgetEvent(RequestForm $requestForm)
    {
        $parameter = $requestForm->contractOrganizationalUnit->establishment_id == Parameter::where('parameter', 'HospitalAltoHospicio')->first()->value ? 'AbastecimientoHAH' : 'AbastecimientoSSI';
        $ouSearch = Parameter::where('module', 'ou')->where('parameter', $parameter)->first()->value;
        $event = new EventRequestForm();
        $event->ou_signer_user      =   $ouSearch; // Abastecimiento SSI o HAH
        $event->cardinal_number     =   $requestForm->superior_chief == 1 ? 6 : 5;
        $event->status              =   'pending';
        $event->event_type          =   'pre_budget_event';
        $event->purchaser_amount    =   $requestForm->newBudget - $requestForm->estimated_expense;
        $event->purchaser_observation = request()->purchaser_observation;
        $event->purchaser_id        =   Auth()->user()->id;
        $event->requestForm()->associate($requestForm);
        $event->save();

        self::createFile($event);

        $ouSearch = Parameter::where('module', 'ou')->where('parameter', 'FinanzasSSI')->first()->value;
        $event = new EventRequestForm();
        $event->ou_signer_user      =   $ouSearch; //Finanzas
        $event->cardinal_number     =   $requestForm->superior_chief == 1 ? 7 : 6;
        $event->status              =   'pending';
        $event->event_type          =   'budget_event';
        $event->purchaser_amount    =   $requestForm->newBudget - $requestForm->estimated_expense;
        $event->purchaser_observation = request()->purchaser_observation;
        $event->purchaser_id        =   Auth()->user()->id;
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

    protected $dates = [
        'signature_date',
    ];


    protected $table = 'arq_event_request_forms';
}
