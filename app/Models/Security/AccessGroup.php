<?php

namespace App\Models\Security;

use App\Dictionaries\Security\AccessGroupFlagDictionary;
use App\Models\BaseModel;
use App\Models\CompanyStructure\Company;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * Class AccessGroup
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property array|null $flags
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
