<?php

namespace App\Models\Security;

use App\Dictionaries\Security\AccessGroupFlagDictionary;
use App\Models\BaseModel;
use App\Models\User\User;

/**
 * Дополнительные параметры доступа у пользователя
 * Class UserAccessAddons
 *
 * @property int $id
 * @property int $user_id
 * @property array|null $flags
 * @see AccessGroupFlagDictionary
 */
class AccessAddons extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'access_addons';

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

    public $timestamps = false;

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

