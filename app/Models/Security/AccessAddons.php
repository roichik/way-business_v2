<?php

namespace App\Models\Security;

use App\Dictionaries\Security\AccessGroupFlagDictionary;
use App\Models\BaseModel;
use App\Models\Traits\FlagJsonTrait;
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
    use FlagJsonTrait;

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

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return string|null
     */
    public function flagDictionaryClass(): ?string
    {
        return AccessGroupFlagDictionary::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

