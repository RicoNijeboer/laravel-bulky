<?php

namespace Rico\Bulky;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class BulkServiceProvider extends ServiceProvider
{

    public function boot()
    {
        /** @var Router $router */
        $router = $this->app['router'];

        // Default;
        //   $router->any('/_bulk', [BulkController, 'handle']
        $methods = config('bulky.method');

        if ( ! is_array($methods))
        {
            $methods = [$methods];
        }

        do
        {
            $method = array_pop($methods);
            $router->{$method}(config('bulky.slug'), config('bulky.action'));
        } while (count($methods) > 0);
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