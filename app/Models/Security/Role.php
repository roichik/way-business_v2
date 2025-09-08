<?php

namespace App\Models\Security;

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
 */
class Role extends SpatieRole
{
    use CrudTrait;

}
