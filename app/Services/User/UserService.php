<?php

namespace App\Services\User;

use App\Services\User\Operations\CrudOperation;

/**
 * Class UserService
 */
class UserService
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * @return CrudOperation
     */
    public function crud()
    {
        return new CrudOperation($this);
    }

}
