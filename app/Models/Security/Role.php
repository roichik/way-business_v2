<?php

namespace App\Models\Security;

use App\Models\User\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Class Role
 * @property integer $id
 * @property string $name
 * @property string $guard_name
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 */
class Role extends SpatieRole
{
    use CrudTrait;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userAccess()
    {
        return $this->belongsToMany(User::class, 'user_access_group_roles', 'role_id', 'user_id');
    }
}
