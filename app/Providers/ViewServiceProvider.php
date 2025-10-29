<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomPermission;



class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('partials.sidebar', function ($view) {
            $user = Auth::user();
            if (!$user) return;

            // Group user permissions by module name
            $permissions = $user->getAllPermissions()
                ->load('module')
                ->groupBy('module.name')
                ->sortBy(function ($permissions, $moduleName) {
                    return $permissions->first()->module->sorted ?? 0;
                })
                ->map(function ($permissions) {
                    return $permissions->sortBy('sorted');
                });

            $view->with('permissionsByModule', $permissions);
        });
    }
}
