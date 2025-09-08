<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

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
            'userDetail.first_name'  => ['required', 'string', 'max:50',],
            'userDetail.last_name'   => ['required', 'string', 'max:50',],
            'userDetail.father_name' => ['nullable', 'string', 'max:50',],
            'userDetail.gender'      => ['required', 'string', 'max:10',],
            'userDetail.birthday_at' => ['date'],
            'userDetail.company_id'  => ['nullable'],
            'userDetail.division_id' => ['nullable'],
            'userDetail.position_id' => ['nullable'],
            'userAccess.flags'       => ['nullable', 'array'],
        ];
    }

}
