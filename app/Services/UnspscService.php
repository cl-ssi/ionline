<?php

namespace App\Services;

use App\Models\Unspsc\Product;
use Illuminate\Support\Str;

class UnspscService
{
    public $products;
    public $sizeTitle;

    /**
     *
     * @param  $sizeTile
     */
    public function __construct($sizeTile = 90)
    {
        $this->sizeTitle = $sizeTile;
    }

    /**
     * Obtiene todos los productos que coinciden con la búsqueda
     *
     * @param  $search
     */
    public function getProducts($search)
    {
        $search = Str::lower("%$search%");

        $products = Product::query()
            ->whereRaw('lower(`name`) LIKE ? ', $search)
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
            })
            // ->limit(100) // Se pudiera limitar para mejorar la respuesta
            ->orderBy('class_id');

        return $products;
    }

    /**
     * Obtiene el segmento, la familia y la clase de un producto
     *
     * @param  $product
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
     * @param  $product
     */
    public function search($search)
    {
        $products = $this->getProducts($search);

        $myProducts = $products->get();
        $classes = $products->groupBy('class_id')->pluck('class_id')->toArray();
        $results = collect([]);

        foreach($classes as $class)
        {
            $product = $myProducts->first();
            $productsOfClass = collect([]);
            foreach($myProducts->where('class_id', $class) as $prod)
            {
                $productsOfClass->push([
                    'id' => $prod->id,
                    'code' => $prod->code,
                    'name' => $prod->short_name
                ]);
            }

            $title = $this->getTitle($product);
            $results->push([
                'title' => Str::limit($title, $this->sizeTitle),
                'products' => $productsOfClass,
            ]);
        }

        return $results;
    }
}
