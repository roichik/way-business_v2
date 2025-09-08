<?php

namespace App\Dictionaries\Security;

use App\Interfaces\AbstractDictionary;

/**
 * Class AccessGroupFlagDictionary
 */
class AccessGroupFlagDictionary extends AbstractDictionary
{
    const ACCESS_ONLY_AT_THE_USER_COMPANY_LEVEL = 'access_only_at_the_user_company_level';

    /**
     * @var string[]
     */
    protected static $collection = [
        self::ACCESS_ONLY_AT_THE_USER_COMPANY_LEVEL,
    ];

    /**
     * @var string[]
     */
    protected static $titleCollection = [
        self::ACCESS_ONLY_AT_THE_USER_COMPANY_LEVEL => 'Доступ только на уровне компании пользователя',
    ];
}
