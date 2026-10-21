---
name: fast-forward-http-client
description: Provide Fast Forward's Symfony-backed PSR-18 client, supply its required PSR-17 factories, and test success and transport failures without a network.
license: MIT; see LICENSE
compatibility: Supports fast-forward/http-client ^1.2 and PHP ^8.3. Requires Composer and declared extensions; inspect the installed version. Earlier releases are outside this contract.
metadata:
  author: Fast Forward
  api-baseline: fast-forward/http-client ^1.2
---

# Wire a PSR-18 HTTP client

Use this skill for an application consuming `fast-forward/http-client:^1.2`.
Read its instructions, manifest/lockfile and installed source before editing.
Run `composer show fast-forward/http-client`. For versions outside this contract,
inspect matching documentation; do not silently upgrade the application.

## First working integration

Requires PHP ^8.3, Composer's application autoloader and this package's runtime
dependencies. The direct example also needs `nyholm/psr7:^1.8`.
With authority to install the dependency:

```sh
composer require 'fast-forward/http-client:^1.2' 'nyholm/psr7:^1.8'
```

Create `app.php` in the application root alongside composer.json/vendor:

```php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use FastForward\Config\ArrayConfig;
use FastForward\Container\ContainerInterface;
use FastForward\Container\ServiceProvider\ArrayServiceProvider;
use FastForward\Http\Client\ServiceProvider\HttpClientServiceProvider;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpClient\Exception\TransportException;
use function FastForward\Container\container;

$config = new ArrayConfig([ContainerInterface::class => [HttpClientServiceProvider::class]]);
$factory = new Psr17Factory();
$makeContainer = static function (MockHttpClient $transport) use ($config, $factory): ContainerInterface {
    return container(
        new ArrayServiceProvider([
            HttpClient::class => static fn(): MockHttpClient => $transport,
            ResponseFactoryInterface::class => static fn(): Psr17Factory => $factory,
            StreamFactoryInterface::class => static fn(): Psr17Factory => $factory,
        ]),
        $config,
    );
};
$services = $makeContainer(new MockHttpClient(new MockResponse('{"ready":true}', ['http_code' => 200])));
$client = $services->get(ClientInterface::class);
$response = $client->sendRequest($factory->createRequest('GET', 'https://example.invalid/health'));
if ($response->getStatusCode() !== 200 || (string) $response->getBody() !== '{"ready":true}') {
    throw new RuntimeException('Client response differs.');
}
$failedClient = $makeContainer(new MockHttpClient(static function (): never {
    throw new TransportException('offline fixture');
}))->get(ClientInterface::class);

echo "integration ready\n";
```

Run `php app.php`. It throws on a wrong result; success prints
`integration ready`. It uses no production data and starts no server.

## Wiring and failure boundaries

The primary product is `FastForward\Http\Client\ServiceProvider\HttpClientServiceProvider`. Place that class in ArrayConfig under `FastForward\Container\ContainerInterface::class`, pass the config to `FastForward\Container\container($config)`, and request `Psr\Http\Client\ClientInterface`. It uses Symfony HttpClient::create and Psr18Client. A provider-only application may pass the provider class directly.

This package requires PSR-17 interfaces but does not ship a concrete message implementation or factory provider. In the application install `fast-forward/http-factory:^1.2` and register `FastForward\Http\Message\Factory\ServiceProvider\HttpMessageFactoryServiceProvider::class` before the client provider. Alternatively supply ResponseFactoryInterface and StreamFactoryInterface through your own ArrayServiceProvider. The direct example needs `nyholm/psr7:^1.8` explicitly; MockHttpClient/MockResponse come from the required Symfony component, not a test-only package.

Put custom factories/transport in an earlier ArrayServiceProvider; first successfully resolving source wins. Provider services are cached. A missing PSR-17 factory can make get(ClientInterface::class) fail even if has() is true. The helper constructs the composed container; your application passes the resolved client to services that send requests.

Read and validate application configuration before constructing a custom Symfony transport; this provider has no invented timeout/environment config key. For custom timeout/base URI/auth choose HttpClient::create($options) in an explicit factory. PSR-18 HTTP 4xx/5xx responses are returned normally; catch ClientExceptionInterface for client/transport failures. Keep credentials in the application's secret mechanism and avoid real network calls in tests.

The helper tries aggregate sources in registration order. A PSR container or
not-found exception from one source permits fallback to another source; other
throwables propagate. Source priority is therefore the first successful resolution,
not a guarantee that an earlier broken factory terminates lookup. Nested provider
list errors during helper composition are caught; if services are absent, inspect
the raw configuration and resolve the provider directly to diagnose the failure.

## Verify integration

Run the [complete example](examples/integration.php) against the application's
autoloader in a disposable process. It checks success and negative cases:

```sh
php /path/to/fast-forward-http-client/examples/integration.php ./vendor/autoload.php
```

Expected final marker: `fast-forward-http-client: ok`. Keep application-specific regression
tests in its existing PHPUnit suite, with each fixture class in its same-named
file. File copying, host discovery and completed agent tasks are different checks.
For optional copying/synchronization load
[installation and lifecycle](references/installation.md).
