<?php

namespace Softonic\Laravel\Middleware;

use Illuminate\Http\Request;
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
     * @param Request  $request Request to be checked.
     * @param \Closure $next
     * @param null     $guard
     *
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, \Closure $next, $guard = null)
    {
        $uuid = $request->headers->get('X-Request-ID');
        if (is_null($uuid)) {
            $uuid = Uuid::uuid4()->toString();

            $_SERVER['HTTP_X_REQUEST_ID'] = $uuid;
            $request->headers->set('X-Request-ID', $uuid);
        }

        $response = $next($request);

        $response->headers->set('X-Request-ID', $uuid);

        return $response;
    }
}
