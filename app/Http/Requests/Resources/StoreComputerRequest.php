<?php

namespace App\Http\Requests\Resources;

use Illuminate\Foundation\Http\FormRequest;
use App\Resources\Computer;
use Illuminate\Validation\Rule;

class StoreComputerRequest extends FormRequest
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
          'mac_address' => ['required', Rule::unique('res_computers','mac_address' )->ignore($this->computer)]
      ];
    }

    public function messages()
    {
        return [
            'mac_address.unique'            => 'Dirección MAC ya está ingresada.',
            'mac_address.required'          => 'Dirección MAC requerida.'
        ];
    }

}
