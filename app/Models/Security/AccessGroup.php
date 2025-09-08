<?php

namespace App\Models\Security;

use App\Dictionaries\Security\AccessGroupFlagDictionary;
use App\Models\BaseModel;
use App\Models\CompanyStructure\Company;
use App\Models\User\UserAccess;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

/**
 * Class AccessGroup
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property array|null $flags
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property UserAccess $userAccess
 * @property Role[] $roles
 * @property Permission[] $permissions
 * @property Company[] $companies
 * @see AccessGroupFlagDictionary
 */
class AccessGroup extends BaseModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'admin_access_groups';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'flags',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'flags' => 'array',
    ];

    protected $fakeColumns = [
        'flags',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userAccess()
    {
        return $this->belongsToMany(UserAccess::class, 'user_access_groups', 'access_group_id', 'user_access_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_access_group_roles', 'access_group_id', 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'admin_access_group_permissions', 'access_group_id', 'permission_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'admin_access_group_companies', 'access_group_id', 'company_id');
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
