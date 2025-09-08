<?php

namespace App\Models\User;

use App\Dictionaries\Security\AccessGroupFlagDictionary;
use App\Models\BaseModel;
use App\Models\CompanyStructure\Company;
use App\Models\Security\AccessGroup;
use App\Models\Security\Permission;
use App\Models\Security\Role;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

/**
 * Class UserAccess
 *
 * @property int $id
 * @property int $user_id
 * @property array|null $flags
 * @property User $user
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property AccessGroup[] $accessGroups
 * @property Role[] $roles
 * @property Permission[] $permissions
 * @property Company[] $companies
 * @see AccessGroupFlagDictionary
 */
class UserAccess extends BaseModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'user_access';

    /**
     * @var string[]
     */
    protected $fillable = [
        'flags',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'flags' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accessGroup()
    {
        return $this->belongsToMany(AccessGroup::class, 'user_access_groups', 'user_access_id', 'access_group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_access_group_roles', 'user_access_id', 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_access_group_permissions', 'user_access_id', 'permission_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'user_access_group_companies', 'user_access_id', 'company_id');
    }

    /**
     * @return array
     */
    public function flagAsArray()
    {
        if (!$this->flags) {
            return [];
        }

        $flags = [];
        foreach ($this->flags as $id => $visible) {
            if (!$visible) {
                continue;
            }
            $flags[$id] = AccessGroupFlagDictionary::getTitleById($id);
        }

        return $flags;
    }

    /**
     * @param $flag
     * @return bool
     */
    public function hasFlag($flag)
    {
        if (!$this->flags) {
            return false;
        }

        return in_array($flag, $this->flags);
    }
}

