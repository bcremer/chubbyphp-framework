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

### Cyclomatic Complexity

Values are generated by phploc at the 26.04.2019. For up2date values check [travis-ci][15].

```
Cyclomatic Complexity
  Average Complexity per LLOC                     0.11
  Average Complexity per Class                    3.22
    Minimum Class Complexity                      1.00
    Maximum Class Complexity                     16.00
  Average Complexity per Method                   1.58
    Minimum Method Complexity                     1.00
    Maximum Method Complexity                     6.00
```

## Requirements

 * php: ^7.2
 * [psr/container][20]: ^1.0
 * [psr/http-factory][21]: ^1.0
 * [psr/http-message-implementation][22]: ^1.0
 * [psr/http-message][23]: ^1.0.1
 * [psr/http-server-middleware][24]: ^1.0.1
 * [psr/log][25]: ^1.1

## Suggest

 * [aura/router][30]: ^3.1
 * [nikic/fast-route][31]: ^1.3
 * [zendframework/zend-diactoros][32]: ^2.1.1

## Installation

Through [Composer](http://getcomposer.org) as [chubbyphp/chubbyphp-framework][40].

Both example using the [zendframework/zend-diactoros][32] [psr/http-message-implementation][22].

### Aura.Router

```sh
composer require \
    aura/router "^3.1" \
    zendframework/zend-diactoros "^2.1.1" \
    chubbyphp/chubbyphp-framework "^1.0@alpha"
```

### FastRoute

```sh
composer require \
    nikic/fast-route "^1.3" \
    zendframework/zend-diactoros "^2.1.1" \
    chubbyphp/chubbyphp-framework "^1.0@alpha"
```

## Workflow

![Application workflow](doc/Resources/workflow.png?raw=true "Application workflow")

## Usage

### Examples

 * [Aura.Router][50]
 * [FastRoute][51]

### Middleware

 * [LazyMiddleware][60]
 * [MiddlewareDispatcher][61]

### RequestHandler

 * [CallbackRequestHandler][70]
 * [LazyRequestHandler][71]

### ResponseHandler

 * [ExceptionResponseHandler][80]

## Webserver

This documentations assumes, that the front controller is named index.php and is in the public directory.

 * [Builtin (development only)][100]
 * [Nginx][101]

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

[15]: https://travis-ci.org/chubbyphp/chubbyphp-framework

[20]: https://packagist.org/packages/psr/container
[21]: https://packagist.org/packages/psr/http-factory
[22]: https://packagist.org/packages/psr/http-message-implementation
[23]: https://packagist.org/packages/psr/http-message
[24]: https://packagist.org/packages/psr/http-server-middleware
[25]: https://packagist.org/packages/psr/log

[30]: https://packagist.org/packages/aura/router
[31]: https://packagist.org/packages/nikic/fast-route
[32]: https://packagist.org/packages/zendframework/zend-diactoros

[40]: https://packagist.org/packages/chubbyphp/chubbyphp-framework

[50]: doc/Examples/AuraRouter.md
[51]: doc/Examples/FastRoute.md

[60]: doc/Middleware/LazyMiddleware.md
[61]: doc/Middleware/MiddlewareDispatcher.md

[70]: doc/RequestHandler/CallbackRequestHandler.md
[71]: doc/RequestHandler/LazyRequestHandler.md

[80]: doc/ResponseHandler/ExceptionResponseHandler.md

[100]: doc/Webserver/Builtin.md
[101]: doc/Webserver/Nginx.md
