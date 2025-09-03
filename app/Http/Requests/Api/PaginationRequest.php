<?php

namespace App\Http\Requests\Api;

use App\Repository\Order\Entity\PaginationEntity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaginationRequest extends FormRequest
{

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'per_page' => ['nullable', 'integer'],
            'page'     => ['nullable', 'integer'],
            'sort'     => [Rule::in(['asc', 'desc'])],
        ];
    }
}
