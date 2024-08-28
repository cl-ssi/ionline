<?php

namespace App\Models\Pharmacies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivingItem extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'frm_receiving_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'barcode',
        'receiving_id',
        'product_id',
        'amount',
        'unity',
        'due_date',
        //'serial_number',
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
     * Get the receiving that owns the receiving item.
     *
     * @return BelongsTo
     */
    public function receiving(): BelongsTo
    {
        return $this->belongsTo(Receiving::class, 'receiving_id');
    }

    /**
     * Get the product that owns the receiving item.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }

    /**
     * Get the batch that owns the receiving item.
     *
     * @return BelongsTo
     */
    public function batch_r(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
}
