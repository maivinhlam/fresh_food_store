<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Admin;
use App\Models\User;
use App\Models\Permission;

use App\Policies\UserPolicy;
use App\Policies\AdminPolicy;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Admin::class => AdminPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::before(function ($user) {
        //     if($user->role->name === 'system_admin') {
        //         return true;
        //     }
        // });

        if(!$this->app->runningInConsole()) {
            foreach (Permission::all() as $permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    if($user->hasPermission($permission))
                    {
                        return true;
                    }
                });
            }
        }
    }
}