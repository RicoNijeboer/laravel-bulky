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
        $methods = config('bulky.methods');

        if ( ! is_array($methods))
        {
            $methods = [$methods];
        }

        $methods = array_filter($methods);

        while (count($methods) > 0)
        {
            $method = array_pop($methods);
            $router->{$method}(config('bulky.slug'), config('bulky.action'));
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/bulky.php', 'bulky');

        if ($this->app->runningInConsole())
        {
            $this->publishes(
                [
                    __DIR__ . '/../config/bulky.php' => $this->app['path.config'] . DIRECTORY_SEPARATOR . 'bulky.php',
                ]
            );
        }

        parent::register();
    }
}