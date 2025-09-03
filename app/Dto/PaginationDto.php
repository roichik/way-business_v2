<?php

namespace App\Dto;

use App\Interfaces\AbstractDto;

/**
 * Dto for pagination list
 * Class PaginationDto
 */
class PaginationDto extends AbstractDto
{
    /**
     * @var int
     */
    public int $per_page = 10;

    /**
     * @var string
     */
    public string $sort = 'desc';
}
