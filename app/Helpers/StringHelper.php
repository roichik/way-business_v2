<?php

namespace App\Helpers;

/**
 * Class StringHelper
 */
class StringHelper
{
    /**
     * Актуальный индекс для метода self::generateUnique()
     *
     * @var int
     */
    static private $lastUnuqie = 1;

    /**
     * Генерирует по md5 и возвращает уникальный ключ
     *
     * @param $encodeToMd5
     * @return string
     */
    public static function generateUnique($encodeToMd5 = true)
    {
        $str = date('YmdHis') . self::$lastUnuqie;

        if ($encodeToMd5) {
            $str = md5($str);
        }

        self::$lastUnuqie++;

        return $str;
    }

    /**
     * Проверяет, является ли строка валидной строкой json-a
     *
     * @param $string
     * @return bool
     */
    public static function isJSON($string): bool
    {
        if (!is_string($string) || $string === null || $string === "") {
            return false;
        }

        // decode the JSON data
        $array = json_decode($string, true);
        if (!is_array($array)) {
            return false;
        }

        // switch and check possible JSON errors
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $error = ''; // JSON is valid // No error has occurred
                break;
            case JSON_ERROR_DEPTH:
                $error = 'The maximum stack depth has been exceeded.';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Invalid or malformed JSON.';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Control character error, possibly incorrectly encoded.';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error, malformed JSON.';
                break;
            // PHP >= 5.3.3
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_RECURSION:
                $error = 'One or more recursive references in the value to be encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_INF_OR_NAN:
                $error = 'One or more NAN or INF values in the value to be encoded.';
                break;
            case JSON_ERROR_UNSUPPORTED_TYPE:
                $error = 'A value of a type that cannot be encoded was given.';
                break;
            default:
                $error = 'Unknown JSON error occured.';
                break;
        }

        return !($error);
    }

    /**
     * Форматирует строку из snake_case в CamelCase
     *
     * @param $value
     * @return string
     */
    public static function formatSnakeToCamelCase($value)
    {
        $result = '';

        foreach (explode('_', $value) as $value) {
            if ($value === '_') {
                continue;
            }

            $result .= ucfirst($value);
        }

        return lcfirst($result);
    }

    /**
     * Форматирует строку из CamelCase в snake_case
     *
     * @param string $camelCase
     * @return string
     */
    public static function formatCamelToSnakeCase(string $camelCase)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $camelCase));
    }

    /**
     * Возвращает название класса без namespace-a
     *
     * @param object|string $class
     * @return string
     */
    public static function classBaseName($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }

    /**
     * Подстановка в строке значений параметров по ключам {s} / {s<номер>}
     *
     * @param string $str
     * @param array|string $params
     * @return string
     */
    public static function strReplace(string $str, array|string $params)
    {
        if (is_string($params)) {
            $params = (array)$params;
        }

        foreach ($params as $key => $value) {
            if (is_int($key)) {
                $key = '{s' . $key . '}';
            } else {
                $key = '{' . $key . '}';
            }

            $str = str_replace($key, $value, $str);
        }

        return $str;
    }
}
