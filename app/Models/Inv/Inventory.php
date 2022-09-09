<?php

namespace App\Models\Inv;

use App\Models\Parameters\BudgetItem;
use App\Models\RequestForms\PurchaseOrder;
use App\Models\RequestForms\RequestForm;
use App\Models\Warehouse\Control;
use App\Models\Warehouse\Product;
use App\Models\Warehouse\Store;
use App\Models\Parameters\Place;
use App\Models\Unspsc\Product as UnspscProduct;
use App\Rrhh\OrganizationalUnit;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inv_inventories';

    protected $fillable = [
        'number',
        'useful_life',
        'brand',
        'model',
        'serial_number',
        'po_code',
        'po_price',
        'po_date',
        'status',
        'observations',
        'discharge_date',
        'act_number',
        'depreciation',
        'deliver_date',
        'description',
        'request_user_ou_id',
        'request_user_id',
        'user_responsible_id',
        'user_using_id',
        'place_id',
        'product_id',
        'unspsc_product_id',
        'control_id',
        'store_id',
        'po_id',
        'request_form_id',
        'budget_item_id',
    ];

    protected $dates = [
        'po_date',
        'discharge_date',
        'deliver_date',
    ];

    public function requestOrganizationalUnit()
    {
        return $this->belongsTo(OrganizationalUnit::class, 'request_user_ou_id');
    }

    public function requestUser()
    {
        return $this->belongsTo(User::class, 'request_user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unspscProduct()
    {
        return $this->belongsTo(UnspscProduct::class);
    }

    public function control()
    {
        return $this->belongsTo(Control::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }

    public function requestForm()
    {
        return $this->belongsTo(RequestForm::class);
    }

    public function movements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function lastMovement()
    {
        return $this->hasOne(InventoryMovement::class)->latest();
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'user_responsible_id');
    }

    public function using()
    {
        return $this->belongsTo(User::class, 'user_using_id');
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function budgetItem()
    {
        return $this->belongsTo(BudgetItem::class);
    }

    public function getSubtitleAttribute()
    {
        if($this->budgetItem)
            return Str::of($this->budgetItem->code)->substr(0, 2);
        else
            return null;
    }

    public function getPriceAttribute()
    {
        return money($this->po_price);
    }
}
