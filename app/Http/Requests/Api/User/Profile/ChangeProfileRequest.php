<?php

namespace App\Http\Requests\Api\User;

use App\Dictionaries\User\UserGenderDictionary;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class ChangeProfileRequest
 */
class ChangeProfileRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'phone'                => ['nullable', 'string', 'max:50'],
            'detail.firstName'     => ['required', 'string', 'max:50',],
            'detail.lastName'      => ['required', 'string', 'max:50',],
            'detail.fatherName'    => ['nullable', 'string', 'max:50',],
            'detail.gender'        => ['required', 'string', Rule::in(UserGenderDictionary::getCollection())],
            'detail.birthdayAt'    => ['date'],
        ];
    }
}
