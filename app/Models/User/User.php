<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\CompanyStructure\Company;
use App\Models\Security\AccessGroup;
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
 * @property UserAccess $userAccess
 * @property AccessGroup[] $accessGroups
 * @property Role[] $accessRoles
 * @property Permission[] $accessPermissions
 * @property Company[] $accessCompanies
 * @property Role[] $roles
 * @property Permission[] $permissions
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
    public function userDetail()
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userAccess()
    {
        return $this->hasOne(UserAccess::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accessGroups()
    {
        return $this->belongsToMany(AccessGroup::class, 'user_access_groups', 'user_id', 'access_group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accessRoles()
    {
        return $this->belongsToMany(Role::class, 'user_access_roles', 'user_id', 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accessPermissions()
    {
        return $this->belongsToMany(Permission::class, 'user_access_permissions', 'user_id', 'permission_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accessCompanies()
    {
        return $this->belongsToMany(Company::class, 'user_access_companies', 'user_id', 'company_id');
    }

}
