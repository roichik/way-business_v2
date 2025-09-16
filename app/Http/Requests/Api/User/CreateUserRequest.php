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
            'nickname'             => ['required', 'string', 'max:100'],
            'email'                => ['required', 'unique:users', 'email', 'max:50'],
            'emailVerifiedAt'      => ['nullable', 'date'],
            'phone'                => ['nullable', 'string', 'max:50'],
            'phoneVerifiedAt'      => ['nullable', 'date'],
            'password'             => ['required', 'confirmed', 'min:6', 'max:40', 'string'],
            'passwordConfirmation' => ['required_with:password', 'string'],
            'isEnabled'            => ['boolean'],
            'detail.firstName'     => ['required', 'string', 'max:50',],
            'detail.lastName'      => ['required', 'string', 'max:50',],
            'detail.fatherName'    => ['nullable', 'string', 'max:50',],
            'detail.gender'        => ['required', 'string', Rule::in(UserGenderDictionary::getCollection())],
            'detail.birthdayAt'    => ['date'],
            'detail.typeId'        => ['required', 'exists:user_types,id'],
            'detail.companyId'     => ['nullable', 'exists:companies,id'],
            'detail.divisionId'    => ['nullable', 'exists:divisions,id'],
            'detail.positionId'    => ['nullable', 'exists:positions,id'],
        ];
    }
}
