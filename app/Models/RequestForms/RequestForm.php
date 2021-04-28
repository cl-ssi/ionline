<?php

namespace app\Models\RequestForms;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RequestForm extends Model
{
    protected $fillable = [
        'estimated_expense', 'program', 'justification', 'type_form', 'previous_request_form_id', 'bidding_number',
        'finance_program', 'purchase_mechanism', 'folio_sigfe', 'folio_sigfe_id_oc', 'finance_expense', 'available_balance',
        'program_balance', 'oc_number', 'creator_id'
    ];

    public function getFormatEstimatedExpenseAttribute()
    {
        return number_format($this->estimated_expense,0,",",".");
    }

    public function getCreationDateAttribute()
    {
      return $this->created_at->format('d-m-Y H:i:s');
    }

    /*  DETERMINAR FECHA DE VENCIMIENTO */
    public function getEndDateAttribute()
    {
      if($this->status == "closed"){
        return $this->updated_at->format('d-m-Y H:i:s');
      }
      else{
        return null;
      }
    }

    /* TIEMPO TRANSCURRIDO DEL TICKET */
    public function getElapsedTimeAttribute()
    {
      if($this->status == "closed"){
        $startDate= Carbon::parse($this->created_at);
        $endDate = Carbon::parse($this->updated_at);

        $dateDiff = new \Carbon\Carbon();
        return $dateDiff=$startDate->diffInDays($endDate);
      }
      else{
        $now = new \Carbon\Carbon();
        return $now->diffInDays($this->created_at);
      }
    }

    public function getFormRequestNumberAttribute()
    {
      return $this->id;
    }

    public function getEstimatedExpenseFormatAttribute()
    {
      return number_format($this->estimated_expense, 0, ',', '.');
    }

    public function getEstimatedFinanceExpenseFormatAttribute()
    {
      return number_format($this->finance_expense, 0, ',', '.');
    }

    public function getProgramBalanceFormatAttribute()
    {
      return number_format($this->program_balance, 0, ',', '.');
    }

    public function getAvailableBalanceFormatAttribute()
    {
      return number_format($this->available_balance, 0, ',', '.');
    }

    public function creator() {
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function items() {
        return $this->hasMany('\app\Models\RequestForms\Item');
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
