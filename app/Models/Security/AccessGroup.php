<?php

namespace App\Models\Security;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_access_group_roles', 'role_id', 'access_group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'admin_access_group_roles', 'permission_id', 'access_group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'admin_access_group_roles', 'company_id', 'access_group_id');
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
