<?php

namespace App\Http\Requests\Warehouse\Control;

use App\Models\Warehouse\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddProductRequest extends FormRequest
{
    public $max_quantity;
    public $store_id;
    public $type_product;

    public function __construct($store_id, $max_quantity, $type_product)
    {
        $this->store_id = $store_id;
        $this->max_quantity = $max_quantity;
        $this->type_product = $type_product;
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
            'type_product'  => 'required',
            'quantity'      => 'required|integer|min:0|max:' . $this->max_quantity,
            'description'   => 'required|string|min:2|max:255',
            'barcode'       => [
                'nullable',
                'string',
                'min:1',
                'max:255',
                ($this->type_product == 1) ? Rule::unique('wre_products', 'barcode')->where('store_id', $this->store_id) : ''
            ],
        ];
    }
}
