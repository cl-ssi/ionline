<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequestForms\ItemRequestForm;
use App\Models\Parameters\PurchaseType;
use App\Models\Parameters\PurchaseUnit;
use App\Models\Parameters\PurchaseMechanism;


class PurchasingProcess extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_unit_id', 'purchase_type_id', 'purchase_mechanism_id', 'status', 'status_change_date', 'id_oc', 'id_internal_oc',
        'date_oc', 'shipping_date_oc', 'id_big_buy', 'peso_amount', 'dollar_amount', 'uf_amount', 'delivery_term', 'delivery_date',
        'id_offer', 'id_quotation', 'item_request_form_id',
    ];

    public function purchaseUnit(){
      return $this->belongsTo(PurchaseUnit::class, 'purchase_unit_id');
    }

    public function purchaseType(){
      return $this->belongsTo(PurchaseType::class, 'purchase_type_id');
    }

    public function purchaseMechanism(){
      return $this->belongsTo(PurchaseMechanism::class, 'purchase_mechanism_id');
    }

    public function itemRequestForm(){
      return $this->belongsTo(ItemRequestForm::class, 'item_request_form_id');
    }




    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'arq_purchasing_processes';
}
