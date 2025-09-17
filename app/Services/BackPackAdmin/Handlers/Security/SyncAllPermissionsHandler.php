<?php

namespace App\Services\BackPackAdmin\Handlers\Security;

use App\Models\User\User;
use App\Services\Security\Handlers\ConsolidatedSecurityStructureByUserHandler;
use App\Services\Security\SecurityService;

/**
 * Class SyncAllPermissionsHandler
 */
class SyncAllPermissionsHandler
{
    /**
     * @var ConsolidatedSecurityStructureByUserHandler
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
        $this->user->syncRoles($this->consolidatedData->roles());
        $this->user->syncPermissions($this->consolidatedData->permissions());
        $this
            ->syncFlags()
            ->syncCompanies();

        $this
            ->securityService
            ->general()
            ->forgetCachedPermissions();

        return $this;
    }

    /**
     * @return $this
     */
    private function syncFlags()
    {
        if ($this->user->accessAddon) {
            $this
                ->user
                ->accessAddon
                ->fill([
                    'flags' => $this->consolidatedData->flags()
                ])
                ->save();
        } else {
            $this
                ->user
                ->accessAddon()
                ->create([
                    'flags' => $this->consolidatedData->flags()
                ]);
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function syncCompanies()
    {
        $this
            ->user
            ->accessCompanies()
            ->sync($this->consolidatedData->companies()->pluck('id')->all());

        return $this;
    }
}
