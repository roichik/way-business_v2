<?php

namespace App\Extensions;

use Illuminate\Support\Collection as BaseCollection;

/**
 * Class Collection
 */
class Collection extends BaseCollection
{
    /**
     * @param string|int $key
     * @param mixed $value
     * @return $this
     */
    public function addByKey(string|int $key, $value)
    {
        $this->items[$key] = $value;

        return $this;
    }
}
