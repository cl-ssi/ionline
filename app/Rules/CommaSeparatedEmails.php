<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CommaSeparatedEmails implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return Validator::make(
            [
                "attribute" => explode(',', $value)
            ],
            [
                "attribute.*" => 'required|email:rfc'
            ]
        )->passes();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'El campo :attribute debe tener correos válidos.';
    }
}
