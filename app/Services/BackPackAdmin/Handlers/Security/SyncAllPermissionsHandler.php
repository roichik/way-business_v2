<?php

namespace App\Services\BackPackAdmin\Handlers\Security;

use App\Models\User\User;
use App\Services\Security\SecurityService;

/**
 * Class SyncAllPermissionsHandler
 */
class SyncAllPermissionsHandler
{
    /**
     * @var array
     */
    private $consolidatedData;

    /**
     * @var SecurityService
     */
    private $securityService;

    /**
     * @param User $user
     */
    public function __construct(private User $user)
    {
        $this->securityService = resolve(SecurityService::class);

        $this->consolidatedData = $this
            ->securityService
            ->general()
            ->consolidatedSecurityStructureByUser(
                $user
            );
    }

    /**
     * @return $this
     */
    public function handle()
    {

        return $this;
    }
}
