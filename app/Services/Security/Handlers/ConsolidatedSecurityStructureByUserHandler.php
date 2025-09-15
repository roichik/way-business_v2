<?php

namespace App\Services\Security\Handlers;

use Illuminate\Database\Eloquent\Collection as DatabaseCollection;
use App\Extensions\Collection;
use App\Models\CompanyStructure\Company;
use App\Models\User\User;
use App\Models\User\UserAdminAccessGroup;

/**
 * Собирает у пользователя в консолидированную структуру права, роли и других обьекты доступа
 * Class ConsolidatedSecurityStructureByUserHandler
 */
class ConsolidatedSecurityStructureByUserHandler
{
    /**
     * @var Collection
     */
    private $permissions;

    /**
     * @var Collection
     */
    private $roles;

    /**
     * @var Collection
     */
    private $flags;

    /**
     * @var Collection
     */
    private $companies;

    /**
     * @param User $user
     */
    public function __construct(private User $user)
    {
        $this->permissions = new Collection();
        $this->roles = new Collection();
        $this->flags = new Collection();
        $this->companies = new Collection();

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
     * @return Collection
     */
    public function permissions()
    {
        return $this->permissions;
    }

    /**
     * @return Collection
     */
    public function roles()
    {
        return $this->roles;
    }

    /**
     * @return Collection
     */
    public function flags()
    {
        return $this->flags;
    }

    /**
     * @return Collection
     */
    public function companies()
    {
        return $this->companies;
    }

    /**
     * @param string $consolidatedKey
     * @param string $dataKey
     * @param mixed $data
     * @return void
     */
    private function addUniqueConsolidateData(string $consolidatedKey, string|int $dataKey, mixed $data)
    {
        if ($this->{$consolidatedKey}->has($dataKey)) {
            return;
        }

        $this->{$consolidatedKey}->addByKey($dataKey, $data);
    }

    /**
     * @param DatabaseCollection $roles
     * @return $this
     */
    private function consolidateRole(DatabaseCollection $roles)
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
     * @param DatabaseCollection $permissions
     * @return $this
     */
    private function consolidatePermissions(DatabaseCollection $permissions)
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
            if ($value && !in_array($id, $this->flags->all())) {
                $this->flags->add($id);
            }
        }

        return $this;
    }

    /**
     * @param Company $companies
     * @return $this
     */
    private function consolidateCountries(DatabaseCollection $companies)
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
