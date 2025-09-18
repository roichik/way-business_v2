<?php

namespace App\Dictionaries;

use App\Interfaces\AbstractDictionary;

/**
 * Действия для сущностей
 * Class EntityEventDictionary
 */
class EntityEventDictionary extends AbstractDictionary
{
    const VIEW = 'view';
    const CREATE = 'create';
    const EDIT = 'edit';
    const DELETE = 'delete';

    /**
     * @var string[]
     */
    protected static $collection = [
        self::VIEW,
        self::CREATE,
        self::EDIT,
        self::DELETE,
    ];

    /**
     * @var string[]
     */
    protected static $titleCollection = [
        self::VIEW   => 'Просмотр',
        self::CREATE => 'Создать',
        self::EDIT   => 'Редактировать',
        self::DELETE => 'Удалить',
    ];
}
