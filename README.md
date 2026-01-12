# softonic/laravel-middleware-request-id
[![Build Status](https://img.shields.io/github/actions/workflow/status/softonic/laravel-middleware-request-id/tests.yml?branch=master&style=flat-square)](https://github.com/softonic/laravel-middleware-request-id/actions)

## Requirements

- PHP >= 8.5
- Laravel 12.x

## Install

```bash
$ composer require softonic/laravel-middleware-request-id
```

## Usage

### For all routes or a specific group

Add `Softonic\Laravel\Middleware\RequestId::class` in `App\Http\Kernel`.

For all routes:
```php
protected $middleware = [
    \Softonic\Laravel\Middleware\RequestId::class,
    ....
]
```

Specific group:
```php
// Example for WEB group
protected $middlewareGroups = [
        'web' => [
			\Softonic\Laravel\Middleware\RequestId::class,
			...
        ],

        'api' => [
            ...
        ],
    ];
```

### For a specific route

Register the middleware as a route middleware in `App\Http\Kernel`.
```php
    protected $routeMiddleware = [
		...
		'request-id' => Softonic\Laravel\Middleware\RequestId::class,
    ];
```

then, use it in your routes file, for example in `routes\web.php`
```php
Route::get('route', function() {})->middleware('request-id');
```

### Extra

If you need to have the X-Request-Id ASAP, you can modify `\App\Providers\AppServiceProvider::boot` adding `$_SERVER['HTTP_X_REQUEST_ID'] ??= \Ramsey\Uuid\Uuid::uuid4()->toString();`.
This is going to allow you to use the X-Request-ID in the framework booting to for example customize monolog or in console executions.

## Testing

To run the tests:

```bash
docker compose run --rm test
```

To run PHPUnit only:

```bash
docker compose run --rm phpunit
```

To check code style:

```bash
docker compose run --rm php composer run phpcs
```

To fix code style issues:

```bash
docker compose run --rm fixcs
```

To run static analysis:

```bash
docker compose run --rm php composer run phpstan
```
