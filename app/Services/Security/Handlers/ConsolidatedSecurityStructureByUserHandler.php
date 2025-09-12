<?php

namespace App\Services\Security\Handlers;

use App\Models\CompanyStructure\Company;
use App\Models\User\User;
use App\Models\User\UserAdminAccessGroup;
use Illuminate\Database\Eloquent\Collection;

/**
 * Собирает у пользователя в консолидированную структуру права, роли и других обьекты доступа
 * Class ConsolidatedSecurityStructureByUserHandler
 */
class ConsolidatedSecurityStructureByUserHandler
{
    private $permissions = [];

    private $roles = [];

    private $flags = [];

    private $companies = [];

    /**
     * @param User $user
     */
    public function __construct(private User $user)
    {
        $this->handler();
    }

    /**
     * @return $this
     */
    private function handler()
    {
        /** @var UserAdminAccessGroup $adminAccessGroup */
        foreach ($this->user->adminAccessGroups as $adminAccessGroup) {
            $this
                ->consolidateRole($adminAccessGroup->roles)
                ->consolidatePermissions($adminAccessGroup->permissions)
                ->consolidateFlags($adminAccessGroup->flags)
                ->consolidateCountries($adminAccessGroup->companies);
        }

        $this
            ->consolidateRole($this->user->adminAccessRoles)
            ->consolidatePermissions($this->user->adminAccessPermissions)
            ->consolidateFlags($this->user->adminAccess->flags)
            ->consolidateCountries($this->user->adminAccessCompanies);

        return $this;
    }

    /**
     * @return array
     */
    public function permissions(): array
    {
        return $this->permissions;
    }

    /**
     * @return array
     */
    public function roles(): array
    {
        return $this->roles;
    }

    /**
     * @return array
     */
    public function flags(): array
    {
        return $this->flags;
    }

    /**
     * @return array
     */
    public function countries(): array
    {
        return $this->countries;
    }

    /**
     * @param string $consolidatedKey
     * @param string $dataKey
     * @param mixed $data
     * @return void
     */
    private function addUniqueConsolidateData(string $consolidatedKey, string $dataKey, mixed $data)
    {
        if (array_key_exists($dataKey, $this->{$consolidatedKey})) {
            return;
        }

        $this->{$consolidatedKey}[$dataKey] = $data;
    }

    /**
     * @param Collection $roles
     * @return $this
     */
    private function consolidateRole(Collection $roles)
    {
        foreach ($roles as $role) {
            $this->addUniqueConsolidateData(
                'roles',
                $role->name,
                $role
            );
        }

        return $this;
    }

    /**
     * @param Collection $permissions
     * @return $this
     */
    private function consolidatePermissions(Collection $permissions)
    {
        foreach ($permissions as $permission) {
            $this->addUniqueConsolidateData(
                'permissions',
                $permission->name,
                $permission
            );
        }

        return $this;
    }

    /**
     * @param string[] $flags
     * @return $this
     */
    private function consolidateFlags(array $flags)
    {
        foreach ($flags as $id => $value) {
            if ($value && !in_array($id, $this->flags)) {
                $this->flags[] = $id;
            }
        }

        return $this;
    }

    /**
     * @param Company $companies
     * @return $this
     */
    private function consolidateCountries(Collection $companies)
    {
        foreach ($companies as $company) {
            $this->addUniqueConsolidateData(
                'companies',
                $company->id,
                $company
            );
        }

        return $this;
    }
}
