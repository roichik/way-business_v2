<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * Class Permission
 * @property integer $id
 * @property string $name
 * @property string $group
 * @property string $guard_name
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Permission extends SpatiePermission
{
    use CrudTrait;

    /**
     * @return string|null
     */
    public function getNameLabelAttribute()
    {
        return $this->name ? ucfirst(str_replace('-', ' ', $this->name)) : null;
    }


    /**
     * @return string|null
     */
    public function getGroupLabelAttribute()
    {
        return $this->group ? ucfirst(str_replace('-', ' ', $this->group)) : null;
    }

    /**
     * @return string
     */
    public function getConcatGroupAndNameLabelsAttribute()
    {
        return $this->groupLabel . ' - ' . $this->nameLabel;
    }
}
