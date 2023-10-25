<?php

namespace App\Providers;

use App\Interfaces\{
    AdminInterface,
    AuthAdminInterface,
    AuthUserInterface,
    PermissionInterface,
    ProjectInterface,
    RoleInterface,
    StatusInterface,
    TaskInterface,
    UserInterface,
    WorkspaceInterface
};

use App\Repositories\{
    AdminRepository,
    AuthAdminRepository,
    AuthUserRepository,
    PermissionRepository,
    ProjectRepository,
    RoleRepository,
    StatusRepository,
    TaskRepository,
    UserRepository,
    WorkspaceRepository
};

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Waad\Repository\Interfaces\BaseInterface;
use Waad\Repository\Repositories\BaseRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BaseInterface::class, BaseRepository::class);
        $this->app->bind(AuthUserInterface::class, AuthUserRepository::class);
        $this->app->bind(AuthAdminInterface::class, AuthAdminRepository::class);
        $this->app->bind(AdminInterface::class, AdminRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(RoleInterface::class, RoleRepository::class);
        $this->app->bind(PermissionInterface::class, PermissionRepository::class);
        $this->app->bind(WorkspaceInterface::class, WorkspaceRepository::class);
        $this->app->bind(ProjectInterface::class, ProjectRepository::class);
        $this->app->bind(TaskInterface::class, TaskRepository::class);
        $this->app->bind(StatusInterface::class, StatusRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(\App\Services\ProjectRegister::class);
        $this->app->singleton(\App\Services\TaskRegister::class);

        if (app()->isLocal()) {
            Scramble::routes(function (Route $route) {
                return Str::startsWith($route->uri, 'api/');
            });

            Scramble::extendOpenApi(function (OpenApi $openApi) {
                $openApi->secure(
                    SecurityScheme::http('bearer', 'JWT')
                );
            });
        }
    }
}
