<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ChangeProfilePasswordRequest
 */
class ChangeProfilePasswordRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'passwordOld'          => ['required', 'min:6', 'max:40', 'current_password'],
            'password'             => ['required', 'confirmed', 'min:6', 'max:40', 'string'],
            'passwordConfirmation' => ['required_with:password', 'string'],
        ];
    }
}
