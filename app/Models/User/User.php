<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Dictionaries\EntityEventDictionary;
use App\Dictionaries\User\UserFlagDictionary;
use App\Models\CompanyStructure\Company;
use App\Models\Security\AccessAddons;
use App\Models\Security\Permission;
use App\Models\Security\Role;
use App\Models\Traits\ExternalEventsTrait;
use App\Models\Traits\FlagJsonTrait;
use App\Models\Upload;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
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
 * @property array $flags
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property UserDetail $detail
 * Security:
 * @property Role[] $roles
 * @property Permission[] $permissions
 * @property AccessAddons $accessAddon
 * @property Company[] $accessCompanies
 * Admin panel access:
 * @property UserAdminAccess $adminAccess
 * @property UserAdminAccessGroup[] $adminAccessGroups
 * @property Role[] $adminAccessRoles
 * @property Permission[] $adminAccessPermissions
 * @property Company[] $adminAccessCompanies
 */
class User extends Authenticatable implements HasMedia
{
    use HasFactory,
        Notifiable,
        HasApiTokens,
        HasRoles,
        CrudTrait,
        FlagJsonTrait,
        ExternalEventsTrait,
        InteractsWithMedia;

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
            'flags'             => 'array',
            'is_enabled'        => 'boolean',
            'password'          => 'hashed',
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'created_at'        => 'datetime',
            'updated_at'        => 'datetime',
        ];
    }

    /**
     * @var array
     */
    protected function getExternalEvents()
    {
        return [
            EntityEventDictionary::VIEW   => true,
            EntityEventDictionary::CREATE => false,
            EntityEventDictionary::EDIT   => false,
            EntityEventDictionary::DELETE => false,
        ];
    }

    /**
     * @return array|null
     */
    public function flagDictionaryClass(): string
    {
        return UserFlagDictionary::class;
    }

    /**
     * @param Upload|null $media
     * @return void
     */
    public function registerMediaConversions($media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
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
    public function accessAddon()
    {
        return $this->hasOne(AccessAddons::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function accessCompanies()
    {
        return $this->belongsToMany(Company::class, 'access_companies', 'user_id', 'company_id');
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
