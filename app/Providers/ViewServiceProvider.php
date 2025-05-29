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

            $permissions = $user->getAllPermissions()
                ->load('module')
                ->groupBy('module.name'); // or group by module_id
            
            $view->with('permissionsByModule', $permissions);

            /* $permissions = $user->getAllPermissions()
                ->load('module')
                ->groupBy('module.name')
                ->map(function ($permissionsGroup) {
                    return $permissionsGroup->map(function ($permission) {
                        return [
                            'name' => $permission->name,
                            'slug' => $permission->slug
                        ];
                    });
                }); */
        });
    }
}
