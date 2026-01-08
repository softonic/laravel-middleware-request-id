<?php

namespace Softonic\Laravel\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

/**
 * Class RequestId.
 *
 * @package Softonic\Laravel\Middleware
 */
class RequestId
{
    /**
     * Add the Request ID header if needed.
     *
     * @param Request $request Request to be checked.
     * @param Closure $next
     * @param null $guard
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        $uuid = $request->headers->get('X-Request-ID');

        if (is_null($uuid)) {
            $uuid = Uuid::uuid4()->toString();

            $request->headers->set('X-Request-ID', $uuid);
        }

        $_SERVER['HTTP_X_REQUEST_ID'] = $uuid;

        $response = $next($request);

        $response->headers->set('X-Request-ID', $uuid);

        return $response;
    }
}
