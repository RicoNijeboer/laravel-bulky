<?php

return [
    'methods' => \Illuminate\Routing\Router::$verbs,
    'slug'    => '/_bulk',
    'action'  => [\Rico\Bulky\BulkController::class, 'handle'],
];