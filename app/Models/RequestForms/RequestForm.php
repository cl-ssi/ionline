<?php

namespace app\Models\RequestForms;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\User;
use App\Rrhh\OrganizationalUnit;
use App\Models\RequestForms\ItemRequestForm;
use App\Models\RequestForms\EventRequestForm;

class RequestForm extends Model
{
    protected $fillable = [
        'applicant_position', 'estimated_expense', 'program', 'justification', 'type_form', 'bidding_number','purchase_mechanism', 'creator_user_id',
        'supervisor_user_id', 'applicant_user_id', 'applicant_ou_id', 'status'
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'creator_user_id');
    }

    public function applicant(){
      return $this->belongsTo(User::class, 'applicant_user_id');
    }

    public function supervisor(){
      return $this->belongsTo(User::class, 'supervisor_user_id');
    }

    public function organizationalUnit(){
      return $this->belongsTo(OrganizationalUnit::class, 'applicant_ou_id');
    }

    public function itemRequestForms() {
        return $this->hasMany(ItemRequestForm::class);
    }

    public function eventRequestForms() {
        return $this->hasMany(EventRequestForm::class);
    }

    public function getPurchaseMechanism(){
      switch ($this->purchase_mechanism) {
          case "cm<1000":
              return 'Convenio Marco < 1000 UTM';
              break;
          case "cm>1000":
              return 'Convenio Marco > 1000 UTM';
              break;
          case "lp":
              return 'Licitación Pública';
              break;
          case "td":
              return 'Trato Directo';
              break;
          case "ca":
              return 'Compra Ágil';
              break;
              case "":
              break;
      }
    }

    /*Regresa estado de firma de Eventos*/
    public function eventSign($event_type) {
      if(!is_null($this->eventRequestForms()->where('status', 'approved')->where('event_type',$event_type)->first()))
        return '<i class="text-success fas fa-check"></i>';//aprovado
      elseif(!is_null($this->eventRequestForms()->where('status', 'rejected')->where('event_type',$event_type)->first()))
        return '<i class="text-danger fas fa-ban"></i>';//rechazado
      else
        return '<i class="text-info far fa-hourglass"></i>';//en espera
    }

    public function eventSingStatus($event_type) {
      if(!is_null($this->eventRequestForms()->where('status', 'approved')->where('event_type',$event_type)->first()))
        return 'approved';//aprovado
      elseif(!is_null($this->eventRequestForms()->where('status', 'rejected')->where('event_type',$event_type)->first()))
        return 'rejected';//rechazado
      else
        return 'created';//en espera
    }

    public function rejectedTime() {
      $event = $this->eventRequestForms()->where('status', 'rejected')->first();
      if(!is_null($event)){
        $date = new Carbon($event->signature_date);
        return $date->format('d-m-Y');
      }
    }

    public function createdDate() {
      $date = new Carbon($this->created_at);
      return $date->format('d-m-Y');
    }

    public function rejectedName() {
      $event = $this->eventRequestForms()->where('status', 'rejected')->first();
      if(!is_null($event))
        return $event->signerUser->tinnyName();
    }

    public function rejectedComment() {
      $event = $this->eventRequestForms()->where('status', 'rejected')->first();
      if(!is_null($event))
        return $event->comment;
    }


    /*
    public function getFormatEstimatedExpenseAttribute()
    {
        //return number_format($this->estimated_expense,0,",",".");
    }

    public function getCreationDateAttribute()
    {
      //return $this->created_at->format('d-m-Y H:i:s');
    }

    /*  DETERMINAR FECHA DE VENCIMIENTO */
    public function getEndDateAttribute()
    {
/*      if($this->status == "closed"){
        return $this->updated_at->format('d-m-Y H:i:s');
      }
      else{
        return null;
      }*/
    }

    /* TIEMPO TRANSCURRIDO DEL TICKET */
    public function getElapsedTime()
    {
      $day = Carbon::now()->diffInDays($this->created_at);
      if($day<=1)
        return $day.' día.';
      else
        return $day.' días.';
    }

    public function getFormRequestNumberAttribute()
    {
      //return $this->id;
    }

    public function getEstimatedExpenseFormatAttribute()
    {
      //return number_format($this->estimated_expense, 0, ',', '.');
    }

    public function getEstimatedFinanceExpenseFormatAttribute()
    {
      //return number_format($this->finance_expense, 0, ',', '.');
    }

    public function getProgramBalanceFormatAttribute()
    {
      //return number_format($this->program_balance, 0, ',', '.');
    }

    public function getAvailableBalanceFormatAttribute()
    {
      //return number_format($this->available_balance, 0, ',', '.');
    }

/*
    public function requestformfiles() {
        return $this->hasMany('\App\RequestForms\RequestFormFile');
    }

    public function requestformevents() {
        return $this->hasMany('\App\RequestForms\RequestFormEvent');
    }

    public function whorequest() {
        return $this->belongsTo('App\User', 'whorequest_id');
    }

    public function whorequest_unit() {
        return $this->belongsTo('App\User');
    }

    public function whoauthorize() {
        return $this->belongsTo('App\User', 'whoauthorize_id');
    }

    public function whoauthorize_unit() {
        return $this->belongsTo('App\User');
    }

    public function whoauthorize_finance() {
        return $this->belongsTo('App\User', 'finance_id');
    }
*/

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'arq_request_forms';
}
