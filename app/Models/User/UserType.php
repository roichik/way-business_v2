<?php

namespace App\Models\User;

use App\Models\BaseModel;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * Class UserType
 *
 * @property int $id
 * @property int $title
 */
class UserType extends BaseModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'user_types';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userDetail()
    {
        return $this->hasOne(UserDetail::class, 'type_id');
    }
}

