<?php

namespace App\Models\Inv;

use App\Models\Establishment;
use App\Models\Finance\AccountingCode;
use App\Models\Finance\Dte;
use App\Models\Parameters\BudgetItem;
use App\Models\Parameters\Place;
use App\Models\RequestForms\PurchaseOrder;
use App\Models\RequestForms\RequestForm;
use App\Models\Resources\Computer;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Unspsc\Product as UnspscProduct;
use App\Models\User;
use App\Models\Warehouse\Control;
use App\Models\Warehouse\Product;
use App\Models\Warehouse\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Inventory extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inv_inventories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'old_number',
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
        'internal_description',
        'establishment_id',
        'request_user_ou_id',
        'request_user_id',
        'user_responsible_id',
        'user_using_id',
        'user_sender_id',
        'place_id',
        'product_id',
        'unspsc_product_id',
        'control_id',
        'store_id',
        'po_id',
        'request_form_id',
        'budget_item_id',
        'accounting_code_id',
        'printed',
        'observation_delete',
        'user_delete_id',
        'classification_id',

        // proceso de dar de baja a un inventario
        'removal_request_reason',
        'removal_request_reason_at',
        'is_removed',
        'removed_user_id',
        'removed_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'printed' => 'boolean',
        'po_date' => 'date',
        'discharge_date' => 'date',
        'deliver_date' => 'date',
    ];

    /**
     * Documentos Tributarios
     */
    public function dtes(): HasMany
    {
        return $this->hasMany(Dte::class, 'folio_oc', 'po_code');
    }

    /**
     * Get the establishment that owns the inventory.
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }

    /**
     * Get the classification that owns the inventory.
     */
    public function classification(): BelongsTo
    {
        return $this->belongsTo(Classification::class);
    }

    /**
     * Get the organizational unit that owns the inventory.
     */
    public function requestOrganizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'request_user_ou_id');
    }

    /**
     * Get the user that requested the inventory.
     */
    public function requestUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'request_user_id')->withTrashed();
    }

    /**
     * Get the product that owns the inventory.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the UNSPSC product that owns the inventory.
     */
    public function unspscProduct(): BelongsTo
    {
        return $this->belongsTo(UnspscProduct::class);
    }

    /**
     * Get the control that owns the inventory.
     */
    public function control(): BelongsTo
    {
        return $this->belongsTo(Control::class);
    }

    /**
     * Get the store that owns the inventory.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the purchase order that owns the inventory.
     */
    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }

    /**
     * Get the request form that owns the inventory.
     */
    public function requestForm(): BelongsTo
    {
        return $this->belongsTo(RequestForm::class);
    }

    /**
     * Get the movements for the inventory.
     */
    public function movements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    /**
     * Get the pending movements for the inventory.
     */
    public function pendingMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class)->where('reception_confirmation', false);
    }

    /**
     * Get the last movement for the inventory.
     */
    public function lastMovement(): HasOne
    {
        return $this->hasOne(InventoryMovement::class)->latest();
    }

    /**
     * Get the last movement reception date for the inventory.
     */
    public function lastMovementReceptionDate(): HasOne
    {
        return $this->hasOne(InventoryMovement::class)
            ->latest()
            ->select('reception_date');
    }

    /**
     * Get the last confirmed movement for the inventory.
     */
    public function lastConfirmedMovement(): HasOne
    {
        return $this->hasOne(InventoryMovement::class)
            ->where('reception_confirmation', true)
            ->orderBy('reception_date', 'desc')
            ->orderBy('id', 'desc');
    }

    /**
     * Get the responsible user for the inventory.
     */
    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_responsible_id')->withTrashed();
    }

    /**
     * Get the removed user for the inventory.
     */
    public function removedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'removed_user_id')->withTrashed();
    }

    /**
     * Get the user using the inventory.
     */
    public function using(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_using_id')->withTrashed();
    }

    /**
     * Get the place that owns the inventory.
     */
    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }

    /**
     * Get the budget item that owns the inventory.
     */
    public function budgetItem(): BelongsTo
    {
        return $this->belongsTo(BudgetItem::class);
    }

    /**
     * Get the computer that owns the inventory.
     */
    public function computer(): HasOne
    {
        return $this->hasOne(Computer::class);
    }

    /**
     * Get the inventory users for the inventory.
     */
    public function inventoryUsers(): HasMany
    {
        return $this->hasMany(InventoryUser::class);
    }

    /**
     * Get the accounting code that owns the inventory.
     */
    public function accountingCode(): BelongsTo
    {
        return $this->belongsTo(AccountingCode::class);
    }

    /**
     * Get the user who deleted the inventory.
     */
    public function userDelete(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_delete_id');
    }

    /**
     * Check if the inventory is a computer.
     */
    public function isComputer(): bool
    {
        return Computer::whereInventoryNumber($this->number)->exists();
    }

    /**
     * Get the QR code for the inventory.
     */
    public function getQrAttribute(): string
    {
        return QrCode::size(150)
            ->generate(route('inventories.show', [
                'establishment' => $this->establishment_id,
                'number' => $this->number,
            ]));
    }

    /**
     * Get the small QR code for the inventory.
     */
    public function getQrSmallAttribute(): string
    {
        return QrCode::size(74)
            ->generate(route('inventories.show', [
                'establishment' => $this->establishment_id,
                'number' => $this->number,
            ]));
    }

    /**
     * Get the computer associated with the inventory.
     */
    public function getMyComputerAttribute(): ?Computer
    {
        $computer = null;
        if ($this->isComputer()) {
            $computer = Computer::whereInventoryNumber($this->number)->first();
        }

        return $computer;
    }

    /**
     * Check if the inventory has a computer.
     */
    public function getHaveComputerAttribute(): bool
    {
        return $this->isComputer();
    }

    /**
     * Get the location of the inventory.
     */
    public function getLocationAttribute(): ?string
    {
        if ($this->place) {
            return $this->place?->name.', '.$this->place?->location?->name;
        }

        return null;
    }

    /**
     * Get the subtitle of the inventory.
     */
    public function getSubtitleAttribute(): ?string
    {
        if ($this->budgetItem) {
            return Str::of($this->budgetItem->code)->substr(0, 2);
        }

        return null;
    }

    /**
     * Get the price of the inventory.
     */
    public function getPriceAttribute(): string
    {
        return money($this->po_price);
    }

    /**
     * Get the status of the inventory.
     */
    public function getEstadoAttribute(): string
    {
        switch ($this->status) {
            case 1:
                return 'Bueno';
            case 0:
                return 'Regular';
            case -1:
                return 'Malo';
            default:
                return 'Desconocido';
        }
    }

    /**
     * Get the formatted date of the inventory.
     */
    public function getFormatDateAttribute(): string
    {
        return now()->day.' de '.now()->monthName.' del '.now()->year;
    }

    public function generateInventoryNumber()
    {
        if ($this->unspscProduct) {
            return $this->unspscProduct->code.'-'.$this->id;
        }

        return null;
    }
}
