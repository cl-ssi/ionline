<?php

namespace App\Http\Requests\Inventory;

use App\Models\Inv\Inventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInventoryRequest extends FormRequest
{
    public $inventory;

    public function __construct(Inventory $inventory)
    {
        $this->inventory = $inventory;
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
            'number_inventory'  => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('inv_inventories', 'number')->ignore($this->inventory)
            ],
            'status'            => 'required',
            'useful_life'       => 'nullable|integer',
            'depreciation'      => 'nullable|string|min:0|max:255',
            'accounting_code_id'=> 'nullable|exists:fin_accounting_codes,id',
            'brand'             => 'nullable|string|min:0|max:255',
            'model'             => 'nullable|string|min:0|max:255',
            'serial_number'     => 'nullable|string|min:0|max:255',
            'observations'      => 'nullable|string|min:0|max:5000',
            'classification_id' => 'nullable|exists:inv_classifications,id',
        ];
    }
}
