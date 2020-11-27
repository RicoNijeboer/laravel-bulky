<?php

namespace Rico\Bulky;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\Kernel;

class BulkKernel extends Kernel
{

    /**
     * @param Application $app
     * @param BulkRouter  $router
     *
     * @return void
     */
    public function __construct(Application $app, BulkRouter $router)
    {
        parent::__construct($app, $router);
    }
}
