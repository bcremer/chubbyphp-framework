<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Framework\Router\AuraRouter;

use Chubbyphp\Framework\Router\AuraRouter\RouteDispatcher;
use Chubbyphp\Framework\Router\GroupInterface;
use Chubbyphp\Framework\Router\RouteDispatcherException;
use Chubbyphp\Framework\Router\RouteInterface;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * @covers \Chubbyphp\Framework\Router\AuraRouter\RouteDispatcher
 */
final class RouteDispatcherTest extends TestCase
{
    use MockByCallsTrait;

    public function testDispatchFound(): void
    {
        /** @var UriInterface|MockObject $uri */
        $uri = $this->getMockByCalls(UriInterface::class, [
            Call::create('getPath')->with()->willReturn('/api/pet'),
            Call::create('getPath')->with()->willReturn('/api/pet'),
        ]);

        /** @var ServerRequestInterface|MockObject $request */
        $request = $this->getMockByCalls(ServerRequestInterface::class, [
            Call::create('getUri')->with()->willReturn($uri),
            Call::create('getUri')->with()->willReturn($uri),
            Call::create('getMethod')->with()->willReturn('GET'),
        ]);

        /** @var RouteInterface|MockObject $route */
        $route = $this->getMockByCalls(RouteInterface::class, [
            Call::create('getPathOptions')->with()->willReturn([]),
            Call::create('getName')->with()->willReturn('pet_list'),
            Call::create('getPath')->with()->willReturn('/api/pet'),
            Call::create('getMethod')->with()->willReturn('GET'),
            Call::create('withAttributes')->with([])->willReturnSelf(),
        ]);

        /** @var GroupInterface|MockObject $group */
        $group = $this->getMockByCalls(GroupInterface::class, [
            Call::create('getRoutes')->with()->willReturn(['pet_list' => $route]),
        ]);

        $routeDispatcher = new RouteDispatcher($group);

        self::assertSame($route, $routeDispatcher->dispatch($request));
    }

    public function testDispatchNotFound(): void
    {
        $this->expectException(RouteDispatcherException::class);
        $this->expectExceptionMessage(
            'The page "/" you are looking for could not be found.'
                .' Check the address bar to ensure your URL is spelled correctly.'
        );
        $this->expectExceptionCode(404);

        /** @var UriInterface|MockObject $uri */
        $uri = $this->getMockByCalls(UriInterface::class, [
            Call::create('getPath')->with()->willReturn('/'),
            Call::create('getPath')->with()->willReturn('/'),
        ]);

        /** @var ServerRequestInterface|MockObject $request */
        $request = $this->getMockByCalls(ServerRequestInterface::class, [
            Call::create('getUri')->with()->willReturn($uri),
            Call::create('getUri')->with()->willReturn($uri),
            Call::create('getRequestTarget')->with()->willReturn('/'),
        ]);

        /** @var RouteInterface|MockObject $route */
        $route = $this->getMockByCalls(RouteInterface::class, [
            Call::create('getPathOptions')->with()->willReturn([]),
            Call::create('getName')->with()->willReturn('pet_list'),
            Call::create('getPath')->with()->willReturn('/api/pet'),
            Call::create('getMethod')->with()->willReturn('GET'),
        ]);

        /** @var GroupInterface|MockObject $group */
        $group = $this->getMockByCalls(GroupInterface::class, [
            Call::create('getRoutes')->with()->willReturn(['pet_list' => $route]),
        ]);

        $routeDispatcher = new RouteDispatcher($group);

        self::assertSame($route, $routeDispatcher->dispatch($request));
    }

    public function testDispatchMethodNotAllowed(): void
    {
        $this->expectException(RouteDispatcherException::class);
        $this->expectExceptionMessage(
            'Method "POST" at path "/api/pet?offset=1&limit=20" is not allowed. Must be one of: "GET"'
        );
        $this->expectExceptionCode(405);

        /** @var UriInterface|MockObject $uri */
        $uri = $this->getMockByCalls(UriInterface::class, [
            Call::create('getPath')->with()->willReturn('/api/pet'),
            Call::create('getPath')->with()->willReturn('/api/pet'),
        ]);

        /** @var ServerRequestInterface|MockObject $request */
        $request = $this->getMockByCalls(ServerRequestInterface::class, [
            Call::create('getUri')->with()->willReturn($uri),
            Call::create('getUri')->with()->willReturn($uri),
            Call::create('getMethod')->with()->willReturn('POST'),
            Call::create('getMethod')->with()->willReturn('POST'),
            Call::create('getRequestTarget')->with()->willReturn('/api/pet?offset=1&limit=20'),
        ]);

        /** @var RouteInterface|MockObject $route */
        $route = $this->getMockByCalls(RouteInterface::class, [
            Call::create('getPathOptions')->with()->willReturn([]),
            Call::create('getName')->with()->willReturn('pet_list'),
            Call::create('getPath')->with()->willReturn('/api/pet'),
            Call::create('getMethod')->with()->willReturn('GET'),
        ]);

        /** @var GroupInterface|MockObject $group */
        $group = $this->getMockByCalls(GroupInterface::class, [
            Call::create('getRoutes')->with()->willReturn(['pet_list' => $route]),
        ]);

        $routeDispatcher = new RouteDispatcher($group);

        self::assertSame($route, $routeDispatcher->dispatch($request));
    }
}
