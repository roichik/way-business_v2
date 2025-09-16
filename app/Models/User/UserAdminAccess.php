<?php

namespace App\Models\User;

use App\Dictionaries\Security\AccessGroupFlagDictionary;
use App\Models\BaseModel;
use App\Models\Traits\FlagJsonTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

/**
 * Class UserAdminAccess
 *
 * @property int $id
 * @property int $user_id
 * @property array|null $flags
 * @property User $user
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @see AccessGroupFlagDictionary
 */
class UserAdminAccess extends BaseModel
{
    use CrudTrait, FlagJsonTrait;

    /**
     * @var string
     */
    protected $table = 'user_admin_access';

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
     * @return array|null
     */
    public function flagDictionaryClass(): string
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

