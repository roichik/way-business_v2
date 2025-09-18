<?php

namespace App\Dto\ListView;

use App\Interfaces\AbstractDto;

/**
 * DTO для фортировки в моделях
 * Class SortDto
 */
class SortDto extends AbstractDto
{
    /**
     * Название поля
     * @var string
     */
    public $field;

    /**
     * Направление сортировки
     * @var string
     */
    public $direction = 'asc';

    /**
     * Название альясом связанны сущностей
     * Связь может быть циклична
     *
     * @var array
     */
    public $relates;

}
