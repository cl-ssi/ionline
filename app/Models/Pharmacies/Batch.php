<?php

namespace App\Models\Pharmacies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'frm_batchs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'product_id',
        'due_date',
        'batch',
        'count',
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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // Añadir atributos ocultos aquí si es necesario
    ];

    /**
     * Get the dispatch items for the batch.
     *
     * @return HasMany
     */
    public function dispatchItems(): HasMany
    {
        return $this->hasMany(DispatchItem::class);
    }

    /**
     * Get the purchase items for the batch.
     *
     * @return HasMany
     */
    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    /**
     * Get the receiving items for the batch.
     *
     * @return HasMany
     */
    public function receivingItems(): HasMany
    {
        return $this->hasMany(ReceivingItem::class);
    }
}
