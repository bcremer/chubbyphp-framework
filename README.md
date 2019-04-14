# chubbyphp-framework

[![Build Status](https://api.travis-ci.org/chubbyphp/chubbyphp-framework.png?branch=master)](https://travis-ci.org/chubbyphp/chubbyphp-framework)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chubbyphp/chubbyphp-framework/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/chubbyphp/chubbyphp-framework/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/chubbyphp/chubbyphp-framework/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/chubbyphp/chubbyphp-framework/?branch=master)
[![Total Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-framework/downloads.png)](https://packagist.org/packages/chubbyphp/chubbyphp-framework)
[![Monthly Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-framework/d/monthly)](https://packagist.org/packages/chubbyphp/chubbyphp-framework)
[![Latest Stable Version](https://poser.pugx.org/chubbyphp/chubbyphp-framework/v/stable.png)](https://packagist.org/packages/chubbyphp/chubbyphp-framework)
[![Latest Unstable Version](https://poser.pugx.org/chubbyphp/chubbyphp-framework/v/unstable)](https://packagist.org/packages/chubbyphp/chubbyphp-framework)

## Description

A minimal framework using [PHP Framework Interop Group - PSR][1]

 * [Basic Coding Standard (1)][2]
 * [Coding Style Guide (2)][3]
 * [Logger Interface (3)][4]
 * [Autoloading Standard (4)][5]
 * [HTTP Message Interface (7)][6]
 * [Container Interface (11)][7]
 * [HTTP Handlers (15)][8]
 * [HTTP Factories (17)][9]

The goal of this framework is to achive the best combination of flexibility and simplicity by using standards.

About flexibility: Everything should be replaceable the a framework user.
About simplicity: Nothing should be more complex than needed to fulfill the flexibility.

## Requirements

 * php: ^7.2
 * psr/container: ^1.0
 * psr/http-factory: ^1.0
 * psr/http-message: ^1.0.1
 * psr/http-server-middleware: ^1.0.1
 * psr/log: ^1.1

## Suggest

 * nikic/fast-route: ^1.3
 * pimple/pimple: ^3.2.3
 * zendframework/zend-diactoros: ^2.1.1

## Installation

Through [Composer](http://getcomposer.org) as [chubbyphp/chubbyphp-framework][20].

```sh
composer create-project chubbyphp/chubbyphp-framework -s dev example
cd example
```

### Install FastRoute and ZendDiactoros

```sh
composer require nikic/fast-route: "^1.3"
composer require zendframework/zend-diactoros "^2.1.1"
```

## Usage

### Basic example using FastRoute and ZendDiactoros

```php
<?php

declare(strict_types=1);

namespace App;

use Chubbyphp\Framework\Application;
use Chubbyphp\Framework\Middleware\MiddlewareDispatcher;
use Chubbyphp\Framework\ResponseHandler\HtmlExceptionResponseHandler;
use Chubbyphp\Framework\Router\FastRoute\RouteDispatcher;
use Chubbyphp\Framework\Router\RouteCollection;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface as PsrRequestHandlerInterface;
use Zend\Diactoros\ResponseFactory;
use Zend\Diactoros\ServerRequestFactory;

$loader = require __DIR__.'/vendor/autoload.php';

$responseFactory = new ResponseFactory();

$routeCollection = new RouteCollection();
$routeCollection
    ->get(
        '/hello/{name}',
        'hello',
        new class($responseFactory) implements PsrRequestHandlerInterface
        {
            /**
             * @var ResponseFactoryInterface
             */
            private $responseFactory;

            /**
             * @param string $responseFactory
             */
            public function __construct(string $responseFactory)
            {
                $this->responseFactory = $responseFactory;
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                $name = $request->getAttribute('name');
                $response = $this->responseFactory->createResponse();
                $response->getBody()->write("Hello, $name");

                return $response;
            }
        }
    );

$app = new Application(
    new RouteDispatcher($routeCollection),
    new MiddlewareDispatcher(),
    new HtmlExceptionResponseHandler($responseFactory)
);

$app->run(ServerRequestFactory::fromGlobals());
```

## Web Server

[Go to web server configuration][30]

## Copyright

Dominik Zogg 2019

[1]: https://www.php-fig.org/psr/

[2]: https://www.php-fig.org/psr/psr-1
[3]: https://www.php-fig.org/psr/psr-2
[4]: https://www.php-fig.org/psr/psr-3
[5]: https://www.php-fig.org/psr/psr-4
[6]: https://www.php-fig.org/psr/psr-7
[7]: https://www.php-fig.org/psr/psr-11
[8]: https://www.php-fig.org/psr/psr-15
[9]: https://www.php-fig.org/psr/psr-17

[20]: https://packagist.org/packages/chubbyphp/chubbyphp-framework

[30]: doc/webserver.md
