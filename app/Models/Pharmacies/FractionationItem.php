<?php

namespace App\Models\Pharmacies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FractionationItem extends Model
{
    use SoftDeletes;

    protected $table = 'frm_fractionation_items';

    protected $fillable = [
        'fractionation_id',
        'product_id',
        'amount',
        'unity',
        'due_date',
        'batch',
        'batch_id',
        'health_record'
    ];

    protected $casts = [
        'amount' => 'float',
        'due_date' => 'datetime'
    ];

    public function fractionation(): BelongsTo
    {
        return $this->belongsTo(Fractionation::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function batchRecord(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
}
