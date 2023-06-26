<?php

namespace App\Models\Inv;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;
use App\Rrhh\OrganizationalUnit;
use App\Models\Warehouse\Store;
use App\Models\Warehouse\Product;
use App\Models\Warehouse\Control;
use App\Models\Unspsc\Product as UnspscProduct;
use App\Models\Resources\Computer;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\PurchaseOrder;
use App\Models\Parameters\Place;
use App\Models\Parameters\BudgetItem;
use App\Models\Finance\Dte;
use App\Models\Finance\AccountingCode;

class Inventory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
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
        'dte_number',
        'status',
        'observations',
        'discharge_date',
        'act_number',
        'depreciation',
        'deliver_date',
        'description',
        'establishment_id',
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
        'accounting_code_id',
    ];

    protected $dates = [
        'po_date',
        'discharge_date',
        'deliver_date',
    ];

    protected $appends = [
        'have_computer',
    ];

    /** Documentos Tributarios */
    public function dtes()
    {
        return $this->hasMany(Dte::class,'folio_oc','po_code');
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
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

    public function computer()
    {
        return $this->hasOne(Computer::class);
    }

    public function accountingCode()
    {
        return $this->belongsTo(AccountingCode::class);
    }

    public function isComputer()
    {
        return Computer::whereInventoryNumber($this->number)->exists();
    }

    public function getQrAttribute() {
        return QrCode::size(150)->generate(route('inventories.show', ['number' => $this->number]));
    }

    public function getMyComputerAttribute()
    {
        $computer = null;
        if($this->isComputer())
            $computer = Computer::whereInventoryNumber($this->number)->first();
        return $computer;
    }

    public function getHaveComputerAttribute()
    {
        return $this->isComputer();
    }

    public function getLocationAttribute()
    {
        return $this->place->name . ", " . $this->place->location->name;
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

	public function getEstadoAttribute()
	{
		switch($this->status)
		{
			case 1: return 'Bueno'; break;
			case 0: return 'Regular'; break;
			case -1: return 'Malo'; break;
		}
	}
}
