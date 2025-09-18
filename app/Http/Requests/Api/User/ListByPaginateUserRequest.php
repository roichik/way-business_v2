<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ListByPaginateUserRequest
 */
class ListByPaginateUserRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'per_page' => ['nullable', 'integer'],
            'page'     => ['nullable', 'integer'],
            'sort'     => ['nullable', 'array'],
            'filter'   => ['nullable', 'array'],
        ];
    }
}
