<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\CompanyStructure\Company;
use App\Models\Security\Permission;
use App\Models\Security\Role;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @property int $id
 * @property string $nickname
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $phone
 * @property Carbon|null $phone_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property bool $is_enabled
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property UserDetail $userDetail
 * Roles and permission
 * @property Role[] $roles
 * @property Permission[] $permissions
 * Admin access..
 * @property UserAdminAccess $adminAccess
 * @property UserAdminAccessGroup[] $adminAccessGroups
 * @property Role[] $adminAccessRoles
 * @property Permission[] $adminAccessPermissions
 * @property Company[] $adminAccessCompanies
 * Security
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, CrudTrait;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'nickname',
        'email',
        'email_verified_at',
        'phone',
        'phone_verified_at',
        'password',
        'is_enabled',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'is_enabled'        => 'boolean',
            'password'          => 'hashed',
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'created_at'        => 'datetime',
            'updated_at'        => 'datetime',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function detail()
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function adminAccess()
    {
        return $this->hasOne(UserAdminAccess::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function adminAccessGroups()
    {
        return $this->belongsToMany(UserAdminAccessGroup::class, 'user_admin_access_groups', 'user_id', 'access_group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function adminAccessRoles()
    {
        return $this->belongsToMany(Role::class, 'user_admin_access_roles', 'user_id', 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function adminAccessPermissions()
    {
        return $this->belongsToMany(Permission::class, 'user_admin_access_permissions', 'user_id', 'permission_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function adminAccessCompanies()
    {
        return $this->belongsToMany(Company::class, 'user_admin_access_companies', 'user_id', 'company_id');
    }
}
