<?php

namespace App\Providers;

use App\Dictionaries\Security\PermissionDictionary;
use App\Models\User\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function (User $user) {
            if ($user->hasPermissionTo(PermissionDictionary::ADMIN)) {
                return true;
            }

            return null;
        });
    }
}
