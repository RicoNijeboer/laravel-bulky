<?php

namespace Rico\Bulky;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class BulkServiceProvider extends ServiceProvider
{

    public function boot()
    {
        /** @var Router $router */
        $router = $this->app['router'];

        // Default;
        //   $router->any('/_bulk', [BulkController, 'handle']
        $router->{config('bulky.method')}(config('bulky.slug'), config('bulky.action'));
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