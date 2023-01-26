<?php

namespace App\Http\Requests\RequestForm;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'number'            => 'required|unique:arq_invoices,number',
            'date'              => 'required|date_format:Y-m-d',
            'amount'            => 'required|numeric|min:0',
            'file'              => 'required|mimes:pdf|max:10240',
            'selected_controls' => 'required|array|min:1',
        ];
    }
}
