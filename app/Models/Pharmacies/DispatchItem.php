<?php

namespace App\Models\Pharmacies;

use App\Models\Pharmacies\Batch;
use App\Models\Pharmacies\Dispatch;
use App\Models\Pharmacies\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DispatchItem extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'frm_dispatch_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'barcode',
        'dispatch_id',
        'product_id',
        'amount',
        'unity',
        'due_date',
        'batch',
        'batch_id',
        'created_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'due_date' => 'datetime',
    ];

    /**
     * Get the dispatch that owns the dispatch item.
     *
     * @return BelongsTo
     */
    public function dispatch(): BelongsTo
    {
        return $this->belongsTo(Dispatch::class);
    }

    /**
     * Get the product that owns the dispatch item.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    /**
     * Get the batch that owns the dispatch item.
     *
     * @return BelongsTo
     */
    public function batch_r(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
}
