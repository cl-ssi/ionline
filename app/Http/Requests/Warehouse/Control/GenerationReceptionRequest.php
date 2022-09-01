<?php

namespace App\Http\Requests\Warehouse\Control;

use Illuminate\Foundation\Http\FormRequest;

class GenerationReceptionRequest extends FormRequest
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
            'date'                              => 'required|date_format:Y-m-d',
            'po_code'                           => 'required',
            'po_date'                           => 'required|date_format:Y-m-d H:i:s',
            'po_items'                          => 'required|array|min:1',
            'guide_number'                      => 'nullable|string|min:1|max:255',
            'guide_date'                        => 'nullable|date_format:Y-m-d',
            'note'                              => 'nullable|string|min:1|max:255',
            'program_id'                        => 'nullable|exists:cfg_programs,id',
            'signer_id'                         => 'required|integer|exists:users,id',
            'po_items.*.unspsc_product_code'    => 'required',
        ];
    }
}
