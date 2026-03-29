<?php

declare(strict_types=1);

/**
 * This file is part of php-fast-forward/http-client.
 *
 * This source file is subject to the license bundled
 * with this source code in the file LICENSE.
 *
 * @copyright Copyright (c) 2025-2026 Felipe Sayão Lobato Abreu <github@mentordosnerds.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 *
 * @see       https://github.com/php-fast-forward/http-client
 * @see       https://github.com/php-fast-forward
 * @see       https://datatracker.ietf.org/doc/html/rfc2119
 */

namespace FastForwardTest\Http\Client\ServiceProvider;

use FastForward\Container\Factory\InvokableFactory;
use FastForward\Container\Factory\MethodFactory;
use FastForward\Http\Client\ServiceProvider\HttpClientServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\HttpClient\HttpClient;

/**
 * @internal
 */
#[CoversClass(HttpClientServiceProvider::class)]
final class HttpClientServiceProviderTest extends TestCase
{
    private HttpClientServiceProvider $provider;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->provider = new HttpClientServiceProvider();
    }

    /**
     * @return void
     */
    #[Test]
    public function getFactoriesWillReturnHttpClientAndClientInterfaceFactories(): void
    {
        $factories = $this->provider->getFactories();

        self::assertArrayHasKey(HttpClient::class, $factories);
        self::assertArrayHasKey(ClientInterface::class, $factories);

        self::assertInstanceOf(MethodFactory::class, $factories[HttpClient::class]);
        self::assertInstanceOf(InvokableFactory::class, $factories[ClientInterface::class]);
    }

    /**
     * @return void
     */
    #[Test]
    public function getExtensionsWillReturnEmptyArray(): void
    {
        self::assertSame([], $this->provider->getExtensions());
    }
}
