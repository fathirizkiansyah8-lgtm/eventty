<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AuthHelperServiceProvider extends ServiceProvider
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
        // Blade directives for role checking
        Blade::directive('admin', function () {
            return "<?php if(auth()->check() && auth()->user()->isAdmin()): ?>";
        });

        Blade::directive('endadmin', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('student', function () {
            return "<?php if(auth()->check() && auth()->user()->isStudent()): ?>";
        });

        Blade::directive('endstudent', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('role', function ($role) {
            return "<?php if(auth()->check() && auth()->user()->role === {$role}): ?>";
        });

        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        // View composers to share auth user globally
        view()->composer('*', function ($view) {
            $view->with('currentUser', Auth::user());
        });
    }
}
