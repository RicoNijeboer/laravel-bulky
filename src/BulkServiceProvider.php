<?php

namespace Rico\Bulky;

use Illuminate\Support\ServiceProvider;

class BulkServiceProvider extends ServiceProvider
{

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
    }
}