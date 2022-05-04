<?php

namespace App\Models\Warehouse;

use App\Models\Unspsc\Product as UnspscProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'wre_products';

    protected $fillable = [
        'name',
        'barcode',
        'store_id',
        'category_id',
        'unspsc_product_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // TODO: Se pudiera renombrar la relacion
    public function product()
    {
        return $this->belongsTo(UnspscProduct::class, 'unspsc_product_id');
    }
}
