<?php

namespace App\Http\Requests\Rrhh;

use Illuminate\Foundation\Http\FormRequest;

class updatePassword extends FormRequest
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
            'password'              => 'required',
            'newpassword'           => 'required|min:4',
            'newpassword_confirm'   => 'required|same:newpassword'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.required'             => '"Clave Actual" es requerida.',
            'newpassword.required'          => '"Nueva Clave" es requerida.',
            'newpassword.min'               => '"Nueva Clave" debe tener más de 4 caracteres.',
            'newpassword_confirm.required'  => '"Confirmar Nueva Clave" es requerida.',
            'newpassword_confirm.same'      => '"Nueva Clave" y "Confirmar Nueva Clave" no coinciden.',
        ];
    }
}
