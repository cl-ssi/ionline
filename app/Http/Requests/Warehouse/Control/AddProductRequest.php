<?php

namespace App\Http\Requests\Warehouse\Control;

use App\Models\Warehouse\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddProductRequest extends FormRequest
{
    public $max_quantity;
    public $store_id;

    public function __construct($store_id, $max_quantity)
    {
        $this->store_id = $store_id;
        $this->max_quantity = $max_quantity;
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
            'quantity'      => 'required|integer|min:0|max:' . $this->max_quantity,
            'description'   => 'required',
            'barcode'       => [
                'nullable',
                'string',
                'min:1',
                'max:255',
                Rule::unique('wre_products', 'barcode')->where('store_id', $this->store_id)
            ],
        ];
    }
}
