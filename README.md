# FastForward HTTP Client

<p align="center">
  <img src="docs/_static/mascot-banner.png" alt="Dash sending a request to a server and receiving its response" width="840">
</p>

[![PHP Version](https://img.shields.io/badge/php-^8.3-777BB4?logo=php&logoColor=white)](https://www.php.net/releases/)
[![Composer Package](https://img.shields.io/badge/composer-fast--forward%2Fhttp--client-F28D1A.svg?logo=composer&logoColor=white)](https://packagist.org/packages/fast-forward/http-client)
[![Tests](https://img.shields.io/github/actions/workflow/status/php-fast-forward/http-client/tests.yml?logo=githubactions&logoColor=white&label=tests&color=22C55E)](https://github.com/php-fast-forward/http-client/actions/workflows/tests.yml)
[![Coverage](https://img.shields.io/badge/coverage-phpunit-4ADE80?logo=php&logoColor=white)](https://php-fast-forward.github.io/http-client/coverage/index.html)
[![Docs](https://img.shields.io/github/deployments/php-fast-forward/http-client/github-pages?logo=readthedocs&logoColor=white&label=docs&labelColor=1E293B&color=38BDF8&style=flat)](https://php-fast-forward.github.io/http-client/index.html)
[![License](https://img.shields.io/github/license/php-fast-forward/http-client?color=64748B)](LICENSE)
[![GitHub Sponsors](https://img.shields.io/github/sponsors/php-fast-forward?logo=githubsponsors&logoColor=white&color=EC4899)](https://github.com/sponsors/php-fast-forward)

[![PSR-11](https://img.shields.io/badge/PSR--11-container-777BB4?logo=php&logoColor=white)](https://www.php-fig.org/psr/psr-11/)
[![PSR-18](https://img.shields.io/badge/PSR--18-http--client-777BB4?logo=php&logoColor=white)](https://www.php-fig.org/psr/psr-18/)

FastForward HTTP Client is a focused integration package that registers a
PSR-18 HTTP client in a FastForward-compatible container. It uses Symfony
HttpClient as the transport layer and exposes
`Psr\Http\Client\ClientInterface` for application code.

## What this package does

- Registers `Psr\Http\Client\ClientInterface` as
  `Symfony\Component\HttpClient\Psr18Client`
- Registers `Symfony\Component\HttpClient\HttpClient` through
  `HttpClient::create()`
- Fits naturally into `fast-forward/container` service-provider based
  configuration

## Important note for first-time users

This package does not register PSR-17 factories on its own. To resolve
`Psr\Http\Client\ClientInterface`, your container must already provide:

- `Psr\Http\Message\ResponseFactoryInterface`
- `Psr\Http\Message\StreamFactoryInterface`

In a FastForward application, the usual solution is to install
[`fast-forward/http-factory`](https://github.com/php-fast-forward/http-factory)
or the all-in-one
[`fast-forward/http`](https://github.com/php-fast-forward/http) metapackage.

## Installation

Install the package itself:

```bash
composer require fast-forward/http-client
```

Choose one of these setups:

- If your container already provides PSR-17 factories, `fast-forward/http-client`
  is enough.
- If you want explicit FastForward PSR-17 and PSR-18 providers, install
  `fast-forward/http-client fast-forward/http-factory`.
- If you want the shortest onboarding path, install `fast-forward/http`.

## Quick start

This example uses both `fast-forward/http-factory` and
`fast-forward/http-client` so it works in a fresh project:

```php
<?php

declare(strict_types=1);

use FastForward\Http\Client\ServiceProvider\HttpClientServiceProvider;
use FastForward\Http\Message\Factory\ServiceProvider\HttpMessageFactoryServiceProvider;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

use function FastForward\Container\container;

$container = container(
    new HttpMessageFactoryServiceProvider(),
    new HttpClientServiceProvider(),
);

/** @var RequestFactoryInterface $requestFactory */
$requestFactory = $container->get(RequestFactoryInterface::class);
$request = $requestFactory->createRequest('GET', 'https://example.com');

/** @var ClientInterface $client */
$client = $container->get(ClientInterface::class);
$response = $client->sendRequest($request);

$statusCode = $response->getStatusCode();
$body = (string) $response->getBody();
```

## Registered services

| Service ID | Resolved object | Typical use |
| --- | --- | --- |
| `Psr\Http\Client\ClientInterface` | `Symfony\Component\HttpClient\Psr18Client` | Portable PSR-18 application code |
| `Symfony\Component\HttpClient\HttpClient` | A runtime-selected `Symfony\Contracts\HttpClient\HttpClientInterface` implementation | Native Symfony HttpClient features |

## Documentation

The Sphinx documentation in [`docs/`](docs/) now covers:

- installation paths for beginners
- the dependency on PSR-17 factories
- direct Symfony client usage versus PSR-18 usage
- override patterns for timeouts, headers, and base URIs
- compatibility notes and FAQ entries for common setup mistakes

## License

This package is open-source software licensed under the
[MIT License](https://opensource.org/licenses/MIT).

## Contributing

Contributions, issues, and pull requests are welcome at
[php-fast-forward/http-client](https://github.com/php-fast-forward/http-client).
