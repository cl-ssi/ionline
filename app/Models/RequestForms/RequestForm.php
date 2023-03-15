<?php

namespace App\Models\RequestForms;

use App\Models\Documents\SignaturesFile;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\User;
use App\Rrhh\OrganizationalUnit;
use App\Models\RequestForms\PurchasingProcess;
use App\Models\RequestForms\ItemRequestForm;
// use App\Models\RequestForms\ItemChangedRequestForm;
use App\Models\RequestForms\EventRequestForm;
use App\Models\Parameters\PurchaseType;
use App\Models\Parameters\PurchaseUnit;
use App\Models\Parameters\PurchaseMechanism;
use App\Models\Parameters\Program;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Http\Request;

class RequestForm extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $fillable = [
        'request_form_id', 'estimated_expense', 'program', 'contract_manager_id',
        'name', 'subtype', 'justification', 'superior_chief',
        'type_form', 'bidding_number', 'request_user_id', 'program_id',
        'request_user_ou_id', 'contract_manager_ou_id', 'status', 'sigfe',
        'purchase_unit_id', 'purchase_type_id', 'purchase_mechanism_id', 'type_of_currency',
        'folio', 'has_increased_expense', 'signatures_file_id', 'old_signatures_file_id', 'approved_at'
    ];

    public function isBlocked()
    {
        return in_array($this->id, [172,173,164,176,180,181]); // FR ids con restricción de No generar suministros
    }

    public function getFolioAttribute($value)
    {
        return $value . ($this->has_increased_expense ? '-M' : '');
    }

    public function father()
    {
        return $this->belongsTo(RequestForm::class, 'request_form_id');
    }

    public function children()
    {
        return $this->hasMany(RequestForm::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'request_user_id')->withTrashed();
    }

    public function messages()
    {
        return $this->hasMany(RequestFormMessage::class);
    }

    public function requestFormFiles()
    {
        return $this->hasMany(RequestFormFile::class);
    }

    public function contractManager()
    {
        return $this->belongsTo(User::class, 'contract_manager_id')->withTrashed();
    }

    public function purchasers()
    {
        return $this->belongsToMany(User::class, 'arq_request_forms_users', 'request_form_id', 'purchaser_user_id')
            ->withTimestamps()->withTrashed();
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_user_id')->withTrashed();
    }

    public function purchaseUnit()
    {
        return $this->belongsTo(PurchaseUnit::class, 'purchase_unit_id');
    }

    public function purchaseType()
    {
        return $this->belongsTo(PurchaseType::class, 'purchase_type_id');
    }

    public function purchaseMechanism()
    {
        return $this->belongsTo(PurchaseMechanism::class, 'purchase_mechanism_id');
    }

    public function signer()
    {
        return $this->belongsTo(User::class, 'signer_user_id')->withTrashed();
    }

    public function userOrganizationalUnit()
    {
        return $this->belongsTo(OrganizationalUnit::class, 'request_user_ou_id');
    }

    public function contractOrganizationalUnit()
    {
        return $this->belongsTo(OrganizationalUnit::class, 'contract_manager_ou_id');
    }

    public function itemRequestForms()
    {
        return $this->hasMany(ItemRequestForm::class);
    }

    // public function itemChangedRequestForms()
    // {
    //     return $this->hasMany(ItemChangedRequestForm::class);
    // }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }

    public function eventRequestForms()
    {
        return $this->hasMany(EventRequestForm::class);
    }

    public function purchasingProcesses()
    {
        return $this->hasMany(PurchasingProcess::class);
    }

    public function purchasingProcess()
    {
        return $this->HasOne(PurchasingProcess::class);
    }

    public function signedRequestForm()
    {
        return $this->belongsTo(SignaturesFile::class, 'signatures_file_id');
    }

    public function signedOldRequestForm()
    {
        return $this->belongsTo(SignaturesFile::class, 'old_signatures_file_id');
    }

    public function associateProgram()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function getTotalEstimatedExpense()
    {
        $total = 0;
        foreach ($this->children as $child) {
            if ($child->status == 'approved')
                $total += $child->estimated_expense;
        }
        return $total;
    }

    public function getTotalExpense()
    {
        $total = 0;
        foreach ($this->children as $child) {
            if ($child->purchasingProcess)
                $total += $child->purchasingProcess->getExpense();
        }
        return $total;
    }

    /*****Elimina RequestForm y tablas relacionadas en cadena*****/
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($requestForm) { // before delete() method call this
            $requestForm->eventRequestForms()->delete();
            $requestForm->itemRequestForms()->delete();
            $requestForm->requestFormFiles()->delete();
            // do the rest of the cleanup...
        });
    }


    public function getPurchaseMechanism()
    {
        return PurchaseMechanism::find($this->purchase_mechanism_id)->name;
    }

    public function getStatus()
    {
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
                return 'Cerrado';
                break;
            case "saved":
                return 'Guardado';
                break;
        }
    }

    public function isPurchaseInProcess()
    {
        return $this->purchasingProcess == null || ($this->purchasingProcess && $this->purchasingProcess->status == 'in_process');
    }

    public function getSubtypeValueAttribute()
    {
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

    public function getTypeOfCurrencyValueAttribute()
    {
        switch ($this->type_of_currency) {
            case "peso":
                return 'Peso';
                break;

            case "dolar":
                return 'Dólar';
                break;

            case "uf":
                return 'Uf';
                break;
        }
    }

    public function getSymbolCurrencyAttribute()
    {
        switch ($this->type_of_currency) {
            case "peso":
                return '$';
                break;

            case "dolar":
                return 'USD ';
                break;

            case "uf":
                return 'Uf ';
                break;
        }
    }

    public function getPrecisionCurrencyAttribute()
    {
        return $this->type_of_currency == 'peso' ? 0 : 2;
    }

    public function getApprovedAtAttribute()
    {
        if ($this->eventRequestForms()->count() === 0) {
            return null;
        }

        return $this->eventRequestForms()
            ->orderBy('cardinal_number', 'desc')
            ->first('signature_date')
            // ->where('event_type', 'supply_event')
            // ->where('status', 'approved')
            // ->first()
            ->signature_date;
    }

    /*Regresa Icono del estado de firma de Eventos [argumento:  tipo de Evento]*/
    public function eventSign($event_type)
    {
        if (!is_null($this->eventRequestForms()->where('status', 'approved')->where('event_type', $event_type)->first()))
            return '<i class="text-success fas fa-check"></i>'; //aprovado
        elseif (!is_null($this->eventRequestForms()->where('status', 'rejected')->where('event_type', $event_type)->first()))
            return '<i class="text-danger fas fa-ban"></i>'; //rechazado
        else
            return '<i class="text-info far fa-hourglass"></i>'; //en espera
    }

    public function eventSingStatus($event_type)
    {
        if (!is_null($this->eventRequestForms()->where('status', 'approved')->where('event_type', $event_type)->first()))
            return 'approved'; //aprovado
        elseif (!is_null($this->eventRequestForms()->where('status', 'rejected')->where('event_type', $event_type)->first()))
            return 'rejected'; //rechazado
        else
            return 'pending'; //en espera
    }

    public function rejectedTime()
    {
        $event = $this->eventRequestForms()->where('status', 'rejected')->where('event_type', '!=', 'budget_event')->first();
        if (!is_null($event)) {
            $date = new Carbon($event->signature_date);
            return $date->format('d-m-Y');
        }
    }

    public function createdDate()
    {
        $date = new Carbon($this->created_at);
        return $date->format('d-m-Y H:i:s');
    }

    public function updatedDate()
    {
        $date = new Carbon($this->updated_at);
        return $date->format('d-m-Y H:i:s');
    }

    public function rejectedName()
    {
        $event = $this->eventRequestForms()->where('status', 'rejected')->where('event_type', '!=', 'budget_event')->first();
        if (!is_null($event))
            return $event->signerUser->tinnyName;
    }

    public function rejectedComment()
    {
        $event = $this->eventRequestForms()->where('status', 'rejected')->where('event_type', '!=', 'budget_event')->first();
        if (!is_null($event))
            return $event->comment;
    }

    public function eventSignatureDate($event_type, $status)
    {
        $event = $this->eventRequestForms()->where('status', $status)->where('event_type', $event_type)->first();
        if (!is_null($event)) {
            $date = new Carbon($event->signature_date);
            return $date->format('d-m-Y H:i:s');
        }
    }

    public function eventPurchaserNewBudget()
    {
        $event = $this->eventRequestForms()->where('status', 'approved')->where('event_type', 'budget_event')->first();
        if (!is_null($event)) {
            return $event->purchaser;
        }
    }

    public function eventSignerName($event_type, $status)
    {
        $event = $this->eventRequestForms()->where('status', $status)->where('event_type', $event_type)->first();
        if (!is_null($event)) {
            return $event->signerUser->tinnyName ;
        }
    }

    /* Utilizar esta Función para obtener todos los datos de las visaciones */
    public function eventSigner($event_type, $status)
    {
        $event = $this->eventRequestForms()->where('status', $status)->where('event_type', $event_type)->first();
        if (!is_null($event)) {
            return $event;
        }
    }

    public function firstPendingEvent()
    {
        return $this->eventRequestForms->where('status', 'pending')->first();
    }


    /* TIEMPO TRANSCURRIDO DEL TICKET */
    public function getElapsedTime()
    {
        $day = Carbon::now()->diffInDays($this->created_at);
        if ($day <= 1)
            return $day . ' día.';
        else
            return $day . ' días.';
    }

    public function quantityOfItems()
    {
        return $this->type_form == 'bienes y/o servicios' ? $this->itemRequestForms()->count() : $this->passengers()->count();
    }

    public function iAmPurchaser()
    {
        return $this->purchasers->where('id', Auth::id())->count() > 0;
    }

    // public function scopeSearch($query, Request $request)
    // {
    //     if ($request->input('id') != "") {
    //         $query->where('id', $request->input('id'));
    //     }
    //     if ($request->input('name') != "") {
    //         $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
    //     }
    //     if ($request->input('folio') != "") {
    //         $query->where('folio', $request->input('folio'));
    //     }
    //     if ($request->input('request_user_id') != "") {
    //         $query->where('request_user_id', $request->input('request_user_id'));
    //     }
    //     if ($request->input('contract_manager_id') != "") {
    //         $query->where('contract_manager_id', $request->input('contract_manager_id'));
    //     }

    //     if ($request->input('purchaser_user_id') != "") {
    //         $query->whereHas('purchasers', function ($q) use ($request) {
    //             $q->Where('purchaser_user_id', $request->input('purchaser_user_id'));
    //         });
    //     }

    //     return $query;
    // }

    public function scopeSearch($query, $status_search, $status_purchase_search, $id_search, $folio_search, $name_search,
        $start_date_search, $end_date_search, $requester_search, $requester_ou_id, $admin_search, $admin_ou_id, $purchaser_search, 
        $program_search, $purchase_order_search, $tender_search, $supplier_search)
    {
        if ($status_search OR $status_purchase_search OR $id_search OR $folio_search OR $name_search 
            OR $start_date_search OR $end_date_search OR $requester_search OR $requester_ou_id OR $admin_search 
            OR $admin_ou_id OR $purchaser_search OR $program_search OR $purchase_order_search OR $tender_search OR $supplier_search) {
            if($status_search != ''){
                $query->where(function($q) use($status_search){
                    $q->where('status', $status_search);
                });
            }
            if($status_purchase_search != ''){
                $query->whereHas('purchasingProcess', function($q) use ($status_purchase_search){
                    $q->Where('status', $status_purchase_search);
                })->when($status_purchase_search == 'in_process', function($q){
                    $q->orWhere('status', 'approved')->doesntHave('purchasingProcess');
                });
            }
            if($id_search != ''){
                $query->where(function($q) use($id_search){
                    $q->where('id', $id_search);
                });
            }
            if($folio_search != ''){
                $query->where(function($q) use($folio_search){
                    $q->where('folio', $folio_search);
                });
            }
            if($name_search != ''){
                $query->where(function($q) use($name_search){
                    $q->where('name', 'LIKE', '%'.$name_search.'%');
                });
            }
            if($start_date_search != '' && $end_date_search != ''){
                $query->where(function($q) use($start_date_search, $end_date_search){
                    $q->whereBetween('created_at', [$start_date_search, $end_date_search." 23:59:59"])->get();
                });
            }
            $array_requester_search = explode(' ', $requester_search);
            foreach($array_requester_search as $word){
                $query->whereHas('user' ,function($query) use($word){
                    $query->where('name', 'LIKE', '%'.$word.'%')
                        ->orwhere('fathers_family','LIKE', '%'.$word.'%')
                        ->orwhere('mothers_family','LIKE', '%'.$word.'%');
                });
            }
            if($requester_ou_id != ''){
                $query->where(function($q) use($requester_ou_id){
                    $q->where('request_user_ou_id', $requester_ou_id);
                });
            }
            $array_admin_search = explode(' ', $admin_search);
            foreach($array_admin_search as $word){
                $query->whereHas('contractManager' ,function($query) use($word){
                    $query->where('name', 'LIKE', '%'.$word.'%')
                        ->orwhere('fathers_family','LIKE', '%'.$word.'%')
                        ->orwhere('mothers_family','LIKE', '%'.$word.'%');
                });
            }
            if($admin_ou_id != ''){
                $query->where(function($q) use($admin_ou_id){
                    $q->where('contract_manager_ou_id', $admin_ou_id);
                });
            }
            if($purchaser_search != null){
                $array_purchaser_search = explode(' ', $purchaser_search);
                foreach($array_purchaser_search as $word){
                    $query->whereHas('purchasers' ,function($query) use($word){
                        $query->where('name', 'LIKE', '%'.$word.'%')
                            ->orwhere('fathers_family','LIKE', '%'.$word.'%')
                            ->orwhere('mothers_family','LIKE', '%'.$word.'%');
                    });
                }
            }
            if($program_search != ''){
                $query->where(function($q) use($program_search){
                    $q->where('program', 'LIKE', '%'.$program_search.'%');
                });
            }
            if($purchase_order_search != ''){
                $query->whereHas('purchasingProcess.details', function($q) use ($purchase_order_search){
                    $q->join('arq_immediate_purchases', function ($join) use ($purchase_order_search) {
                        $join->on('arq_purchasing_process_detail.immediate_purchase_id', '=', 'arq_immediate_purchases.id')
                             ->where('arq_immediate_purchases.po_id', '=', $purchase_order_search);
                    });
                });
            }
            if($tender_search != ''){
                $query->whereHas('purchasingProcess.details', function($q) use ($tender_search){
                    $q->join('arq_tenders', function ($join) use ($tender_search) {
                        $join->on('arq_purchasing_process_detail.tender_id', '=', 'arq_tenders.id')
                             ->where('arq_tenders.tender_number', '=', $tender_search);
                    });
                });
            }

            if($supplier_search != ''){

                $query->whereHas('purchasingProcess.details', function($q) use ($supplier_search){
                    $q->join('arq_immediate_purchases', function ($join) use ($supplier_search) {
                        $join->on('arq_purchasing_process_detail.immediate_purchase_id', '=', 'arq_immediate_purchases.id')
                             ->where('arq_immediate_purchases.po_supplier_name', 'LIKE', '%'.$supplier_search.'%');
                             //->orwhere('arq_immediate_purchases.po_supplier_office_run','LIKE', '%'.$supplier_search.'%');
                    });
                }) 

                ->orWhereHas('purchasingProcess.details', function($q) use ($supplier_search){
                    $q->join('arq_internal_purchase_orders', function ($join) use ($supplier_search) {
                        $join->on('arq_purchasing_process_detail.internal_purchase_order_id', '=', 'arq_internal_purchase_orders.id')
                            ->join('cfg_suppliers', function ($join) use ($supplier_search) {
                                $join->on('arq_internal_purchase_orders.supplier_id', '=', 'cfg_suppliers.id')
                                    ->where('cfg_suppliers.name', 'LIKE', '%'.$supplier_search.'%');
                                    //->orwhere('arq_immediate_purchases.po_supplier_office_run','LIKE', '%'.$supplier_search.'%');
                            });
                    });
                });
                

                // ->join('cfg_suppliers', function ($join) use ($supplier_search) {
                //     $join->on('arq_internal_purchase_orders.supplier_id', '=', 'cfg_suppliers.id')
                //         ->where('arq_immediate_purchases.po_supplier_name', 'LIKE', '%'.$supplier_search.'%');
                // });


                /* Proveedores de las OC Interna */
            }
        }
    }

    /**
     * @return mixed
     */
    function getDaysToExpireAttribute()
    {
        if ($this->getExpireAtAttribute() < now()) {
            return 0;
        }

        return $this->getExpireAtAttribute()->diffInDays(now());
    }

    /**
     * @return mixed
     */
    function getExpireAtAttribute()
    {
        if ($this->getApprovedAtAttribute() == null) {
            return null;
        }

        $daysToExpire = $this->purchaseType->supply_continuous_day;
        return $this->approvedAt->addDays($daysToExpire);
    }

    function getPurchasedOnTimeAttribute(){
        $po_sent_dates = [];
        foreach($this->purchasingProcess->details as $detail){
            if($detail->pivot->tender && $detail->pivot->tender->oc) $po_sent_dates[] = $detail->pivot->tender->oc->po_sent_date;
            if($detail->pivot->directDeal && $detail->pivot->directDeal->oc) $po_sent_dates[] = $detail->pivot->directDeal->oc->po_sent_date;
            if($detail->pivot->immediatePurchase) $po_sent_dates[] = $detail->pivot->immediatePurchase->po_sent_date;
        }

        // return '['.implode(', ', $po_sent_dates).']';
        if(count($po_sent_dates) == 0) return null;

        $max = max(array_map('strtotime', $po_sent_dates));
        return date('d-m-Y H:i', $max);

        // $this->approvedAt
    }

    /******************************************************/
    /*********** CODIGO  PACHA  **************************/
    /*****************************************************/

    public function estimatedExpense()
    {
        return number_format($this->estimated_expense, 0, ",", ".");
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

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'arq_request_forms';
}
