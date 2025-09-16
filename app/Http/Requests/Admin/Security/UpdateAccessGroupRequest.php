<?php

namespace App\Http\Requests\Admin\Security;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateAccessGroupRequest
 */
class UpdateAccessGroupRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'title'       => 'Название',
            'description' => 'Описание',
        ];
    }
}
