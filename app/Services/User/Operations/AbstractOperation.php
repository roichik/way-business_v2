<?php

namespace App\Services\User\Operations;

use App\Services\User\UserService;

/**
 * Class AbstractOperation
 */
class AbstractOperation
{
    /**
     * @param UserService $service
     */
    public function __construct(protected UserService $service)
    {
    }
}
