<?php

namespace App\Models\CompanyStructure;

use App\Models\BaseModel;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

/**
 * Class Position
 *
 * @property int $id
 * @property string $title
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Division[] $divisions
 */
class Position extends BaseModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'positions';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function divisions()
    {
        return $this->belongsToMany(Division::class, 'division_rel_position', 'position_id', 'division_id');
    }
}
