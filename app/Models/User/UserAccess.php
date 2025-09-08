<?php

namespace App\Models\User;

use App\Dictionaries\Security\AccessGroupFlagDictionary;
use App\Models\BaseModel;
use App\Models\CompanyStructure\Company;
use App\Models\Security\AccessGroup;
use App\Models\Security\Permission;
use App\Models\Security\Role;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

/**
 * Class UserAccess
 *
 * @property int $id
 * @property int $user_id
 * @property array|null $flags
 * @property User $user
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @see AccessGroupFlagDictionary
 */
class UserAccess extends BaseModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'user_access';

    /**
     * @var string[]
     */
    protected $fillable = [
        'flags',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'flags' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return array
     */
    public function flagAsArray()
    {
        if (!$this->flags) {
            return [];
        }

        $flags = [];
        foreach ($this->flags as $id => $visible) {
            if (!$visible) {
                continue;
            }
            $flags[$id] = AccessGroupFlagDictionary::getTitleById($id);
        }

        return $flags;
    }

    /**
     * @return array
     */
    public function flagById($id, $default = null)
    {
        if (!$this->flags) {
            return [];
        }

        return $this->flags[$id] ?? $default;
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

