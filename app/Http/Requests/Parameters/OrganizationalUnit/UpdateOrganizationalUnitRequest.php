<?php

namespace App\Http\Requests\Parameters\OrganizationalUnit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateOrganizationalUnitRequest extends FormRequest
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
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        return [
            'name'                      => 'required|string|max:255',
            'establishment_id'          => 'nullable|exists:establishments,id',
            'organizational_unit_id'    => 'required|exists:organizational_units,id',
            'sirh_function'             => 'nullable|integer',
            'sirh_ou_id'                => 'nullable|unique:organizational_units,sirh_ou_id,'.$request->organizationalUnitId,
            'sirh_cost_center'          => 'nullable|string'
        ];
    }
}
