<?php

namespace Rico\Bulky;

use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class BulkRouter extends Router
{

    public function __construct(Dispatcher $events, Container $container)
    {
        parent::__construct($events, $container);
        $this->setRoutes($container->get(Router::class)->getRoutes());
    }

    protected function runRouteWithinStack(Route $route, Request $request)
    {
        $route->withoutMiddleware('web');

        return parent::runRouteWithinStack($route, $request);
    }
}