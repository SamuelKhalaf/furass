<?php

namespace App\Providers;

use App\Repositories\implementation\PermissionRepository;
use App\Repositories\implementation\RoleRepository;
use App\Repositories\implementation\UserRepository;
use App\Repositories\IPermissionRepository;
use App\Repositories\IRoleRepository;
use App\Repositories\IUserRepository;
use App\Services\implementation\PermissionService;
use App\Services\implementation\RoleService;
use App\Services\implementation\UserService;
use App\Services\IPermissionService;
use App\Services\IRoleService;
use App\Services\IUserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class,      UserRepository::class);
        $this->app->bind(IUserService::class,         UserService::class);
        $this->app->bind(IRoleRepository::class,      RoleRepository::class);
        $this->app->bind(IRoleService::class,         RoleService::class);
        $this->app->bind(IPermissionRepository::class,PermissionRepository::class);
        $this->app->bind(IPermissionService::class,   PermissionService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
