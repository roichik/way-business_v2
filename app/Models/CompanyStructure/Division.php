<?php

namespace App\Models\CompanyStructure;

use App\Models\BaseModel;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

/**
 * Class Division
 *
 * @property int $id
 * @property string $title
 * @property int $parent_id
 * @property int $lft Сортировка
 * @property int $rgt
 * @property int $depth
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Division $parent
 * @property Company[] $companies
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
        'title',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_rel_division', 'division_id', 'company_id');
    }
}
