<?php

namespace Rico\Bulky;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class BulkServiceProvider extends ServiceProvider
{

    public function boot()
    {
        /** @var Router $router */
        $router = app(Router::class);

        $router->addRoute(
            config('bulky.methods'),
            config('bulky.slug'),
            config('bulky.action')
        );
    }

    public function register()
    {
        $ownConfigPath = __DIR__ . '/../config/bulky.php';
        $this->mergeConfigFrom($ownConfigPath, 'bulky');

        if ($this->app->runningInConsole())
        {
            $this->publishes(
                [
                    $ownConfigPath => $this->app['path.config'] . DIRECTORY_SEPARATOR . 'bulky.php',
                ]
            );
        }

        parent::register();
    }
}