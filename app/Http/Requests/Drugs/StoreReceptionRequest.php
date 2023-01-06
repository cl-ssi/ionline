<?php

namespace App\Http\Requests\Drugs;

use Illuminate\Foundation\Http\FormRequest;

class StoreReceptionRequest extends FormRequest
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
            'parte_label'               => 'required',
            'parte'                     => 'required|string|max:255',
            'parte_police_unit_id'      => 'required|exists:drg_police_units,id',
            'court_id'                  => 'required|exists:drg_courts,id',
            'document_number'           => 'required|string|max:255',
            'document_police_unit_id'   => 'required|exists:drg_police_units,id',
            'document_date'             => 'required|date_format:Y-m-d',
            'delivery'                  => 'nullable|string|max:255',
            'delivery_run'              => 'nullable|string|max:255',
            'delivery_position'         => 'nullable|string|max:255',
            'imputed'                   => 'nullable|string|max:255',
            'imputed_run'               => 'nullable|string|max:255',
            'observation'               => 'nullable|string|max:5000',
        ];
    }
}
