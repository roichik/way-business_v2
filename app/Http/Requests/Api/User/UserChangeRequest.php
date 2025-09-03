<?php

namespace App\Http\Requests\Api\User;

use App\Repository\Order\Entity\PaginationEntity;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserChangeRequest
 */
class UserChangeRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'phone'    => ['string', 'max:50'],
            'detail.firstName'  => ['required', 'string', 'max:50',],
            'detail.lastName'   => ['required', 'string', 'max:50',],
            'detail.fatherName' => ['string', 'max:50',],
            'detail.gender'     => ['required', 'string', 'max:10',],
            'detail.birthdayAt' => ['date'],
        ];
    }
}
