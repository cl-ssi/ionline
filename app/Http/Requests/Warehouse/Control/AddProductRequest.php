<?php

namespace App\Http\Requests\Warehouse\Control;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
{
    public $max_quantity;

    public function __construct($max_quantity)
    {
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
            'barcode'       => 'nullable', // definir
        ];
    }
}
