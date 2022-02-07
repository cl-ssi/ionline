<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\User;
use App\Rrhh\OrganizationalUnit;
use App\Models\RequestForms\PurchasingProcess;
use App\Models\RequestForms\ItemRequestForm;
use App\Models\RequestForms\EventRequestForm;
use App\Models\Parameters\PurchaseType;
use App\Models\Parameters\PurchaseUnit;
use App\Models\Parameters\PurchaseMechanism;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class RequestForm extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    /* NORMALIZACIÓN JORGE MIRANDA - ALVARO LUPA NOV 2021 */

    /*

    protected $fillable = [
        'type_form', 'status', 'name', 'user_request_id', 'ou_user_request_id', 'user_request_position',
        'contract_manager_id', 'superior_chief', 'justification', 'request_form_id'
    ];

    public function userRequest() {
        return $this->belongsTo(User::class, 'user_request_id');
    }

    public function requestformfiles() {
        return $this->hasMany('\App\RequestForms\RequestFormFile');
    }

    public function contractManager() {
        return $this->belongsTo(User::class, 'contract_manager_id');
    }

    */

    protected $fillable = [
        'request_form_id', 'estimated_expense', 'program', 'contract_manager_id',
        'name', 'subtype', 'justification', 'superior_chief',
        'type_form', 'bidding_number', 'request_user_id',
        'request_user_ou_id', 'contract_manager_ou_id', 'status', 'sigfe',
        'purchase_unit_id', 'purchase_type_id', 'purchase_mechanism_id', 'type_of_currency',
        'folio', 'has_increased_expense', 'signatures_file_id', 'old_signatures_file_id'
    ];

    public function getFolioAttribute($value){
      return $value . ($this->has_increased_expense ? '-M' : '');
    }

    public function father(){
      return $this->belongsTo(RequestForm::class, 'request_form_id');
    }

    public function children(){
      return $this->hasMany(RequestForm::class);
    }

    public function user() {
      return $this->belongsTo(User::class, 'request_user_id');
    }

    public function messages() {
        return $this->hasMany(RequestFormMessage::class);
    }

    public function requestFormFiles() {
        return $this->hasMany(RequestFormFile::class);
    }

    public function contractManager() {
        return $this->belongsTo(User::class, 'contract_manager_id');
    }

    public function purchasers(){
        return$this->belongsToMany(User::class, 'arq_request_forms_users', 'request_form_id', 'purchaser_user_id')
        ->withTimestamps();
    }

    public function supervisor(){
      return $this->belongsTo(User::class, 'supervisor_user_id');
    }

    public function purchaseUnit(){
      return $this->belongsTo(PurchaseUnit::class, 'purchase_unit_id');
    }

    public function purchaseType(){
      return $this->belongsTo(PurchaseType::class, 'purchase_type_id');
    }

    public function purchaseMechanism(){
      return $this->belongsTo(PurchaseMechanism::class, 'purchase_mechanism_id');
    }

    public function signer(){
      return $this->belongsTo(User::class, 'signer_user_id');
    }

    public function userOrganizationalUnit(){
      return $this->belongsTo(OrganizationalUnit::class, 'request_user_ou_id');
    }

    public function contractOrganizationalUnit(){
      return $this->belongsTo(OrganizationalUnit::class, 'contract_manager_ou_id');
    }

    public function itemRequestForms() {
      return $this->hasMany(ItemRequestForm::class);
    }

    public function passengers()
    {
      return $this->hasMany(Passenger::class);
    }

    public function eventRequestForms() {
        return $this->hasMany(EventRequestForm::class);
    }

    public function purchasingProcesses() {
        return $this->hasMany(PurchasingProcess::class);
    }

    public function purchasingProcess(){
      return $this->HasOne(PurchasingProcess::class);
    }

    public function signedRequestForm()
    {
        return $this->belongsTo('App\Models\Documents\SignaturesFile', 'signatures_file_id');
    }

    public function getTotalEstimatedExpense()
    {
      $total = 0;
      foreach($this->children as $child){
        if($child->status == 'approved')
          $total += $child->estimated_expense;
      }
      return $total;
    }

    public function getTotalExpense()
    {
      $total = 0;
      foreach($this->children as $child){
        if($child->purchasingProcess)
          $total += $child->purchasingProcess->getExpense();
      }
      return $total;
    }

    /*****Elimina RequestForm y tablas relacionadas en cadena*****/
    public static function boot() {
        parent::boot();
        static::deleting(function($requestForm) { // before delete() method call this
             $requestForm->eventRequestForms()->delete();
             $requestForm->itemRequestForms()->delete();
             $requestForm->requestFormFiles()->delete();
             // do the rest of the cleanup...
        });
    }


    public function getPurchaseMechanism(){
      return PurchaseMechanism::find($this->purchase_mechanism_id)->name;
    }

    public function getStatus(){
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
            case "closed":
                return 'Cerado';
                break;
        }
    }

    public function getSubtypeValueAttribute(){
        switch ($this->subtype) {
            case "bienes ejecución inmediata":
                return 'Bienes Ejecución Inmediata';
                break;

            case "bienes ejecución tiempo":
                return 'Bienes Ejecución En Tiempo';
                break;

            case "servicios ejecución inmediata":
                return 'Servicios Ejecución Inmediata';
                break;

            case "servicios ejecución tiempo":
                return 'Servicios Ejecución En Tiempo';
                break;
        }
    }

    public function getTypeOfCurrencyValueAttribute(){
        switch ($this->type_of_currency) {
            case "peso":
                return 'Peso';
                break;

            case "bienes ejecución tiempo":
                return 'Bienes Ejecución En Tiempo';
                break;

            case "servicios ejecución inmediata":
                return 'Servicios Ejecución Inmediata';
                break;

            case "servicios ejecución tiempo":
                return 'Servicios Ejecución En Tiempo';
                break;
        }
    }

    /*Regresa Icono del estado de firma de Eventos [argumento:  tipo de Evento]*/
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
        return 'pending';//en espera
    }

    public function rejectedTime() {
      $event = $this->eventRequestForms()->where('status', 'rejected')->where('event_type', '!=', 'budget_event')->first();
      if(!is_null($event)){
        $date = new Carbon($event->signature_date);
        return $date->format('d-m-Y');
      }
    }

    public function createdDate() {
      $date = new Carbon($this->created_at);
      return $date->format('d-m-Y H:i:s');
    }

    public function updatedDate() {
      $date = new Carbon($this->updated_at);
      return $date->format('d-m-Y H:i:s');
    }

    public function rejectedName() {
      $event = $this->eventRequestForms()->where('status', 'rejected')->where('event_type', '!=', 'budget_event')->first();
      if(!is_null($event))
        return $event->signerUser->tinnyName();
    }

    public function rejectedComment() {
      $event = $this->eventRequestForms()->where('status', 'rejected')->where('event_type', '!=', 'budget_event')->first();
      if(!is_null($event))
        return $event->comment;
    }

    public function eventSignatureDate($event_type, $status){
      $event = $this->eventRequestForms()->where('status', $status)->where('event_type',$event_type)->first();
      if(!is_null($event)){
        $date = new Carbon($event->signature_date);
        return $date->format('d-m-Y H:i:s');
      }
    }

    public function eventPurchaserNewBudget(){
      $event = $this->eventRequestForms()->where('status', 'approved')->where('event_type', 'budget_event')->first();
      if(!is_null($event)){
        return $event->purchaser;
      }
    }

    public function eventSignerName($event_type, $status){
      $event = $this->eventRequestForms()->where('status', $status)->where('event_type',$event_type)->first();
      if(!is_null($event)){
        return $event->signerUser->tinnyName();
      }
    }

    /* Utilizar esta Función para obtener todos los datos de las visaciones */
    public function eventSigner($event_type, $status){
      $event = $this->eventRequestForms()->where('status', $status)->where('event_type',$event_type)->first();
      if(!is_null($event)){
        return $event;
      }
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

    public function quantityOfItems(){
      return $this->type_form == 'bienes y/o servicios' ? $this->itemRequestForms()->count() : $this->passengers()->count();
    }

    public function iAmPurchaser(){
      return $this->purchasers->where('id', Auth::id())->count() > 0;
    }


/******************************************************/
/*********** CODIGO  PACHA  **************************/
/*****************************************************/

    public function estimatedExpense()
    {
      return number_format($this->estimated_expense,0,",",".");
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
