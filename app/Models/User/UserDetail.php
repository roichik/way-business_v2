<?php

namespace App\Models\User;

use App\Models\BaseModel;
use App\Models\CompanyStructure\Company;
use App\Models\CompanyStructure\Division;
use App\Models\CompanyStructure\Position;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

/**
 * Class UserDetail
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $type_id
 * @property int|null $company_id
 * @property int|null $division_id
 * @property int|null $position_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $father_name
 * @property string $gender
 * @property Carbon|null $birthday_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property UserType $type
 * @property Company $company
 * @property Division $division
 * @property Position $position
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
        'type_id',
        'company_id',
        'division_id',
        'position_id',

    ];

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'birthday_at' => 'date',
            'created_at'  => 'datetime',
            'updated_at'  => 'datetime',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(UserType::class, 'type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
}
