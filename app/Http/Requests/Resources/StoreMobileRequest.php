<?php

namespace App\Http\Requests\Resources;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMobileRequest extends FormRequest
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
          'number' => ['required', Rule::unique('res_mobiles','number' )]
      ];
    }

    public function messages()
    {
        return [
            'number.required'               => 'Número de Teléfono Móvil requerido.',
            'number.unique'                 => 'El número de Teléfono Móvil ya está ingresado.'
        ];
    }
}
