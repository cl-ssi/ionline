<?php

namespace App\Http\Requests\Parameters\OrganizationalUnit;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationalUnitRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'                      => 'required|string|max:255',
            'establishment_id'          => 'required|exists:establishments,id',
            'organizational_unit_id'    => 'required|exists:organizational_units,id',
            'sirh_function'             => 'nullable|integer',
            'sirh_ou_id'                => 'nullable|unique:organizational_units,sirh_ou_id',
            'sirh_cost_center'          => 'nullable|string'
        ];
    }
}
