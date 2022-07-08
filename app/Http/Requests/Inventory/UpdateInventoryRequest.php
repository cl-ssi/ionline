<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInventoryRequest extends FormRequest
{
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
            'number_inventory'  => 'required|string|min:2|max:255',
            'useful_life'       => 'required',
            'status'            => 'required',
            'depreciation'      => 'required',
            'brand'             => 'nullable|string|min:0|max:255',
            'model'             => 'nullable|string|min:0|max:255',
            'serial_number'     => 'nullable|string|min:0|max:255',
            'observations'      => 'nullable|string|min:0|max:5000'
        ];
    }
}
