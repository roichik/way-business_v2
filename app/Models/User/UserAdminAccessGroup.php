<?php

namespace App\Models\User;

use App\Dictionaries\Security\AccessGroupFlagDictionary;
use App\Models\BaseModel;
use App\Models\CompanyStructure\Company;
use App\Models\Security\Permission;
use App\Models\Security\Role;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

/**
 * Групы доступа для админ части
 *
 * Class UserAdminAccessGroup
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property array|null $flags
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User[] $users
 * @property Role[] $roles
 * @property Permission[] $permissions
 * @property Company[] $companies
 * @see AccessGroupFlagDictionary
 */
class UserAdminAccessGroup extends BaseModel
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
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_admin_access_groups', 'access_group_id', 'user_id');
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
}
