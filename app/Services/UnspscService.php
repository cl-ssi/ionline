<?php

namespace App\Services;

use App\Models\Unspsc\Product;
use Illuminate\Support\Str;

class UnspscService
{
    public $products;
    public $sizeTitle;

    /**
     * @param  int  $sizeTile
     */
    public function __construct($sizeTitle = 90)
    {
        $this->sizeTitle = $sizeTitle;
    }

    /**
     * Obtiene todos los productos que coinciden con la búsqueda
     *
     * @param  string  $search
     * @return  \Illuminate\Support\Collection
     */
    public function getProducts($search)
    {
        $products = collect([]);

        if(!empty($search))
        {
            $code = is_numeric($search) ? $search : null;
            $search = Str::lower("%$search%");

            $products = Product::query()
                ->when($code, function ($q) use($code) {
                    $q->where('code', 'like', "%$code%");
                }, function($q) use ($search) {
                    $q->whereRaw('lower(`name`) LIKE ? ', $search)
                        ->orWhere(function ($query) use($search) {
                            $query->whereRaw('lower(`name`) LIKE ? ', $search)
                                ->whereHas('class', function ($subquery) use ($search) {
                                    $subquery->whereHas('family', function ($q) use($search) {
                                        $q->whereRaw('lower(`name`) LIKE ? ', $search);
                                    });
                                });
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->whereHas('class', function ($subquery) use($search) {
                                $subquery->whereRaw('lower(`name`) LIKE ? ', $search);
                            });
                        });
                })
                ->limit(500) // Limite para optimizar respuesta
                ->orderBy('class_id');
        }

        return $products;
    }

    /**
     * Obtiene el segmento, la familia y la clase de un producto
     *
     * @param  \App\Models\Unspsc\Product  $product
     * @return  string
     */
    public function getTitle($product)
    {
        return $product->class->family->segment->name .
            " / " . $product->class->family->name .
            " / " . $product->class->name;
    }

    /**
     * Retorna el resultado de la búsqueda bajo la estructura de Mercado Público de Chile.
     *
     * @param  string  $search
     * @return  \Illuminate\Support\Collection
     */
    public function search($search)
    {
        $products = $this->getProducts($search);

        $myProducts = $products->get();
        $classes = $products->groupBy('class_id')->pluck('class_id')->toArray();
        $results = collect([]);

        foreach($classes as $classId)
        {
            $productsOfClass = collect([]);
            foreach($myProducts->where('class_id', $classId) as $prod)
            {
                $product = $myProducts->where('class_id', $classId)->first();
                $productsOfClass->push([
                    'id' => $prod->id,
                    'code' => $prod->code,
                    'name' => $prod->short_name
                ]);
            }

            $title = $this->getTitle($product);

            if($productsOfClass->count() > 0)
            {
                $results->push([
                    'title' => Str::limit($title, $this->sizeTitle),
                    'products' => $productsOfClass->sortBy('name')->values(),
                ]);
            }

        }

        return $results->sort()->values();
    }
}
