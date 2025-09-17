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
    public $per_page = 10;

    /**
     * @var SortDto[]
     */
    public $sort = [];

    /**
     * @param array|string|null $sort
     * @return PaginationDto
     */
    public function setSort(array|string|null $sort)
    {
        if (!$sort) {
            return $this;
        }

        foreach ((array)$sort as $k => $v) {
            $fields = in_array($v, ['asc', 'desc']) ? $k : $v;
            $direction = in_array($v, ['asc', 'desc']) ? $v : 'asc';

            $fields = explode('.', $fields);
            $field = array_pop($fields);
            $relates = $fields;

            $this->sort[] = new SortDto([
                'field'     => $field,
                'direction' => $direction,
                'relates'   => $relates,
            ]);
        }

        return $this;
    }
}
