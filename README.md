# softonic/laravel-middleware-request-id
[![Build Status](https://travis-ci.org/softonic/laravel-middleware-request-id.svg?branch=master)](https://travis-ci.org/softonic/laravel-middleware-request-id)

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
    Softonic\Laravel\Middleware\RequestId::class,
    ....
]
```

Specific group:
```php
// Example for WEB group
protected $middlewareGroups = [
        'web' => [
			Softonic\Laravel\Middleware\RequestId::class,
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