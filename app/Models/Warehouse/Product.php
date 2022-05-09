<?php

namespace App\Models\Warehouse;

use App\Models\Cfg\Program;
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

    public function product()
    {
        return $this->belongsTo(UnspscProduct::class, 'unspsc_product_id');
    }

    public function getCategoryNameAttribute()
    {
        $categoryName = 'Sin Categoría';
        if($this->category)
            $categoryName = $this->category->name;
        return $categoryName;
    }

    public static function lastBalance(Product $product, Program $program)
    {
        $controlItem = ControlItem::query()
            ->whereProductId($product->id)
            ->whereProgramId($program->id)
            ->latest()
            ->first();

        if($controlItem)
        {
            return $controlItem->balance;
        }

        return 0;
    }

    public static function outStock(Program $program)
    {
        $productIds = collect([]);

        $controlItems = ControlItem::query()
            ->whereProgramId($program->id)
            ->groupBy('product_id')
            ->get();

        foreach($controlItems as $controlItem)
        {
            $lastBalance = Product::lastBalance($controlItem->product, $controlItem->program);
            if($lastBalance == 0)
                $productIds->push($controlItem->product_id);
        }

        return $productIds;
    }
}
