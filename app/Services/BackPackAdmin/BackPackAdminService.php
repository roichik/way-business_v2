<?php

namespace App\Services\BackPackAdmin;

use App\Services\BackPackAdmin\Operations\SecurityOperation;

/**
 * Class BackPackAdminService
 */
class BackPackAdminService
{
    /**
     * @return SecurityOperation
     */
    public function security()
    {
        return new SecurityOperation();
    }


}
