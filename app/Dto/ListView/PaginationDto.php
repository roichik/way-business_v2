<?php

namespace App\Dto\ListView;

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
     * @var FilterDto
     */
    public $filter;

    /**
     * @param SortDto|array|string|null $sort
     * @return PaginationDto
     */
    public function setSort(SortDto|array|string|null $sort)
    {
        if (!$sort) {
            return $this;
        }

        if ($sort instanceof SortDto) {
            $this->sort = $sort;

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

    /**
     * @param FilterDto|array|null $filter
     * @return PaginationDto
     */
    public function setFilter(FilterDto|array|null $filter)
    {
        if (!$filter) {
            return $this;
        }

        if ($filter instanceof FilterDto) {
            $this->filter = $filter;

            return $this;
        }

        foreach ((array)$filter as $field => $value) {
            $this->filter[] = new FilterDto([
                'field' => $field,
                'value' => $value,
            ]);
        }

        return $this;
    }
}
