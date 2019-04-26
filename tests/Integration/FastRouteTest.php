<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Framework\Integration;

use Chubbyphp\Framework\Application;
use Chubbyphp\Framework\Middleware\MiddlewareDispatcher;
use Chubbyphp\Framework\RequestHandler\CallbackRequestHandler;
use Chubbyphp\Framework\ResponseHandler\ExceptionResponseHandler;
use Chubbyphp\Framework\Router\FastRouteRouter;
use Chubbyphp\Framework\Router\Route;
use Chubbyphp\Framework\Router\RouteInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ResponseFactory;
use Zend\Diactoros\ServerRequest;

/**
 * @coversNothing
 */
final class FastRouteTest extends TestCase
{
    public function testTestNotFound(): void
    {
        $responseFactory = new ResponseFactory();

        $route = Route::get('/hello/{name:[a-z]+}', 'hello', new CallbackRequestHandler(
            function (ServerRequestInterface $request) use ($responseFactory) {
                $name = $request->getAttribute('name');
                $response = $responseFactory->createResponse();
                $response->getBody()->write(sprintf('Hello, %s', $name));

                return $response;
            }
        ));

        $cacheDir = sys_get_temp_dir().'/fast-route/'.uniqid().'/'.uniqid();

        mkdir($cacheDir, 0777, true);

        $app = new Application(
            new FastRouteRouter([$route], $cacheDir),
            new MiddlewareDispatcher(),
            new ExceptionResponseHandler($responseFactory)
        );

        $request = new ServerRequest(
            [],
            [],
            '/hello',
            RouteInterface::GET,
            'php://memory'
        );

        $response = $app->handle($request);

        self::assertSame(404, $response->getStatusCode());
        self::assertStringContainsString(
            'The page "/hello" you are looking for could not be found.',
            (string) $response->getBody()
        );
    }

    public function testMethodNotAllowed(): void
    {
        $responseFactory = new ResponseFactory();

        $route = Route::get('/hello/{name:[a-z]+}', 'hello', new CallbackRequestHandler(
            function (ServerRequestInterface $request) use ($responseFactory) {
                $name = $request->getAttribute('name');
                $response = $responseFactory->createResponse();
                $response->getBody()->write(sprintf('Hello, %s', $name));

                return $response;
            }
        ));

        $cacheDir = sys_get_temp_dir().'/fast-route/'.uniqid().'/'.uniqid();

        mkdir($cacheDir, 0777, true);

        $app = new Application(
            new FastRouteRouter([$route], $cacheDir),
            new MiddlewareDispatcher(),
            new ExceptionResponseHandler($responseFactory)
        );

        $request = new ServerRequest(
            [],
            [],
            '/hello/test',
            RouteInterface::POST,
            'php://memory'
        );

        $response = $app->handle($request);

        self::assertSame(405, $response->getStatusCode());
        self::assertStringContainsString(
            'Method "POST" at path "/hello/test" is not allowed.',
            (string) $response->getBody()
        );
    }

    public function testOk(): void
    {
        $responseFactory = new ResponseFactory();

        $route = Route::get('/hello/{name:[a-z]+}', 'hello', new CallbackRequestHandler(
            function (ServerRequestInterface $request) use ($responseFactory) {
                $name = $request->getAttribute('name');
                $response = $responseFactory->createResponse();
                $response->getBody()->write(sprintf('Hello, %s', $name));

                return $response;
            }
        ));

        $cacheDir = sys_get_temp_dir().'/fast-route/'.uniqid().'/'.uniqid();

        mkdir($cacheDir, 0777, true);

        $app = new Application(
            new FastRouteRouter([$route], $cacheDir),
            new MiddlewareDispatcher(),
            new ExceptionResponseHandler($responseFactory)
        );

        $request = new ServerRequest(
            [],
            [],
            '/hello/test',
            RouteInterface::GET,
            'php://memory'
        );

        $response = $app->handle($request);

        self::assertSame(200, $response->getStatusCode());
        self::assertSame('Hello, test', (string) $response->getBody());
    }
}