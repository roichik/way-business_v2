<?php

namespace App\Services\Security\Operations;

use App\Services\Security\SecurityService;
use App\Services\User\UserService;

/**
 * Class AbstractOperation
 */
class AbstractOperation
{
    /**
     * @param UserService $service
     */
    public function __construct(protected SecurityService $service)
    {

    }
}
