<?php

namespace App\Http\Requests\Resources;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Resources\Telephone;
use Illuminate\Validation\Rule;

class StoreTelephoneRequest extends FormRequest
{
    public function response(array $errors){
        return \Redirect::back()->withErrors($errors)->withInput();
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
        // $this->redirect = redirect()->back()->withImput();

        return [
            'number' => 'required|unique:res_telephones,number',
            'mac'    => 'nullable|unique:res_telephones,mac',
            'minsal' => 'required|unique:res_telephones,minsal',
        ];
    }

    public function messages()
    {
        return [
            'number.required'               => 'Número de Teléfono requerido',
            'number.unique'                 => 'El número de Teléfono ya está ingresado.',
            'mac.unique'                    => 'Dirección MAC ya está ingresada.',
            'minsal.required'               => 'Anexo Minsal requerido.',
            'minsal.unique'                 => 'Anexo Minsal ya está ingresado.'
        ];
    }

}
