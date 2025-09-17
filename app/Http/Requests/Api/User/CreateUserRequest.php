<?php

namespace App\Http\Requests\Api\User;

use App\Dictionaries\User\UserGenderDictionary;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class CreateUserRequest
 */
class CreateUserRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'nickname'              => ['required', 'unique:users', 'string', 'max:100'],
            'email'                 => ['required', 'unique:users', 'email', 'max:50'],
            'email_verified_at'     => ['nullable', 'date'],
            'phone'                 => ['nullable', 'string', 'max:50'],
            'phone_verified_at'     => ['nullable', 'date'],
            'password'              => ['required', 'confirmed', 'min:6', 'max:40', 'string'],
            'password_confirmation' => ['required_with:password', 'string'],
            'is_enabled'            => ['boolean'],
            'detail.first_name'     => ['required', 'string', 'max:50',],
            'detail.last_name'      => ['required', 'string', 'max:50',],
            'detail.father_name'    => ['nullable', 'string', 'max:50',],
            'detail.gender'         => ['required', 'string', Rule::in(UserGenderDictionary::getCollection())],
            'detail.birthday_at'    => ['date'],
            'detail.type_id'        => ['required', 'exists:user_types,id'],
            'detail.company_id'     => ['nullable', 'exists:companies,id'],
            'detail.division_id'    => ['nullable', 'exists:divisions,id'],
            'detail.position_id'    => ['nullable', 'exists:positions,id'],
        ];
    }
}
