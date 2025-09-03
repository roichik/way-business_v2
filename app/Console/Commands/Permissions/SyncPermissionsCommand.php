<?php

namespace App\Console\Commands\Permissions;

use App\Services\Security\SecurityService;
use Illuminate\Console\Command;

/**
 * Class SyncPermissionsCommand
 */
class SyncPermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Синхронизация разрешений со справочника PermissionDictionary';

    /**
     * Execute the console command.
     */
    public function handle(SecurityService $service)
    {
        $service
            ->permissions()
            ->syncPermissionByDictionary();

        $service
            ->general()
            ->forgetCachedPermissions();
    }
}
