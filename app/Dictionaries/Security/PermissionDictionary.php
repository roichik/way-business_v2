<?php

namespace App\Dictionaries\Security;

use App\Interfaces\AbstractDictionary;

/**
 * Class PermissionDictionary
 */
class PermissionDictionary extends AbstractDictionary
{
    const ADMIN = 'admin';
    const SECURITY_ADMIN = 'security-admin';
    const CREATE_USER = 'create-user';
    const EDIT_USER = 'edit-user';
    const DELETE_USER = 'delete-user';
    const LIST_OF_USERS = 'list-of-users';

    /**
     * @var string[]
     */
    protected static $collection = [
        self::ADMIN,
        self::SECURITY_ADMIN,
        self::CREATE_USER,
        self::EDIT_USER,
        self::DELETE_USER,
        self::LIST_OF_USERS,
    ];

    /**
     * @var string[]
     */
    protected static $collectionGroup = [
        PermissionGroupDictionary::ADMINISTRATIVE => [
            self::ADMIN,
            self::SECURITY_ADMIN,
        ],
        PermissionGroupDictionary::USERS  => [
            self::CREATE_USER,
            self::EDIT_USER,
            self::DELETE_USER,
            self::LIST_OF_USERS,
        ],
    ];

    /**
     * @return string[]
     */
    public static function getCollectionGroup(): array
    {
        return self::$collectionGroup;
    }

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

    /**
     * @param $translated
     * @return array
     */
    public static function getDescriptionCollection($translated = false)
    {
        return static::getTitleCollection($translated);
    }

    /**
     * @param $id
     * @return mixed|null
     */
    public static function getDescriptionById($id)
    {
        if (!static::hasId($id)) {
            return null;
        }

        $descriptionCollection = static::getDescriptionCollection();

        return $descriptionCollection[$id];
    }
}
