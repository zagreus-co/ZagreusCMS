<?php

namespace App\Providers;

use App\Models\User\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->app->scoped('userPermissions', function() {
            $user = auth('sanctum')->user() ?? auth('web')->user() ?? null;

            if (is_null($user)) return [];

            // if user has no role , return empty array
            return $user->role()
                    ->with('permissions')
                    ->first()
                    ?->permissions
                    ->pluck('tag')
                    ->toArray() ?? [];
        });

        if (Schema::hasTable('permissions')) {
            foreach(\App\Models\User\Permission::all() as $permission) {
                Gate::define($permission->tag, function (\App\Models\User $user) use ($permission) {
                    return in_array($permission->tag, app('userPermissions'));
                });
            }
        }
    }
}
