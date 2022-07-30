<?php

namespace App\Http\Requests\Warehouse\Product;

use App\Models\Warehouse\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateProductRequest extends FormRequest
{
    public $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
                Rule::unique('wre_products', 'barcode')->where('store_id', $this->store->id)
            ],
            'category_id'       => 'nullable|exists:wre_categories,id',
            'unspsc_product_id' => 'required|exists:unspsc_products,id',
        ];
    }
}
