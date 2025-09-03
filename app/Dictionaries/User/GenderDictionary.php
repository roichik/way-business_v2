<?php

namespace App\Dictionaries\User;

use App\Interfaces\AbstractDictionary;

/**
 * Class GenderDictionary
 */
class GenderDictionary extends AbstractDictionary
{
    const MAN = 'm';
    const WOMAN = 'w';

    /**
     * @var string[]
     */
    protected static $collection = [
        self::MAN,
        self::WOMAN,
    ];

    /**
     * @var string[]
     */
    protected static $titleCollection = [
        self::MAN   => 'Man',
        self::WOMAN => 'Woman',
    ];

}
