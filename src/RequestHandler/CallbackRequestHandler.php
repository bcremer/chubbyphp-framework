<?php

declare(strict_types=1);

namespace Chubbyphp\Framework\RequestHandler;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class CallbackRequestHandler implements RequestHandlerInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @param ContainerInterface $container
     * @param string             $id
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $callback = $this->callback;

        return $callback($request);
    }
}