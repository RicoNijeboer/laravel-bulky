<?php

return [
    'methods' => 'any',
    'slug'    => '/_bulk',
    'action'  => [\Rico\Bulky\BulkController::class, 'handle'],
];