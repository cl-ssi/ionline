<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegisterInventoryRequest extends FormRequest
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
            'unspsc_product_id' => 'required|exists:unspsc_products,id',
            'description'       => 'required|string|max:255',
            'number_inventory'  => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('inv_inventories', 'number')
            ],
            'brand'             => 'nullable|max:255',
            'model'             => 'nullable|max:255',
            'serial_number'     => 'nullable|max:255',
            'status'            => 'required|max:255',
            'useful_life'       => 'nullable|integer',
            'depreciation'      => 'nullable|string|min:0|max:255',
            'accounting_code_id'=> 'nullable|exists:fin_accounting_codes,id',
            'observations'      => 'nullable|max:255',
            'user_using_id'     => (auth()->user()->can('Inventory: manager'))
                                    ? 'nullable|exists:users,id'
                                    : 'required|exists:users,id',
            'user_responsible_id'   => 'required|exists:users,id',
            'place_id'              => 'required|exists:cfg_places,id',
            'request_form_id'       => 'nullable|exists:arq_request_forms,id',
            'po_id'                 => 'nullable|exists:arq_purchase_orders,id',
            'po_date'               => 'nullable|date_format:Y-m-d H:i:s',
            'po_price'              => 'nullable|numeric',
            'deliver_date'          => 'nullable|date_format:Y-m-d',
        ];
    }
}
