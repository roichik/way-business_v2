<?php

namespace App\Http\Requests\Api\User\Profile;

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
            'password_old'          => ['required', 'min:6', 'max:40', 'current_password'],
            'password'              => ['required', 'confirmed', 'min:6', 'max:40', 'string'],
            'password_confirmation' => ['required_with:password', 'string'],
        ];
    }
}
