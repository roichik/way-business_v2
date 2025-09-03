<?php

namespace App\Models;

use App\Helpers\StringHelper;
use Illuminate\Database\Eloquent\Model;

/**
 * Abstract Class BaseModel
 */
abstract class BaseModel extends Model
{
    /**
     * Fill the model with an array of attributes.
     *
     * @param array $attributes
     * @return $this
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function fill(array $attributes)
    {
        $result = [];
        foreach ($attributes as $key => $val) {
            $result[StringHelper::formatCamelToSnakeCase($key)] = $val;
        }

        return parent::fill($result);
    }

    /**
     * Set a given attribute on the model.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        $key = StringHelper::formatCamelToSnakeCase($key);

        return parent::setAttribute($key, $value);
    }
}
