<?php

namespace App\Http\Requests\Drugs;

use Illuminate\Foundation\Http\FormRequest;

class StoreActPrecursorRequest extends FormRequest
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
            'date'                  => 'required',
            'run_receiving'         => 'required|string|min:7|max:10',
            'full_name_receiving'   => 'required|string|min:5|max:255',
            'selected_precursors'   => 'required|array|min:1',
            'note'                  => 'nullable|string|max:5000',
        ];
    }
}
