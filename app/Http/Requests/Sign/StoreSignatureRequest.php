<?php

namespace App\Http\Requests\Sign;

use Illuminate\Foundation\Http\FormRequest;

class StoreSignatureRequest extends FormRequest
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
            'document_number'       => 'required',
            'type_id'               => 'required|integer|exists:doc_types,id',
            'subject'               => 'required|string|min:3|max:255',
            'description'           => 'nullable|string|min:3|max:5000',
            'page'                  => 'required',
            'document_to_sign'      => 'required|mimes:pdf|max:10240',
            'distribution'          => 'required',
            'recipients'            => 'required',
            'column_left_endorse'   => 'required',
            'column_center_endorse' => 'nullable',
            'column_right_endorse'  => 'nullable',
            'left_signatures'       => 'required|array|min:1|max:5',
            'center_signatures'     => 'nullable|array|max:5',
            'right_signatures'      => 'nullable|array|max:5',
        ];
    }
}
