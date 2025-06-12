<?php

declare(strict_types=1);

/**
 * This file is part of php-fast-forward/http-client.
 *
 * This source file is subject to the license bundled
 * with this source code in the file LICENSE.
 *
 * @link      https://github.com/php-fast-forward/http-client
 * @copyright Copyright (c) 2025 Felipe Sayão Lobato Abreu <github@mentordosnerds.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace FastForward\Http\Client\ServiceProvider;

use FastForward\Container\Factory\InvokableFactory;
use FastForward\Container\Factory\MethodFactory;
use Interop\Container\ServiceProviderInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Psr18Client;

/**
 * Class HttpClientServiceProvider.
 *
 * Provides a PSR-compliant HTTP client service provider for dependency injection containers.
 * This service provider SHALL register factories for HTTP client services.
 * It MUST implement the ServiceProviderInterface to allow standardized service registration.
 */
final class HttpClientServiceProvider implements ServiceProviderInterface
{
    /**
     * Retrieves an array of service factories.
     *
     * This method MUST return an associative array where the key is the service name or interface
     * and the value is a callable or factory responsible for creating the service.
     * The array returned SHALL register the default Symfony HttpClient and a PSR-18 compatible client.
     *
     * @return array<class-string, callable> an associative array of service factories
     */
    public function getFactories(): array
    {
        return [
            HttpClient::class      => new MethodFactory(HttpClient::class, 'create'),
            ClientInterface::class => new InvokableFactory(
                Psr18Client::class,
                HttpClient::class,
                ResponseFactoryInterface::class,
                StreamFactoryInterface::class,
            ),
        ];
    }

    /**
     * Retrieves an array of service extensions.
     *
     * This method MUST return an associative array of callables to extend existing services.
     * If no extensions are to be registered, an empty array MUST be returned.
     *
     * @return array<class-string, callable> an associative array of service extensions
     */
    public function getExtensions(): array
    {
        return [];
    }
}
