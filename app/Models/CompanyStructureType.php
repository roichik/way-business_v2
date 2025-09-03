<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * Class CompanyStructureType
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property array $flags
 * @property int $parent_id //For sorting
 * @property int $lft //For sorting
 * @property int $rgt //For sorting
 * @property int $depth //For sorting
 * @property CompanyStructure[] $companyStructures
 * @property CompanyStructure[] $companyStructureTypeRel
 */
class CompanyStructureType extends BaseModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'company_structure_types';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'slug',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companyStructureTypeRel()
    {
        return $this->belongsToMany(CompanyStructureType::class, 'company_structure_types_rel', 'rel_type_id', 'type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companyStructures()
    {
        return $this->hasMany(CompanyStructure::class, 'type_id');
    }

    /**
     * @param string $flag
     * @return bool
     */
    public function hasFlag(string $flag)
    {
        return $this->flags ? in_array($flag, $this->flags) : false;
    }

}
