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
        'status',
        'observations',
        'discharge_date',
        'act_number',
        'depreciation',
        'request_user_ou_id',
        'request_user_id',
        'product_id',
        'control_id',
        'store_id',
        'po_id',
        'request_form_id',
    ];

    protected $dates = [
        'po_date',
        'discharge_date',
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

    public function getPriceAttribute()
    {
        return money($this->po_price);
    }

    public function getPlaceAttribute()
    {
        $lastMovement = $this->movements->last();
        return ($lastMovement) ? $lastMovement->place : null;
    }

    public function getResponsibleAttribute()
    {
        $lastMovement = $this->movements->last();
        return ($lastMovement) ? $lastMovement->responsibleUser : null;
    }

    public function getDateAttribute()
    {
        $lastMovement = $this->movements->last();
        return ($lastMovement) ? $lastMovement->created_at->format('Y-m-d') : null;
    }
}
