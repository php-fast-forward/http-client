<?php

declare(strict_types=1);

require $argv[1] ?? dirname(__DIR__, 4) . '/vendor/autoload.php';

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
try {
    $failedClient->sendRequest($factory->createRequest('GET', 'https://example.invalid/health'));
    throw new RuntimeException('Transport failure unexpectedly succeeded.');
} catch (ClientExceptionInterface) {
}

echo "fast-forward-http-client: ok\n";
