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
            'password'               => ['nullable', 'min:6', 'max:40', 'string'],
            'email_verified_at'      => ['nullable', 'date'],
            'phone'                  => ['nullable', 'string', 'max:50'],
            'phone_verified_at'      => ['nullable', 'date'],
            'is_enabled'             => ['boolean'],
            'userDetail.first_name'  => ['required', 'string', 'max:50',],
            'userDetail.last_name'   => ['required', 'string', 'max:50',],
            'userDetail.father_name' => ['nullable', 'string', 'max:50',],
            'userDetail.gender'      => ['required', 'string', Rule::in(GenderDictionary::getCollection())],
            'userDetail.birthday_at' => ['date'],
            'userDetail.company_id'  => ['nullable', 'exists:companies,id'],
            'userDetail.division_id' => ['nullable', 'exists:divisions,id'],
            'userDetail.position_id' => ['nullable', 'exists:positions,id'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'password'               => 'Пароль',
            'email_verified_at'      => 'Подтверджение пароля',
            'phone'                  => 'Телефон',
            'phone_verified_at'      => 'Подтверджение телефона',
            'is_enabled'             => 'Активный',
            'userDetail.first_name'  => 'Имя',
            'userDetail.last_name'   => 'Фамилия',
            'userDetail.father_name' => 'Отчество',
            'userDetail.gender'      => 'Пол',
            'userDetail.birthday_at' => 'Дата роджения',
            'userDetail.company_id'  => 'Компания',
            'userDetail.division_id' => 'Подразделение/отдел',
            'userDetail.position_id' => 'Должность',
        ];
    }
}
