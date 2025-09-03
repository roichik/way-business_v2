<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

/**
 * Class UserDetail
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $father_name
 * @property string $gender
 * @property Carbon|null $birthday_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class UserDetail extends BaseModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'user_detail';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'father_name',
        'gender',
        'birthday_at',
    ];


    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'birthday_at'       => 'date',
            'created_at'        => 'datetime',
            'updated_at'        => 'datetime',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
