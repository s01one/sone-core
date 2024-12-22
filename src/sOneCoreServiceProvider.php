<?php

namespace sOne\Core;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class sOneCoreServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Where the route file lives, both inside the package and in the app (if overwritten).
     *
     * @var string
     */
    public $routeFilePath = '/routes/sone/core/web.php';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // publish migrations
        $this->publishes([__DIR__.'/database/migrations' => database_path('migrations')], 'migrations');

        $this->publishes([
            __DIR__.'/config/sone/core.php' => base_path('config/sone/core.php'),
            __DIR__.'/config/sone/languages.php' => base_path('config/sone/languages.php'),
        ], 'config');

        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'sone');

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'sone');

        $this->publishes([
            __DIR__ . '/resources/views' => base_path('resources/views/vendor/sone/core')
        ], 'views');

        $this->publishes([
            __DIR__ . '/public/vendor/sone/core' => public_path('vendor/sone/core'),
        ], 'public');

        if ( $this->app->runningInConsole() ) {
            $this->commands([
                app\Console\Commands\InstallCommand::class,
                app\Console\Commands\ControllerCommand::class,
                app\Console\Commands\RequestCommand::class,
                app\Console\Commands\BuildAssetsCommand::class,
            ]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/sone/core.php', 'sone');
        $this->mergeConfigFrom(__DIR__.'/config/sone/languages.php', 'sone');
        $this->setupRoutes($this->app->router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        // by default, use the routes file provided in vendor
        $routeFilePathInUse = __DIR__.$this->routeFilePath;

        // but if there's a file with the same name in routes/backpack, use that one
        if (file_exists(base_path().$this->routeFilePath)) {
            $routeFilePathInUse = base_path().$this->routeFilePath;
        }

        $this->loadRoutesFrom($routeFilePathInUse);
    }
}
