<?php

namespace Rico\Bulky;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class BulkServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('bulky', BulkMiddleware::class);
    }
}