<?php

namespace App\Http\Requests\Parameters\Parameter;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CreateParameterRequest extends FormRequest
{
    public $module;
    public $establishment_id;

    public function __construct($module, $establishment_id)
    {
        $this->module = $module;
        $this->establishment_id = $establishment_id;
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
        return [
            'parameter_field'   => [
                'required',
                'string',
                'max:255',
                Rule::unique('cfg_parameters', 'parameter')->where('module', $this->module)->where('establishment_id', $this->establishment_id)
            ],
            'module'            => 'required|string|max:255',
            'value'             => 'required|string|max:255',
            'description'       => 'nullable|string|max:255',
            'establishment_id'  => 'nullable|integer',
        ];
    }
}
