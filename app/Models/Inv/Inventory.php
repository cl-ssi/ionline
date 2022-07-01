<?php

namespace App\Models\Inv;

use App\Models\RequestForms\PurchaseOrder;
use App\Models\RequestForms\RequestForm;
use App\Models\Warehouse\Control;
use App\Models\Warehouse\Product;
use App\Models\Warehouse\Store;
use App\Models\Parameters\Place;
use App\Rrhh\OrganizationalUnit;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'reception_confirmation',
        'deliver_date',
        'delivered_user_ou_id',
        'delivered_user_id',
        'request_user_ou_id',
        'request_user_id',
        'product_id',
        'control_id',
        'store_id',
        'place_id',
        'po_id',
        'request_form_id',
    ];

    public function deliveredOrganizationalUnit()
    {
        return $this->belongsTo(OrganizationalUnit::class, 'delivered_user_ou_id');
    }

    public function deliveredUser()
    {
        return $this->belongsTo(User::class, 'delivered_user_id');
    }

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

    public function control()
    {
        return $this->belongsTo(Control::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }

    public function requestForm()
    {
        return $this->belongsTo(RequestForm::class);
    }
}
