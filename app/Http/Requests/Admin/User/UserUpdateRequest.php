<?php

namespace App\Http\Requests\Admin\User;

use App\Dictionaries\User\GenderDictionary;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UserUpdateRequest
 */
class UserUpdateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'password'           => ['nullable', 'min:6', 'max:40', 'string'],
            'email_verified_at'  => ['nullable', 'date'],
            'phone'              => ['nullable', 'string', 'max:50'],
            'phone_verified_at'  => ['nullable', 'date'],
            'is_enabled'         => ['boolean'],
            'detail.first_name'  => ['required', 'string', 'max:50',],
            'detail.last_name'   => ['required', 'string', 'max:50',],
            'detail.father_name' => ['nullable', 'string', 'max:50',],
            'detail.gender'      => ['required', 'string', Rule::in(GenderDictionary::getCollection())],
            'detail.birthday_at' => ['date'],
            'detail.company_id'  => ['nullable', 'exists:companies,id'],
            'detail.division_id' => ['nullable', 'exists:divisions,id'],
            'detail.position_id' => ['nullable', 'exists:positions,id'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'password'           => 'Пароль',
            'email_verified_at'  => 'Подтверджение пароля',
            'phone'              => 'Телефон',
            'phone_verified_at'  => 'Подтверджение телефона',
            'is_enabled'         => 'Активный',
            'detail.first_name'  => 'Имя',
            'detail.last_name'   => 'Фамилия',
            'detail.father_name' => 'Отчество',
            'detail.gender'      => 'Пол',
            'detail.birthday_at' => 'Дата роджения',
            'detail.company_id'  => 'Компания',
            'detail.division_id' => 'Подразделение/отдел',
            'detail.position_id' => 'Должность',
        ];
    }
}
