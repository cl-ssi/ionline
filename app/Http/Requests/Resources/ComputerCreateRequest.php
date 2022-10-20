<?php

namespace App\Http\Requests\Resources;

use App\Models\Inv\Inventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComputerCreateRequest extends FormRequest
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
            'mac_address'       => [
                'required',
                'string',
                'max:255',
                Rule::unique('res_computers', 'mac_address')
            ],
            'inventory_brand'           => 'required|string|max:255',
            'inventory_model'           => 'required|string|max:255',
            'inventory_serial_number'   => 'required|string|max:255',
            'observations'      => 'nullable|string|max:5000',
            'status'            => 'required',
            'hostname'          => 'nullable|string|max:255',
            'domain'            => 'nullable|string|max:255',
            'ip'                => 'required|string|ip',
            'ip_group'          => 'required|string|max:255',
            'rack'              => 'nullable|string|max:255',
            'vlan'              => 'nullable|string|max:255',
            'network_segment'   => 'nullable|string|max:255',
            'operating_system'  => 'required|string|max:255',
            'processor'         => 'required|string|max:255',
            'ram'               => 'required|string|max:255',
            'hard_disk'         => 'required|string|max:255',
            'intesis_id'        => 'nullable|string|max:255',
            'comment'           => 'nullable|string|max:255',
            'active_type'       => 'required|string|max:255',
            'office_serial'     => 'nullable|string|max:255',
            'windows_serial'    => 'nullable|string|max:255',
        ];
    }
}
