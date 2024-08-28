<?php

namespace App\Models\Pharmacies;

use App\Models\Documents\SignaturesFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'frm_purchases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'date',
        'supplier_id',
        'purchase_order',
        'order_number',
        'notes',
        'invoice',
        'despatch_guide',
        'invoice_date',
        'commission',
        'pharmacy_id',
        'destination',
        'from',
        //'acceptance_certificate',
        'purchase_order_date',
        'doc_date',
        'purchase_order_amount',
        //'content',
        'invoice_amount',
        'user_id',
        'created_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
        'invoice_date' => 'datetime',
        'purchase_order_date' => 'datetime',
        'doc_date' => 'datetime',
    ];

    /**
     * Get the pharmacy that owns the purchase.
     *
     * @return BelongsTo
     */
    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }

    /**
     * Get the purchase items for the purchase.
     *
     * @return HasMany
     */
    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    /**
     * Get the supplier that owns the purchase.
     *
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the user that created the purchase.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the signed record associated with the purchase.
     *
     * @return BelongsTo
     */
    public function signedRecord(): BelongsTo
    {
        return $this->belongsTo(SignaturesFile::class, 'signed_record_id');
    }
}
