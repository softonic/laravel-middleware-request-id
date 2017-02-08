<?php

namespace Softonic\Laravel\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestIdTest.
 *
 * @package Softonic\Laravel\Middleware
 */
class RequestIdTest extends TestCase
{
    public function testRequestIdIsAnObject()
    {
        $request_id = new RequestId();
        $this->assertThat(
            method_exists($request_id, 'handle'),
            $this->isTrue(),
            'A middleware must have a handle method.'
        );
    }

    public function testRequestIdShouldBeFilledIfDoesNotExistInRequestAndResponse()
    {
        $request  = new Request();
        $response = new Response();

        $closure = function (Request $request) use ($response) {
            $this->assertNotEmpty($request->header('X-Request-ID'));

            return $response;
        };

        $request_id = new RequestId();
        $response   = $request_id->handle($request, $closure);

        $this->assertNotEmpty(
            $request->header('X-Request-ID'),
            'The X-Request-ID header must exists.'
        );
        $this->assertEquals(
            $response->headers->get('X-Request-ID'),
            $request->header('X-Request-ID'),
            'The same X-Request-ID must be set in request and response.'
        );
    }

    public function testPropagateRequestIdToResponseIfProvidedInRequest()
    {
        $request = new Request();
        $request->headers->set('X-Request-ID', '09226165-364a-461a-bf5c-e859d70d907e');
        $response = new Response();

        $closure = function (Request $request) use ($response) {
            $this->assertEquals(
                '09226165-364a-461a-bf5c-e859d70d907e',
                $request->header('X-Request-ID'),
                'The Request header must not be modified.'
            );

            return $response;
        };

        $request_id = new RequestId();
        $response   = $request_id->handle($request, $closure);

        $this->assertEquals(
            '09226165-364a-461a-bf5c-e859d70d907e',
            $response->headers->get('X-Request-ID'),
            'The request X-Request-ID header must be set in the response.'
        );
    }
}