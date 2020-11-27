# Laravel Bulky

Laravel bulky enables you to do a bulk requests. Using the config you can set the `slug`, the `methods` you want to allow your user to use and the `action`. The action defaults to the provided controller and method, making the default funcionality available to you by default on `http://your-app.com/_bulk`

## Installation

```shell script
composer require riconijeboer/laravel-bulky
php artisan vendor:publish --provider="\Rico\Bulky\BulkServiceProvider"
```

## Configuration

### Slug

You can edit the slug the bulk endpoint is on. For example instead of the default `/_bulk` you may want just to use `/bulk` or `/api/bulk`.

### Methods

By default the endpoint allows `any` method. You could also overwrite it so only the `get` and `post` methods are allowed.

### Action

You can overwrite the action of the route that is created. I do recommend that **if** you overwrite the action, you do extend the default controller and simply add your functionality.

```php
<?php

return [
    'methods' => ['get','post'],
    'slug'    => '/api/bulk',
    'action'  => [\Rico\Bulky\BulkController::class, 'handle'],
];
```