<?php

namespace App\Services\Security;

use App\Services\Security\Operations\GeneralOperation;
use App\Services\Security\Operations\PermissionOperation;

/**
 * Class SecurityService
 */
class SecurityService
{
    /**
     * @return GeneralOperation
     */
    public function general()
    {
        return new GeneralOperation($this);
    }

    /**
     * @return PermissionOperation
     */
    public function permissions()
    {
        return new PermissionOperation($this);
    }
}
