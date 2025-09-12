<?php

namespace App\Models\CompanyStructure;

use App\Models\BaseModel;
use App\Models\User\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

/**
 * Class Company
 *
 * @property int $id
 * @property string $title
 * @property int $parent_id
 * @property int $lft Сортировка
 * @property int $rgt
 * @property int $depth
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Company $parent
 * @property Division[] $divisions
 * @property User[] $users
 */
class Company extends BaseModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'companies';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'parent_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Company::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function divisions()
    {
        return $this->hasMany(Division::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_admin_access_companies', 'company_id', 'user_id');
    }
}
