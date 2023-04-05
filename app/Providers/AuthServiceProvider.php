<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        $this->app->scoped('userPermissions', function () {
            $user = $this->getUser();

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
            $permissions = Cache::remember(
                'allPermissions',
                14400,
                fn () => Permission::select(['id', 'tag'])->get()->pluck('tag')->toArray()
            );

            foreach ($permissions as $permission) {
                Gate::define($permission, function () use ($permission) {
                    return in_array($permission, app('userPermissions'));
                });
            }
        }
    }

    protected function getUser(): ?User
    {
        return auth('sanctum')->user() ?? auth('web')->user() ?? null;
    }
}
