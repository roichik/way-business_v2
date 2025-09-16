<?php

namespace App\Models\Traits;

/**
 * Обработка значений поля "flag" типа array, что выступают в качестве доп  параметров для сущности
 * Trait FlagJsonTrait
 *
 * @property array $flag
 */
trait FlagJsonTrait
{
    /**
     * Название класса справочника флагов
     *
     * @return string|null
     */
    public function flagDictionaryClass(): ?string
    {
        return null;
    }

    /**
     * Возвращает список флаг=>подпись. Флаг - по значению
     *
     * @return array
     */
    public function flagTitleAsArray()
    {
        if (!$this->flags) {
            return [];
        }

        $flags = [];
        foreach ($this->flags as $id => $visible) {
            if (!$visible) {
                continue;
            }

            $class = $this->flagDictionaryClass();
            $flags[$id] = $class ? $class::getTitleById($id) : $id;
        }

        return $flags;
    }

    /**
     * Возвращает фраг (по значению)
     *
     * @return array
     */
    public function flagById($id, $default = null)
    {
        if (!$this->flags) {
            return [];
        }

        return $this->flags[$id] ?? $default;
    }

    /**
     * Проверка существования флага (по значению)
     *
     * @param $flag
     * @return bool
     */
    public function hasFlag($flag)
    {
        if (!$this->flags) {
            return false;
        }

        return in_array($flag, $this->flags);
    }

    /**
     * Проверка существования флага (по ключу и значению == true)
     *
     * @param $flag
     * @return bool
     */
    public function hasFlagAsKey($flag)
    {
        if (!$this->flags) {
            return false;
        }

        return array_key_exists($flag, $this->flags) && $this->flags[$flag];
    }
}
