<?php

namespace App\Services\BackPackAdmin\Handlers\Security;

use App\Models\CompanyStructure\Company;
use App\Models\Security\AccessGroup;
use App\Models\Security\Permission;
use App\Models\Security\Role;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class SyncAllPermissionsHandler
 */
class SyncAllPermissionsHandler
{
    /**
     * @var array
     */
    private $consolidatedData = [
        'roles'       => [],
        'permissions' => [],
        'flags'       => [],
        'companies'   => [],
    ];

    /**
     * @param User $user
     */
    public function __construct(private User $user)
    {
    }

    /**
     * @return $this
     */
    public function handle()
    {
        $this
            ->consolidateAll();

        return $this;
    }

    /**
     * @param string $consolidatedKey
     * @param string $dataKey
     * @param mixed $data
     * @return void
     */
    private function addUniqueConsolidateData(string $consolidatedKey, string $dataKey, mixed $data)
    {
        if (array_key_exists($dataKey, $this->consolidatedData[$consolidatedKey])) {
            return;
        }

        $this->consolidatedData[$consolidatedKey][$dataKey] = $data;
    }

    /**
     * @return $this
     */
    private function consolidateAll()
    {
        /** @var AccessGroup $accessGroup */
        foreach ($this->user->accessGroups as $accessGroup) {
            $this
                ->consolidateRole($accessGroup->roles)
                ->consolidatePermissions($accessGroup->permissions)
                ->consolidateFlags($accessGroup->flags)
                ->consolidateCountries($accessGroup->companies);
        }

        $this
            ->consolidateRole($this->user->accessRoles)
            ->consolidatePermissions($this->user->accessPermissions)
            ->consolidateFlags($this->user->userAccess->flags)
            ->consolidateCountries($this->user->accessCompanies);

        return $this;
    }


    /**
     * @return $this
     */
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
            if ($value && !in_array($id, $this->consolidatedData['flags'])) {
                $this->consolidatedData['flags'][] = $id;
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
