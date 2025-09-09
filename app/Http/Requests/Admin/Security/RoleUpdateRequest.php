<?php

namespace App\Http\Requests\Admin\Security;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RoleUpdateRequest
 */
class RoleUpdateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'permissions' => ['required', 'min:1']
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'name'        => 'Название',
            'description' => 'Описание',
            'permissions' => 'Права доступа'
        ];
    }
}
