<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

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
            'nickname'          => ['required', 'string', 'max:100'],
            'password'          => ['nullable', 'min:6', 'max:40', 'string'],
            'email'             => ['required', 'unique:users', 'email', 'max:50'],
            'email_verified_at' => ['nullable', 'datetime'],
            'phone'             => ['string', 'max:50'],
            'phone_verified_at' => ['nullable', 'datetime'],
            'detail.firstName'  => ['required', 'string', 'max:50',],
            'detail.lastName'   => ['required', 'string', 'max:50',],
            'detail.fatherName' => ['string', 'max:50',],
            'detail.gender'     => ['required', 'string', 'max:10',],
            'detail.birthdayAt' => ['date'],
        ];
    }

}
