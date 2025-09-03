<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * Class CompanyStructureTypeRel
 *
 * @property int $type_id
 * @property int $rel_type_id
 * @property CompanyStructureType $companyStructureType
 */
class CompanyStructureTypeRel extends BaseModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'company_structure_types_rel';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companyStructureType()
    {
        return $this->belongsTo(CompanyStructureType::class, 'rel_type_id');
    }
}
