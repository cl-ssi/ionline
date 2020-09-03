<?php

namespace App\Http\Requests\Resources;

use Illuminate\Foundation\Http\FormRequest;
use App\Resources\Telephone;
use Illuminate\Validation\Rule;

class UpdateTelephoneRequest extends FormRequest
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
            'number' => ['required', Rule::unique('res_telephones','number' )->ignore($this->telephone)],
            'mac'    => Rule::unique('res_telephones','mac' )->ignore($this->telephone),
            'minsal' => ['required', Rule::unique('res_telephones','minsal' )->ignore($this->telephone)]
        ];
    }

    public function messages()
    {
        return [
            'number.required'               => 'Número de Teléfono requerido',
            'number.unique'                 => 'El número de Teléfono ya está ingresado.',
            'mac.unique'                    => 'Número de MAC ya está ingresado.',
            'minsal.required'               => 'Número Minsal requerido.',
            'minsal.unique'                 => 'El número Minsal ya está ingresado.'
        ];
    }

}
