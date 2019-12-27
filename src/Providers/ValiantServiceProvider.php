<?php

namespace Kdion4891\Valiant\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Kdion4891\Valiant\Console\Commands\ValiantMakeCommand;

class ValiantServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__ . '/../../resources/stubs/controllers/auth/ConfirmPasswordController.stub' => app_path('Http/Controllers/Auth/ConfirmPasswordController.php')], 'install');
        $this->publishes([__DIR__ . '/../../resources/stubs/controllers/auth/ForgotPasswordController.stub' => app_path('Http/Controllers/Auth/ForgotPasswordController.php')], 'install');
        $this->publishes([__DIR__ . '/../../resources/stubs/controllers/auth/LoginController.stub' => app_path('Http/Controllers/Auth/LoginController.php')], 'install');
        $this->publishes([__DIR__ . '/../../resources/stubs/controllers/auth/ProfileController.stub' => app_path('Http/Controllers/Auth/ProfileController.php')], 'install');
        $this->publishes([__DIR__ . '/../../resources/stubs/controllers/auth/RegisterController.stub' => app_path('Http/Controllers/Auth/RegisterController.php')], 'install');
        $this->publishes([__DIR__ . '/../../resources/stubs/controllers/auth/ResetPasswordController.stub' => app_path('Http/Controllers/Auth/ResetPasswordController.php')], 'install');
        $this->publishes([__DIR__ . '/../../resources/stubs/controllers/auth/VerificationController.stub' => app_path('Http/Controllers/Auth/VerificationController.php')], 'install');
        $this->publishes([__DIR__ . '/../../resources/stubs/controllers/HomeController.stub' => app_path('Http/Controllers/HomeController.php')], 'install');
        $this->publishes([__DIR__ . '/../../resources/stubs/controllers/LogController.stub' => app_path('Http/Controllers/LogController.php')], 'install');
        $this->publishes([__DIR__ . '/../../resources/stubs/controllers/UserController.stub' => app_path('Http/Controllers/UserController.php')], 'install');
        $this->publishes([__DIR__ . '/../../resources/stubs/models/Log.stub' => app_path('Log.php')], 'install');
        $this->publishes([__DIR__ . '/../../resources/stubs/models/User.stub' => app_path('User.php')], 'install');
        $this->publishes([__DIR__ . '/../../public' => public_path('valiant')], ['install', 'public']);
        $this->publishes([__DIR__ . '/../../resources/views/layouts/navs/sidebar.blade.php' => resource_path('views/vendor/valiant/layouts/navs/sidebar.blade.php')], ['install']);
        $this->publishes([__DIR__ . '/../../resources/views' => resource_path('views/vendor/valiant')], ['views']);
        $this->publishes([__DIR__ . '/../../resources/stubs/routes/routes.stub' => base_path('routes/web.php')], 'install');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'valiant');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands(ValiantMakeCommand::class);
        }

        Gate::before(function ($user, $role) {
            if ($user->role == $role) return true;
        });
    }
}
