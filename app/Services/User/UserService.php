<?php

namespace App\Services\User;

use App\Services\User\Operations\ProfileCrudOperation;
use App\Services\User\Operations\UserCrudOperation;

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
     * @return UserCrudOperation
     */
    public function userCrud()
    {
        return new UserCrudOperation($this);
    }

    /**
     * @return ProfileCrudOperation
     */
    public function profileCrud()
    {
        return new ProfileCrudOperation($this);
    }

}
