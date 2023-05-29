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
    public function rules($document)
    {
        $rules = [
            'document_number'       => 'required',
            'type_id'               => 'required|integer|exists:doc_types,id',
            'subject'               => 'required|string|min:3|max:255',
            'description'           => 'nullable|string|min:3|max:5000',
            'page'                  => 'required',
            'distribution'          => 'nullable',
            'recipients'            => 'nullable',
            'column_left_endorse'   => 'nullable',
            'column_center_endorse' => 'nullable',
            'column_right_endorse'  => 'nullable',
            'left_signatures'       => 'nullable|array|max:5',
            'center_signatures'     => 'nullable|array|max:5',
            'right_signatures'      => 'nullable|array|max:5',
        ];

        if(! isset($document))
            $rules['document_to_sign'] = 'required|mimes:pdf|max:10240';

        return $rules;
    }
}
