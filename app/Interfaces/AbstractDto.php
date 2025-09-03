<?php

namespace App\Interfaces;

use App\Helpers\StringHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use ArrayAccess;

/**
 * Class AbstractDto
 */
abstract class AbstractDto implements ArrayAccess
{
    /**
     * AbstractDto constructor.
     *
     * @param array|object|Closure $data
     */
    public function __construct($data = [])
    {
        $this->mergeData($data);
    }

    /**
     * Обновляет/устанавливает свойства новыми значениями
     *
     * @param array|object|Closure $data
     * @return $this
     */
    public function mergeData($data): self
    {
        if ($data instanceof \Closure) {
            $data = $data();
        }

        if (!is_array($data) && !is_object($data)) {
            return $this;
        }

        if (is_object($data)) {
            $data = $this->getAttributesByObject($data);
        }

        //Идем по входящих данных
        foreach ($data as $property => $value) {
            if ($value instanceof \Closure) {
                $value = $value($this);
            }
            $this->setPropertyValue($property, $value);
        }

        return $this;
    }

    /**
     * Установка значения одного свойства класса (если оно присутствует)
     *
     * @param string $property
     * @param mixed $value
     * @return $this
     */
    private function setPropertyValue(string $property, mixed $value)
    {
        $methodName = 'set' . ucfirst(StringHelper::formatSnakeToCamelCase($property));
        $camelProperty = StringHelper::formatSnakeToCamelCase($property);
        $value = $this->formatValue($value);

        //1. Ищем метод по маске "set" + "НазваниеПараметра"
        if (method_exists($this, $methodName)) {
            $this->{$methodName}($value);
            //2. Ищем свойство в формате camelCase
        } elseif (property_exists($this, $camelProperty)) {
            $this->{$camelProperty} = $value;
            //3. Ищем свойство в с тем же названием
        } elseif (property_exists($this, $property)) {
            $this->{$property} = $value;
        }

        return $this;
    }

    /**
     * Возвращает список аттрибутов и их значений указанного объекта.
     * !!! Если объект не AbstractDto - будут возвращены только публичные свойства
     *
     * @param object $object
     * @return array
     */
    private function getAttributesByObject(object $object)
    {
        if ($object instanceof AbstractDto) {
            return $object->toArray();
        }

        return get_object_vars($object);
    }

    /**
     * @param mixed $value
     * @return string|int
     */
    protected function formatValue($value)
    {
        if ($value === "") {
            $value = null;
        }

        return $value;
    }

    /**
     * Собирает данные свойст в массив
     *
     * @return array
     */
    protected function collectToArray(): array
    {
        //Собирает массив данных из свойств объекта
        $attributes = array_map(function ($value) {
            if ($value instanceof AbstractDto) {
                return $value->toArray();
            } else {
                if ($value instanceof Collection) {
                    return array_map(function ($item) {
                        if ($item instanceof Model) {
                            return $item->getAttributes();
                        }

                        return $item;
                    }, $value->all());

                } else {
                    if ($value instanceof Carbon) {
                        return $value;
                    } else {
                        if (is_object($value)) {
                            return get_object_vars($value);
                        }
                    }
                }
            }

            if (is_array($value)) {
                $tValue = [];
                foreach ($value as $key => $arValue) {
                    if ($arValue instanceof AbstractDto) {
                        $tValue[$key] = $arValue->toArray();
                    } elseif (is_object($arValue)) {
                        $tValue[$key] = get_object_vars($arValue);
                    } else {
                        $tValue[$key] = $arValue;
                    }
                }

                $value = $tValue;
            }

            return $value;
        }, get_object_vars($this));

        return $attributes;
    }

    /**
     * Возвращает мыссив свойств объекта
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->collectToArray();
    }

    /**
     * Возвращает мыссив свойств объекта
     *
     * @return array
     */
    public function toAttributes(): array
    {
        $result = [];
        foreach ($this->collectToArray() as $key => $value) {
            $result[StringHelper::formatCamelToSnakeCase($key)] = $value;
        }

        return $result;
    }

    /**
     * @param bool $applyProtection
     * @return Collection
     */
    public function toCollection(): Collection
    {
        return new Collection($this->collectToArray());
    }

    /**
     * @param $key
     * @return array
     */
    public function toArrayByKey($key): array
    {
        $attributes = $this->collectToArray();

        return array_key_exists($key, $attributes) ? $attributes[$key] : [];
    }

    /**
     * @param $key
     * @return Collection
     */
    public function toCollectionByKey($key): Collection
    {
        $attributes = $this->collectToArray();

        return array_key_exists($key, $attributes) ? new Collection($attributes[$key]) : new Collection();
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

    public function offsetExists($offset)
    {
        return property_exists($this, $offset);
    }

    public function offsetGet($offset)
    {
        if (property_exists($this, $offset)) {
            return $this->{$offset};
        }
    }

    public function offsetSet($offset, $value)
    {
        if (property_exists($this, $offset)) {
            return $this->{$offset} = $value;
        }
    }

    public function offsetUnset($offset)
    {
        if (property_exists($this, $offset)) {
            return $this->{$offset} = null;
        }
    }
}
