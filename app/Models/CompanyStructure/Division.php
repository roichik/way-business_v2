<?php

namespace App\Models\CompanyStructure;

use App\Models\BaseModel;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

/**
 * Class Division
 *
 * @property int $id
 * @property int $company_id
 * @property string $title
 * @property int $parent_id
 * @property int $lft Сортировка
 * @property int $rgt
 * @property int $depth
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Division $parent
 * @property Company $company
 * @property Position[] $positions
 */
class Division extends BaseModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'divisions';

    /**
     * @var string[]
     */
    protected $fillable = [
        'parent_id',
        'company_id',
        'title',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Division::class, 'parent_id');
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
    public function positions()
    {
        return $this->hasMany(Position::class, 'division_id');
    }
}
