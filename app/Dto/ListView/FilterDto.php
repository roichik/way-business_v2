<?php

namespace App\Dto\ListView;

use App\Interfaces\AbstractDto;

/**
 * Class FilterDto
 */
class FilterDto extends AbstractDto
{
    /**
     * @var string
     */
    public $field;

    /**
     * @var string|array|int|null
     */
    public $value;
}
