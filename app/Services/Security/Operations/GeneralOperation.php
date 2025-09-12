<?php

namespace App\Services\Security\Operations;

use App\Services\Security\Handlers\ConsolidatedSecurityStructureByUserHandler;
use Spatie\Permission\PermissionRegistrar;

/**
 * Работа с разрешениями, ролями, другое: создания матипга, назначание, удаление, другое
 * Class GeneralOperation
 */
class GeneralOperation extends AbstractOperation
{

    /**
     * Консолидированная структура прав, ролей и других обьектов доступа у пользователя
     *
     * @param $user
     * @return SecurityStructureByUserHandler
     */
    public function consolidatedSecurityStructureByUser($user)
    {
        return (new ConsolidatedSecurityStructureByUserHandler($user));
    }

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
