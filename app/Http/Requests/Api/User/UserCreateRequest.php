<?php

namespace App\Http\Requests\Api\User;

use App\Repository\Order\Entity\PaginationEntity;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserCreateRequest
 */
class UserCreateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'nickname'              => ['required', 'string', 'max:100'],
            'email'                 => ['required', 'unique:users', 'email', 'max:50'],
            'phone'                 => ['string', 'max:50'],
            'password'              => ['required', 'confirmed', 'min:6', 'max:40', 'string'],
            'password_confirmation' => ['required_with:password', 'string'],
            'detail.firstName'      => ['required', 'string', 'max:50',],
            'detail.lastName'       => ['required', 'string', 'max:50',],
            'detail.fatherName'     => ['string', 'max:50',],
            'detail.gender'         => ['required', 'string', 'max:10',],
            'detail.birthdayAt'     => ['date'],
        ];
    }
}
