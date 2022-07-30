<?php

namespace App\Http\Requests\Warehouse\Product;

use App\Models\Warehouse\Product;
use App\Models\Warehouse\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditProductRequest extends FormRequest
{
    public $store;
    public $product;

    public function __construct(Store $store, Product $product)
    {
        $this->store = $store;
        $this->product = $product;
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required|string|min:3|max:255',
            'barcode'           => [
                'nullable',
                'string',
                'min:2',
                'max:255',
                Rule::unique('wre_products', 'barcode')
                    ->where('store_id', $this->store->id)
                    ->ignore($this->product)
            ],
            'category_id'       => 'nullable|exists:wre_categories,id',
            'unspsc_product_id' => 'required|exists:unspsc_products,id',
        ];
    }
}
