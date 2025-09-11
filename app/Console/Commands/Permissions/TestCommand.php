<?php

namespace App\Console\Commands\Permissions;

use App\Models\Security\Role;
use App\Models\User\User;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'permission-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var User $user */
        $user = User::find(5);
        $user->assignRole(Role::find(1));
    }
}
