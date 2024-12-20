<?php

namespace App\Models\RequestForms;

use App\Models\Finance\Cdp;
use App\Observers\RequestForms\RequestFormObserver;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\RequestForms\PurchasingProcess;
use App\Models\RequestForms\PaymentDoc;
use App\Models\RequestForms\ItemRequestForm;
use App\Models\RequestForms\ItemChangedRequestForm;
use App\Models\RequestForms\ImmediatePurchase;
use App\Models\RequestForms\EventRequestForm;
use App\Models\Parameters\PurchaseUnit;
use App\Models\Parameters\PurchaseType;
use App\Models\Parameters\PurchaseMechanism;
use App\Models\Parameters\Program;
use App\Models\Documents\SignaturesFile;
use App\Models\PurchasePlan\PurchasePlan;
use App\Models\Warehouse\Control;
use App\Enums\RequestForms\Status;

#[ObservedBy([RequestFormObserver::class])]
class RequestForm extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'arq_request_forms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'purchase_plan_id',
        'request_form_id',
        'estimated_expense',
        'program',
        'contract_manager_id',
        'name',
        'subtype',
        'justification',
        'superior_chief',
        'type_form',
        'bidding_number',
        'request_user_id',
        'program_id',
        'request_user_ou_id',
        'contract_manager_ou_id',
        'status',
        'sigfe',
        'purchase_unit_id',
        'purchase_type_id',
        'purchase_mechanism_id',
        'type_of_currency',
        'folio',
        'has_increased_expense',
        'signatures_file_id',
        'old_signatures_file_id',
        'approved_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'approved_at'   => 'datetime',
        'status'        => Status::class,
    ];

    /**
     * Get the purchase plan that owns the request form.
     *
     * @return BelongsTo
     */
    public function purchasePlan(): BelongsTo
    {
        return $this->belongsTo(PurchasePlan::class, 'purchase_plan_id');
    }

    /**
     * Get the father request form.
     *
     * @return BelongsTo
     */
    public function father(): BelongsTo
    {
        return $this->belongsTo(RequestForm::class, 'request_form_id');
    }

    /**
     * Get the children request forms.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(RequestForm::class);
    }

    /**
     * Get the user that owns the request form.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'request_user_id')->withTrashed();
    }

    /**
     * Get the messages for the request form.
     *
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(RequestFormMessage::class);
    }

    /**
     * Get the request form files.
     *
     * @return HasMany
     */
    public function requestFormFiles(): HasMany
    {
        return $this->hasMany(RequestFormFile::class);
    }

    /**
     * Get the contract manager that owns the request form.
     *
     * @return BelongsTo
     */
    public function contractManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contract_manager_id')->withTrashed();
    }

    /**
     * The users that are purchasers for the request form.
     *
     * @return BelongsToMany
     */
    public function purchasers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'arq_request_forms_users', 'request_form_id', 'purchaser_user_id')
                    ->withTimestamps()
                    ->withTrashed();
    }

    /**
     * Get the supervisor that owns the request form.
     *
     * @return BelongsTo
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_user_id')->withTrashed();
    }

    /**
     * Get the purchase unit that owns the request form.
     *
     * @return BelongsTo
     */
    public function purchaseUnit(): BelongsTo
    {
        return $this->belongsTo(PurchaseUnit::class, 'purchase_unit_id');
    }

    /**
     * Get the purchase type that owns the request form.
     *
     * @return BelongsTo
     */
    public function purchaseType(): BelongsTo
    {
        return $this->belongsTo(PurchaseType::class, 'purchase_type_id');
    }

    /**
     * Get the purchase mechanism that owns the request form.
     *
     * @return BelongsTo
     */
    public function purchaseMechanism(): BelongsTo
    {
        return $this->belongsTo(PurchaseMechanism::class, 'purchase_mechanism_id');
    }

    /**
     * Get the signer that owns the request form.
     *
     * @return BelongsTo
     */
    public function signer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'signer_user_id')->withTrashed();
    }

    /**
     * Get the organizational unit of the user that owns the request form.
     *
     * @return BelongsTo
     */
    public function userOrganizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'request_user_ou_id')->withTrashed();
    }

    /**
     * Get the organizational unit of the contract manager that owns the request form.
     *
     * @return BelongsTo
     */
    public function contractOrganizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'contract_manager_ou_id')->withTrashed();
    }

    /**
     * Get the item request forms for the request form.
     *
     * @return HasMany
     */
    public function itemRequestForms(): HasMany
    {
        return $this->hasMany(ItemRequestForm::class);
    }

    /**
     * Get the item changed request forms for the request form.
     *
     * @return HasMany
     */
    public function itemChangedRequestForms(): HasMany
    {
        return $this->hasMany(ItemChangedRequestForm::class);
    }

    /**
     * Get the passengers for the request form.
     *
     * @return HasMany
     */
    public function passengers(): HasMany
    {
        return $this->hasMany(Passenger::class);
    }

    /**
     * Get the event request forms for the request form.
     *
     * @return HasMany
     */
    public function eventRequestForms(): HasMany
    {
        return $this->hasMany(EventRequestForm::class);
    }

    /**
     * Get the purchasing processes for the request form.
     *
     * @return HasMany
     */
    public function purchasingProcesses(): HasMany
    {
        return $this->hasMany(PurchasingProcess::class);
    }

    /**
     * Get the purchasing process for the request form.
     *
     * @return HasOne
     */
    public function purchasingProcess(): HasOne
    {
        return $this->hasOne(PurchasingProcess::class);
    }

    /**
     * Get the signed request form.
     *
     * @return BelongsTo
     */
    public function signedRequestForm(): BelongsTo
    {
        return $this->belongsTo(SignaturesFile::class, 'signatures_file_id');
    }

    /**
     * Get the signed old request form.
     *
     * @return BelongsTo
     */
    public function signedOldRequestForm(): BelongsTo
    {
        return $this->belongsTo(SignaturesFile::class, 'old_signatures_file_id');
    }

    /**
     * Get the signed old request forms.
     *
     * @return HasMany
     */
    public function signedOldRequestForms(): HasMany
    {
        return $this->hasMany(OldSignatureFile::class)->latest();
    }

    /**
     * Get the associated program.
     *
     * @return BelongsTo
     */
    public function associateProgram(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    /**
     * Get the immediate purchases for the request form.
     *
     * @return HasMany
     */
    public function immediatePurchases(): HasMany
    {
        return $this->hasMany(ImmediatePurchase::class);
    }

    /**
     * Get the CDP for the request form.
     *
     * @return HasOne
     */
    public function cdp(): HasOne
    {
        return $this->hasOne(Cdp::class);
    }


    // FIXME: corregir este código
    public function isBlocked()
    {
        return in_array($this->id, [172, 173, 164, 176, 180, 181]); // FR ids con restricción de No generar suministros
    }

    public function getFolioAttribute($value)
    {
        return $value . ($this->has_increased_expense ? '-M' : '');
    }

    /**
     * Devuelve los Payment Docs del propio formulario
     * si tienen un padre, entonces devuelve los del padre
     */
    public function paymentDocs()
    {
        if($this->father) {
            return $this->father->paymentDocs();
        }
        else {
            return $this->hasMany(PaymentDoc::class);
        }
    }

    public function control()
    {
        return $this->hasOne(Control::class);
    }
    
    public function getTotalEstimatedExpense()
    {
        $total = 0;
        foreach ($this->children as $child) {
            if ($child->status->value == 'approved')
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

    public function getTotalDtes()
    {
        $total = 0;
        foreach($this->immediatePurchases as $oc){
            $total += $oc->dtes->sum('monto_total');
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
            case "rejected":
                return 'Rechazado';
            case "approved":
                return 'Aprobado';
            case "closed":
                return 'Cerrado';
            case "saved":
                return 'Guardado';
        }
    }

    public function isPurchaseInProcess()
    {
        return $this->purchasingProcess == null || ($this->purchasingProcess && in_array($this->purchasingProcess->status->value, ['in_process', 'canceled']));
    }

    public function getSubtypeValueAttribute()
    {
        switch ($this->subtype) {
            case "bienes ejecución inmediata":
                return 'Bienes Ejecución Inmediata';
            case "bienes ejecución tiempo":
                return 'Bienes Ejecución En Tiempo';
            case "servicios ejecución inmediata":
                return 'Servicios Ejecución Inmediata';
            case "servicios ejecución tiempo":
                return 'Servicios Ejecución En Tiempo';
        }
    }

    public function getTypeOfCurrencyValueAttribute()
    {
        switch ($this->type_of_currency) {
            case "peso":
                return 'Peso';
            case "dolar":
                return 'Dólar';
            case "uf":
                return 'Uf';
        }
    }

    public function getSymbolCurrencyAttribute()
    {
        switch ($this->type_of_currency) {
            case "peso":
                return '$';
            case "dolar":
                return 'USD ';
            case "uf":
                return 'Uf ';
        }
    }

    public function getPrecisionCurrencyAttribute()
    {
        return $this->type_of_currency == 'peso' ? 0 : 2;
    }

    // public function getApprovedAtAttribute()
    // {
    //     if ($this->eventRequestForms()->count() === 0) {
    //         return null;
    //     }

    //     return $this->eventRequestForms()
    //         ->orderBy('cardinal_number', 'desc')
    //         ->first('signature_date')
    //         // ->where('event_type', 'supply_event')
    //         // ->where('status', 'approved')
    //         // ->first()
    //         ->signature_date;
    // }

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
            return $event->signerUser->tinyName;
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
            return $event->signerUser->tinyName;
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
        $day = Carbon::now()->diffInWeekDays($this->created_at);
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

    public function scopeSearch(
        $query,
        $status_search,
        $status_purchase_search,
        $id_search,
        $folio_search,
        $name_search,
        $start_date_search,
        $end_date_search,
        $requester_search,
        $requester_ou_id,
        $admin_search,
        $admin_ou_id,
        $purchaser_search,
        $program_search,
        $purchase_order_search,
        $tender_search,
        $supplier_search,
        $subtype_search,
        $purchase_mechanism_search
    ) {
        if (
            $status_search or $status_purchase_search or $id_search or $folio_search or $name_search
            or $start_date_search or $end_date_search or $requester_search or $requester_ou_id or $admin_search
            or $admin_ou_id or $purchaser_search or $program_search or $purchase_order_search or $tender_search or $supplier_search or $subtype_search
            or $purchase_mechanism_search
        ) {
            if ($status_search != '') {
                $query->where(function ($q) use ($status_search) {
                    $q->where('status', $status_search);
                });
            }
            if ($status_purchase_search != '') {
                $query->whereHas('purchasingProcess', function ($q) use ($status_purchase_search) {
                    $q->Where('status', $status_purchase_search);
                })->when($status_purchase_search == 'in_process', function ($q) {
                    $q->orWhere('status', 'approved')->doesntHave('purchasingProcess');
                });
            }
            if ($id_search != '') {
                $query->where(function ($q) use ($id_search) {
                    $q->where('id', $id_search);
                });
            }
            if ($folio_search != '') {
                $query->where(function ($q) use ($folio_search) {
                    $q->where('folio', $folio_search);
                });
            }
            if ($name_search != '') {
                $query->where(function ($q) use ($name_search) {
                    $q->where('name', 'LIKE', '%' . $name_search . '%');
                });
            }
            if ($start_date_search != '' && $end_date_search != '') {
                $query->where(function ($q) use ($start_date_search, $end_date_search) {
                    $q->whereBetween('created_at', [$start_date_search, $end_date_search . " 23:59:59"])->get();
                });
            }
            $array_requester_search = explode(' ', $requester_search);
            foreach ($array_requester_search as $word) {
                $query->whereHas('user', function ($query) use ($word) {
                    $query->where('name', 'LIKE', '%' . $word . '%')
                        ->orwhere('fathers_family', 'LIKE', '%' . $word . '%')
                        ->orwhere('mothers_family', 'LIKE', '%' . $word . '%');
                });
            }
            if ($requester_ou_id != '') {
                $query->where(function ($q) use ($requester_ou_id) {
                    $q->where('request_user_ou_id', $requester_ou_id);
                });
            }
            $array_admin_search = explode(' ', $admin_search);
            foreach ($array_admin_search as $word) {
                $query->whereHas('contractManager', function ($query) use ($word) {
                    $query->where('name', 'LIKE', '%' . $word . '%')
                        ->orwhere('fathers_family', 'LIKE', '%' . $word . '%')
                        ->orwhere('mothers_family', 'LIKE', '%' . $word . '%');
                });
            }
            if ($admin_ou_id != '') {
                $query->where(function ($q) use ($admin_ou_id) {
                    $q->where('contract_manager_ou_id', $admin_ou_id);
                });
            }
            if ($purchaser_search != null) {
                $array_purchaser_search = explode(' ', $purchaser_search);
                foreach ($array_purchaser_search as $word) {
                    $query->whereHas('purchasers', function ($query) use ($word) {
                        $query->where('name', 'LIKE', '%' . $word . '%')
                            ->orwhere('fathers_family', 'LIKE', '%' . $word . '%')
                            ->orwhere('mothers_family', 'LIKE', '%' . $word . '%');
                    });
                }
            }
            if ($program_search != '') {
                $query->where(function ($q) use ($program_search) {
                    $q->where('program', 'LIKE', '%' . $program_search . '%');
                })->orWhereHas('associateProgram', function ($query) use ($program_search) {
                    $query->where('alias_finance', 'LIKE', '%' . $program_search . '%');
                });
            }
            if ($purchase_order_search != '') {
                $query->whereHas('purchasingProcess.details', function ($q) use ($purchase_order_search) {
                    $q->join('arq_immediate_purchases', function ($join) use ($purchase_order_search) {
                        $join->on('arq_purchasing_process_detail.immediate_purchase_id', '=', 'arq_immediate_purchases.id')
                            ->where('arq_immediate_purchases.po_id', '=', $purchase_order_search);
                    });
                });
            }
            if ($tender_search != '') {
                $query->whereHas('purchasingProcess.details', function ($q) use ($tender_search) {
                    $q->join('arq_tenders', function ($join) use ($tender_search) {
                        $join->on('arq_purchasing_process_detail.tender_id', '=', 'arq_tenders.id')
                            ->where('arq_tenders.tender_number', '=', $tender_search);
                    });
                });
            }

            if ($supplier_search != '') {

                $query->whereHas('purchasingProcess.details', function ($q) use ($supplier_search) {
                    $q->join('arq_immediate_purchases', function ($join) use ($supplier_search) {
                        $join->on('arq_purchasing_process_detail.immediate_purchase_id', '=', 'arq_immediate_purchases.id')
                            ->where('arq_immediate_purchases.po_supplier_name', 'LIKE', '%' . $supplier_search . '%');
                        //->orwhere('arq_immediate_purchases.po_supplier_office_run','LIKE', '%'.$supplier_search.'%');
                    });
                })

                    ->orWhereHas('purchasingProcess.details', function ($q) use ($supplier_search) {
                        $q->join('arq_internal_purchase_orders', function ($join) use ($supplier_search) {
                            $join->on('arq_purchasing_process_detail.internal_purchase_order_id', '=', 'arq_internal_purchase_orders.id')
                                ->join('cfg_suppliers', function ($join) use ($supplier_search) {
                                    $join->on('arq_internal_purchase_orders.supplier_id', '=', 'cfg_suppliers.id')
                                        ->where('cfg_suppliers.name', 'LIKE', '%' . $supplier_search . '%');
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

            if ($subtype_search != '') {
                $query->where(function ($q) use ($subtype_search) {
                    $q->where('subtype', 'LIKE', $subtype_search.'%');
                });
            }

            if ($purchase_mechanism_search != '') {
                $query->where(function ($q) use ($purchase_mechanism_search) {
                    $q->where('purchase_mechanism_id', $purchase_mechanism_search);
                });
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

        return $this->getExpireAtAttribute()->diffInWeekDays(now());
    }

    /**
     * @return mixed
     */
    function getExpireAtAttribute()
    {
        if ($this->approved_at == null) {
            return null;
        }

        $daysToExpire = $this->purchaseType->supply_continuous_day;
        return $this->approved_at->addDays($daysToExpire);
    }

    function getPurchasedOnTimeAttribute()
    {
        $po_sent_dates = [];
        foreach ($this->purchasingProcess->details as $detail) {
            if ($detail->pivot->tender && $detail->pivot->tender->oc) $po_sent_dates[] = $detail->pivot->tender->oc->po_sent_date;
            if ($detail->pivot->directDeal && $detail->pivot->directDeal->oc) $po_sent_dates[] = $detail->pivot->directDeal->oc->po_sent_date;
            if ($detail->pivot->immediatePurchase) $po_sent_dates[] = $detail->pivot->immediatePurchase->po_sent_date;
        }

        // return '['.implode(', ', $po_sent_dates).']';
        if (count($po_sent_dates) == 0) return null;

        $max = max(array_map('strtotime', $po_sent_dates));
        return date('d-m-Y H:i', $max);

        // $this->approvedAt
    }

    /**
     * Este método crea un Certificado de Disponibilidad Presupuestaria 
     * para un Formulario de Requermiento
     * $requestForm->createCdp();
     * 
     * @return void
     */
    public function createCdp(): void
    {
        $financeEvent = $this->eventRequestForms->where('event_type', 'finance_event')->first();

        if ( !$financeEvent ) {
            // log
            logger()->error("No se pudo crear el CDP para el formulario de requerimiento {$this->id} porque no se encontró el evento finance_event");
            return;
        }

        $cdp = Cdp::create([
            'date'                   => $this->created_at,
            'file_path'              => $this->file_path,
            'request_form_id'        => $this->id,
            'user_id'                => null,
            'organizational_unit_id' => $financeEvent->signerOrganizationalUnit->id,
            'establishment_id'       => $financeEvent->signerOrganizationalUnit->establishment_id,
        ]);

        $url = route('request_forms.show', $this->id);

        $cdp->approval()->create([
            "module"                     => "CDP",
            "module_icon"                => "fas fa-file-invoice-dollar",
            "subject"                    => "Certificado de Disponibilidad Presupuestaria<br>Formulario 
                <a target=\"_blank\" href=\"$url\">#{$this->folio}</a>",
            "document_route_name"        => "finance.cdp.show",
            "document_route_params"      => json_encode([
                "cdp" => $cdp->id
            ]),
            "sent_to_ou_id"              => $financeEvent->signerOrganizationalUnit->id,
            "callback_controller_method" => "App\Http\Controllers\Finance\CdpController@approvalCallback",
            "callback_controller_params" => json_encode([]),
            "digital_signature"          => true,
            "filename"                   => "ionline/finance/cdp/" . time() . str()->random(30) . ".pdf",
        ]);
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

    public function canEdit()
    {
        $hasBudgetEvents = $this->eventRequestForms
            ->whereIn('event_type', ['budget_event', 'pre_budget_event', 'pre_finance_budget_event']);

        return in_array($this->status->value, ['saved', 'pending', 'rejected']) || 
            ($this->status->value == 'approved' && (!$this->purchasingProcess || $this->purchasingProcess->status->value == 'canceled'))  || 
                $hasBudgetEvents->last()?->status == 'rejected';
    }

    public function canDelete()
    {
        return $this->status->value == 'saved' || !$this->hasFirstEventRequestFormSigned();
    }

    public function hasEventRequestForms(){
        return $this->eventRequestForms->count() > 0;
    }

    public function hasFirstEventRequestFormSigned(){
        return $this->hasEventRequestForms() && $this->eventRequestForms->first()->status != 'pending';
    }

    public function getTrashedEventsWithComments()
    {
        return $this->eventRequestForms->whereNotNull('deleted_at')->whereNotNull('comment'); //where( fn($q) => $q->where('comment', '!=', null)->orWhere('comment', '!=', ' '));
    }

    public function hasFinanceEventPending()
    {
        $financePending = $this->eventRequestForms->where('event_type', 'finance_event')->where('status', 'pending')->count() > 0;
        $prefinanceApproved = $this->eventRequestForms->where('event_type', 'pre_finance_event')->where('status', 'approved')->count() > 0;
        return $this->hasEventRequestForms() && $financePending && $prefinanceApproved;
    }

    /**
     * Obtener el tipo de formulario de requerimiento, Bienes o Servicios
     * Corta la primera palabra, le pasa la primera letra a minúsucla
     * ej: 
     * bienes ejecución inmediata => Bienes
     * servicios ejecución tiempo => Servicios
     **/
    public function getSubTypeNameAttribute()
    {
        return ucfirst(strtok($this->subtype, " "));
    }
}
