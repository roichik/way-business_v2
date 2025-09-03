<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

/**
 * Class CompanyStructure
 *
 * @property int $id
 * @property int $type_id
 * @property int $parent_id
 * @property string $title
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property CompanyStructure[]|null $parent
 * @property CompanyStructure[]|[] $children
 */
class CompanyStructure extends BaseModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'company_structure';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parent()
    {
        return $this->belongsToMany(self::class, 'company_structure_rel', 'structure_rel_id', 'structure_id');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function children()
    {
        return $this->belongsToMany(self::class, 'company_structure_rel', 'structure_id', 'structure_rel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function structureType()
    {
        return $this->belongsTo(CompanyStructureType::class, 'type_id');
    }
}
