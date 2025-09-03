<?php

namespace App\Models\Traites;

use App\Definitions\ModelSettingFieldTypeDefinition;
use App\Helpers\StringHelper;
use App\Interfaces\AbstractDto;
use App\Interfaces\Compoment;

/**
 * Добавляет методы к моделям, что выступают хранилищем для данных объектов со сменными полями для данных отночисельно типа самих данных
 * Trait ModelSettingFieldTypeValueTrait
 *
 * @package App\Models\traites
 * @author Aleksandr Roik
 */
trait ModelSettingFieldTypeValueTrait
{
    /**
     * Формат данных по умолчанию
     *
     * @var string
     */
    protected $defaultFieldType = ModelSettingFieldTypeDefinition::STRING;

    /**
     * Установка значения поля value_* по указаному типу
     *
     * @param string $fieldType
     * @param mixed $value
     * @return $this
     * @throws \Exception
     * @see ModelSettingFieldTypeDefinition
     */
    public function setValueByType(string $fieldType, mixed $value)
    {
        $this->clearValues();

        $this->field_type = $fieldType;
        $fieldName = 'value_' . $this->field_type;
        $this->{$fieldName} = $this->formatValueViaType($value);

        return $this;
    }

    /**
     * Установка значения поля value_* относительно типа данных в нем
     *
     * @param mixed $value
     * @return $this
     */
    public function setValueAuto(mixed $value)
    {
        $this->clearValues();

        $this->field_type = $this->getFieldTypeByValue($value);
        $fieldName = 'value_' . $this->field_type;
        $this->{$fieldName} = $this->formatValueViaType($value);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValueViaType()
    {
        $fieldName = 'value_' . $this->field_type;

        return $this->deFormatValueViaType(
            $this->{$fieldName}
        );
    }

    /**
     * Форматирует значение value в соответсвии с установленным форматом в поле field_type
     *
     * @param $value
     * @return string|integer|\DateTime|array|bool
     */
    private function formatValueViaType($value): mixed
    {
        if ($value === null || $value === '') {
            return null;
        }

        switch ($this->field_type) {
            case ModelSettingFieldTypeDefinition::STRING:
                return (string)$value;
            case ModelSettingFieldTypeDefinition::INTEGER:
                return (int)$value;
            case ModelSettingFieldTypeDefinition::DATETIME:
                if ($value instanceof \DateTime) {
                    return $value->format('Y.m.d H:i:s');
                }

                return $value;
            case ModelSettingFieldTypeDefinition::JSON:
                if (is_array($value)) {
                    return json_encode($value);
                } else {
                    if ($value instanceof AbstractDto || $value instanceof Compoment) {
                        return json_encode($value->toArray());
                    } else {
                        if (is_object($value)) {
                            return json_encode(get_object_vars($value));
                        }
                    }
                }

                return $value;
            case ModelSettingFieldTypeDefinition::BOOLEAN:
                return (bool)$value;
        }

        return $value;
    }

    /**
     * Обратное форматирование данных согласно типа в поле field_type
     *
     * @param $value
     * @return string|integer|\DateTime|array|bool
     */
    private function deFormatValueViaType($value): mixed
    {
        if ($value === null || $value === "") {
            return null;
        }

        switch ($this->field_type) {
            case ModelSettingFieldTypeDefinition::STRING:
                return (string)$value;
            case ModelSettingFieldTypeDefinition::INTEGER:
                return (int)$value;
            case ModelSettingFieldTypeDefinition::DATETIME:
                return new \DateTime($value);
            case ModelSettingFieldTypeDefinition::JSON:
                return json_decode($value, true);
            case ModelSettingFieldTypeDefinition::BOOLEAN:
                return (bool)$value;
        }

        return $value;
    }

    /**
     * Определяет формат для поля field_type по данных в значении $value
     *
     * @param mixed $value
     * @return string
     */
    private function getFieldTypeByValue(mixed $value)
    {
        if (is_array($value) || is_object($value) || StringHelper::isJSON($value)) {
            return ModelSettingFieldTypeDefinition::JSON;
        }
        if ($value instanceof \DateTime || (is_string($value) && $this->isDataTime($value) && strtotime($value) !== false)) {
        return ModelSettingFieldTypeDefinition::DATETIME;
    }
        if (is_bool($value)) {
            return ModelSettingFieldTypeDefinition::BOOLEAN;
        }
        if (is_integer($value)) {
            return ModelSettingFieldTypeDefinition::INTEGER;
        }
        if (is_string($value)) {
            return ModelSettingFieldTypeDefinition::STRING;
        }

        return $this->defaultFieldType;
    }

    /**
     * @param string $value
     * @return bool
     */
    private function isDataTime(string $value)
    {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])$/", $value)) {
            return true;
        }

        if (preg_match('@^(\d\d\d\d)-(\d\d)-(\d\d) (\d\d):(\d\d):(\d\d)$@', $value)) {
            return true;
        }

        return false;
    }

    /**
     * Очищает все поля value_*
     *
     * @return void
     */
    private function clearValues()
    {
        foreach (ModelSettingFieldTypeDefinition::getCollection() as $fieldType) {
            $fieldName = 'value_' . $fieldType;
            $this->{$fieldName} = null;
        }
    }
}
