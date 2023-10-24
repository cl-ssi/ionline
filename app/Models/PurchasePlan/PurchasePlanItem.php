<?php

namespace App\Models\PurchasePlan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PurchasePlanItem extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'article', 'unit_of_measurement', 'quantity', 'unit_value', 'specification',
        'tax','expense', 'article_file', 'unspsc_product_id', 'purchase_plan_id',
        'january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september',
        'october', 'november', 'december'
    ];

    public function unspscProduct() {
        return $this->belongsTo('App\Models\Unspsc\Product', 'unspsc_product_id');
    }

    public function purchasePlan() {
        return $this->belongsTo('App\Models\PurchasePlan\PurchasePlan', 'purchase_plan_id');
    }

    public function getScheduledQuantityAttribute(){
        return $this->january + $this->february + $this->march + $this->april + $this->may +  $this->june +
        $this->july + $this->august + $this->september + $this->october + $this->november + $this->december;
    }

    protected $table = 'ppl_purchase_plan_items';
}
