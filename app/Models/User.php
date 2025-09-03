<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
}
