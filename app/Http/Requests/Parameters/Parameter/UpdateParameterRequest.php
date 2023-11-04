<?php

namespace App\Http\Requests\Parameters\Parameter;

use App\Models\Parameters\Parameter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateParameterRequest extends FormRequest
{
    public $parameter;
    public $module;

    public function __construct(Parameter $parameter, $module)
    {
        $this->parameter = $parameter;
        $this->module = $module;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
                Rule::unique('cfg_parameters', 'parameter')
                    ->where('module', $this->module)
                    ->ignore($this->parameter)
            ],
            'module'            => 'required|string|max:255',
            'value'             => 'required|string|max:255',
            'description'       => 'nullable|string|max:255',
            'establishment_id'  => 'nullable|integer'
        ];
    }
}
