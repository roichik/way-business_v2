<?php

namespace App\Services\Security\Operations;

use App\Dictionaries\Security\PermissionDictionary;
use App\Models\Permission;

/**
 * Class PermissionOperation
 *
 * @property
 */
class PermissionOperation extends AbstractOperation
{
    /**
     * @param string $name
     * @param string|null $group
     * @param string|null $description
     * @return bool
     */
    public function assignPermission(string $name, ?string $group, ?string $description = null)
    {
        $permission = Permission::findOrCreate($name);
        $permission->description = $description;
        $permission->group = $group;

        return $permission->save();
    }

    /**
     * @return $this
     */
    public function assignPermissionByDictionary()
    {
        foreach (PermissionDictionary::getCollectionGroup() as $group => $permissions) {
            foreach ($permissions as $permission) {
                $this->assignPermission($permission, $group, PermissionDictionary::getDescriptionById($permission));
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function syncPermissionByDictionary()
    {
        $this->assignPermissionByDictionary();

        foreach (Permission::all() as $permission) {
            if (!PermissionDictionary::hasId($permission->name)) {
                $permission->delete();
            }
        }

        return $this;
    }
}
