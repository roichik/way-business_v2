<?php

namespace App\Interfaces;

/**
 * Class AbstractDictionary
 */
abstract class AbstractDictionary
{
    /**
     * Список всех констант
     *
     * @var array
     */
    protected static $collection = [];

    /**
     * Список названий пунктов справочника
     * Предполагается, что свойство будет содержать следующую структуру
     * [
     *      константа(id типа) => название (title),
     *      ....
     * ]
     *
     * @var array
     */
    protected static $titleCollection = [];

    /**
     * Возвращает список всех констант вместе с названиями
     *
     * @return array
     */
    public static function getCollection()
    {
        return static::$collection;
    }

    /**
     * Возвращает список названий
     *
     * @return array
     */
    public static function getTitleCollection($translated = false)
    {
        return $translated ? static::getTitleCollectionTranslated() : static::$titleCollection;
    }

    /**
     * Возвращает список названий
     *
     * @return array
     */
    protected static function getTitleCollectionTranslated()
    {
        return array_map(function ($value) {
            return __($value);
        }, static::$titleCollection);
    }

    /**
     * Возвращает название по Id
     *
     * @param string|int $id
     * @return mixed|null
     */
    public static function getTitleById($id)
    {
        if (!static::hasId($id)) {
            return null;
        }

        $titleCollection = static::getTitleCollection();

        return $titleCollection[$id];
    }

    /**
     * Проверяет наличие id
     *
     * @param string|int $id
     * @return bool
     */
    public static function hasId($id)
    {
        return in_array($id, static::getCollection());
    }
}
