<?php

namespace App\Models\CompanyStructure;

use App\Models\BaseModel;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

/**
 * Class Position
 *
 * @property int $id
 * @property int $division_id
 * @property string $title
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Division $division
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
        'division_id',
        'title',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
}
