<?php

namespace App\Dictionaries\Security;

use App\Interfaces\AbstractDictionary;

/**
 * Class PermissionGroupDictionary
 */
class PermissionGroupDictionary extends AbstractDictionary
{
    const ADMINISTRATIVE = 'administrative';
    const USERS = 'Users';

    /**
     * @var string[]
     */
    protected static $collection = [
        self::ADMINISTRATIVE,
        self::USERS,
    ];

    /**
     * @param $translated
     * @return array
     */
    public static function getTitleCollection($translated = false)
    {
        $collection = [];
        foreach (self::$collection as $item) {
            $collection[$item] = ucfirst(str_replace('-', ' ', $item));
        }

        return $collection;
    }
}
