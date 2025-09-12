<?php

namespace App\Services\BackPackAdmin\Operations;

use App\Models\User\User;
use App\Services\BackPackAdmin\Handlers\Security\SyncAllPermissionsHandler;

/**
 * Class SecurityOperation
 */
class SecurityOperation
{
    /**
     * @param User $user
     * @return void
     */
    public function syncAllPermissionsByUser(User $user)
    {
        (new SyncAllPermissionsHandler($user))
            ->handle();
    }
}
