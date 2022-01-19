<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequestForms\ItemRequestForm;
use App\Models\Parameters\PurchaseType;
use App\Models\Parameters\PurchaseUnit;
use App\Models\Parameters\PurchaseMechanism;
use CreateArqPurchasingProcessDetailTable;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * Diferentes estados del Proceso de Compra
 * ========================================
 * status:
 * not_available:  no disponible por parte del oferente
 * timed_out: caducado, excedido tiempo transcurrido según ley
 * desert: no se encuentra en el mercado
 * partial: entrega Parcial
 * total: entrega total
 * in_progress: en progreso (en proceso)

 Falta de presupuesto
 item se compra
 recepción conforme
 estado de pago, enviado a pugo
pagado

presupuesto por item optativo

firma electronica, enlace bodega
 **/


class PurchasingProcess extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        // 'purchase_unit_id', 'purchase_type_id', 'purchase_mechanism_id', 'status', 'status_change_date', 'id_oc', 'id_internal_oc',
        // 'date_oc', 'shipping_date_oc', 'id_big_buy', 'peso_amount', 'dollar_amount', 'uf_amount', 'delivery_term', 'delivery_date',
        // 'id_offer', 'id_quotation', 'item_request_form_id',

        'purchase_mechanism_id', 'purchase_type_id', 'start_date', 'end_date',
        'status', 'observation', 'user_id'
    ];

    public function internalPurchaseOrder(){
        return $this->hasMany(InternalPurchaseOrder::class, 'purchasing_process_id');
    }

    public function purchaseMechanism(){
      return $this->belongsTo(PurchaseMechanism::class, 'purchase_mechanism_id');
    }

    public function details(){
        return $this->belongsToMany(ItemRequestForm::class, 'arq_purchasing_process_detail')->withPivot('id', 'internal_purchase_order_id', 'petty_cash_id', 'fund_to_be_settled_id', 'user_id', 'quantity', 'unit_value', 'expense', 'status')->whereNull('arq_purchasing_process_detail.deleted_at')->withTimestamps()->using(PurchasingProcessDetail::class);
    }

    public function getExpense(){
        return $this->details->sum('pivot.expense');
    }

    public function requestForm(){
        return $this->belongsTo(RequestForm::class);
    }

    // public function purchaseUnit(){
    //   return $this->belongsTo(PurchaseUnit::class, 'purchase_unit_id');
    // }
    //
    // public function purchaseType(){
    //   return $this->belongsTo(PurchaseType::class, 'purchase_type_id');
    // }
    //
    // public function purchaseMechanism(){
    //   return $this->belongsTo(PurchaseMechanism::class, 'purchase_mechanism_id');
    // }
    //
    // public function itemRequestForm(){
    //   return $this->belongsTo(ItemRequestForm::class, 'item_request_form_id');
    // }

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'arq_purchasing_processes';
}
