<?php

namespace App\Models\Security;

use App\Models\User\UserAccess;
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
 * @property UserAccess $userAccess
 */
class Role extends SpatieRole
{
    use CrudTrait;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userAccess()
    {
        return $this->belongsToMany(UserAccess::class, 'user_access_group_roles', 'role_id', 'user_access_id');
    }
}
