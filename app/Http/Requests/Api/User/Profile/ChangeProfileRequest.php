<?php

namespace App\Http\Requests\Api\User\Profile;

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
            'phone'              => ['nullable', 'string', 'max:50'],
            'detail.first_name'  => ['required', 'string', 'max:50',],
            'detail.last_name'   => ['required', 'string', 'max:50',],
            'detail.father_name' => ['nullable', 'string', 'max:50',],
            'detail.gender'      => ['required', 'string', Rule::in(UserGenderDictionary::getCollection())],
            'detail.birthday_at' => ['date'],
        ];
    }
}
