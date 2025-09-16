<?php

namespace App\Http\Requests\Admin\User;

use App\Dictionaries\User\UserGenderDictionary;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UserCreateRequest
 */
class UserCreateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'nickname'           => ['required', 'string', 'max:100'],
            'password'           => ['required', 'min:6', 'max:40', 'string'],
            'email'              => ['required', 'unique:users', 'email', 'max:50'],
            'email_verified_at'  => ['nullable', 'date'],
            'phone'              => ['nullable', 'string', 'max:50'],
            'phone_verified_at'  => ['nullable', 'date'],
            'is_enabled'         => ['boolean'],
            'detail.first_name'  => ['required', 'string', 'max:50',],
            'detail.last_name'   => ['required', 'string', 'max:50',],
            'detail.father_name' => ['nullable', 'string', 'max:50',],
            'detail.gender'      => ['required', 'string', Rule::in(UserGenderDictionary::getCollection())],
            'detail.birthday_at' => ['date'],
            'detail.type_id'     => ['required', 'exists:user_types,id'],
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
            'nickname'           => 'Пользователь',
            'email'              => 'Email',
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
            'detail.type_id'     => 'Тип пользователя',
            'detail.company_id'  => 'Компания',
            'detail.division_id' => 'Подразделение/отдел',
            'detail.position_id' => 'Должность',
        ];
    }

}
