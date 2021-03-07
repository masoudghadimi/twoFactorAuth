<?php


namespace Masoud\Twofactorauth;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TwoFactorAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/twoFactorAuth.php' , 'twoFactor');
    }

    public function boot()
    {
        $this->registerRoutes();
        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        $this->loadViewsFrom(__DIR__ . '/views/twoFactorAuth' , 'twoFactor');

        $this->publishes([
            __DIR__ . '/views/twoFactorAuth' => resource_path('views/vendor/TwoFactorAuth'),
            __DIR__ . '/config/twoFactorAuth.php' => config_path('twoFactor.php'),
        ] , 'twoFactor');
    }

    protected function registerRoutes()
    {
        Route::group($this->panelRouteConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/routes/panel.php');
        });

        Route::group($this->authRouteConfiguration() , function () {
            $this->loadRoutesFrom( __DIR__ . '/routes/route.php');
        });
    }

    /**
     * @return array
     */
    protected function panelRouteConfiguration(): array
    {
        return [
            'prefix' => config('twoFactor.prefixForPanelRoute'),
            'middleware' => ['web' , 'auth'],
        ];
    }

    /**
     * @return array
     */
    protected function authRouteConfiguration(): array
    {
        return [
            'prefix' => config('twoFactor.prefixForAuthRoute'),
            'middleware' => ['web'],
        ];
    }
}
