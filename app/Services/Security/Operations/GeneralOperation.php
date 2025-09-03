<?php

namespace App\Services\Security\Operations;

use Spatie\Permission\PermissionRegistrar;

/**
 * Работа с разрешениями, ролями, другое: создания матипга, назначание, удаление, другое
 * Class GeneralOperation
 */
class GeneralOperation extends AbstractOperation
{

    /**
     * Сброс кэша
     *
     * @return $this
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function forgetCachedPermissions()
    {
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        return $this;
    }

}
