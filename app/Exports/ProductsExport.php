<?php

namespace App\Exports;

use App\Models\Pharmacies\Product;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, ShouldAutoSize};

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::where('pharmacy_id',session('pharmacy_id'))->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'barcode',
            'experto_id',
            // 'unspsc_product_id',
            'name',
            'unit',
            'program',
            'expiration',
            'price',
            'stock',
            'critick stock', 
            'min stock',
            'max stock',
            'storage conditions'
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->barcode,
            $product->experto_id,
            // $product->unspsc_product_id,
            $product->name,
            $product->unit,
            $product->program->name,
            $product->expiration,
            $product->price,
            $product->stock,
            $product->critick_stock,
            $product->min_stock,
            $product->max_stock,
            $product->storage_conditions
        ];
    }
}
