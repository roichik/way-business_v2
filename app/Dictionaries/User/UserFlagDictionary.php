<?php

namespace App\Dictionaries\User;

use App\Interfaces\AbstractDictionary;

/**
 * Флаги для сущности пользователя
 * Class UserFlagDictionary
 */
class UserFlagDictionary extends AbstractDictionary
{
    const PROHIBIT_DELETION = 'prohibit_deletion';

    /**
     * @var string[]
     */
    protected static $collection = [
        self::PROHIBIT_DELETION,
    ];

    /**
     * @var string[]
     */
    protected static $titleCollection = [
        self::PROHIBIT_DELETION => 'Запретить удаление',
    ];

}
