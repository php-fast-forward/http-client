Getting Services
================

``HttpClientServiceProvider`` publishes two service IDs into your container. The
most important choice is whether your own code should depend on the portable
PSR-18 client contract or on Symfony's native client API.

Service Map
-----------

.. list-table::
   :header-rows: 1

   * - Service ID
     - Resolved object
     - Use it when
   * - ``Psr\Http\Client\ClientInterface``
     - ``Symfony\Component\HttpClient\Psr18Client``
     - Your application code should stay portable and PSR-18 focused.
   * - ``Symfony\Component\HttpClient\HttpClient``
     - A runtime-selected ``Symfony\Contracts\HttpClient\HttpClientInterface``
       implementation
     - You want direct access to Symfony's native ``request()`` API and option
       model.

Retrieving Services
-------------------

.. code-block:: php

   use Psr\Http\Client\ClientInterface;
   use Psr\Http\Message\RequestFactoryInterface;
   use Symfony\Component\HttpClient\HttpClient;
   use Symfony\Contracts\HttpClient\HttpClientInterface;

   /** @var ClientInterface $psr18Client */
   $psr18Client = $container->get(ClientInterface::class);

   /** @var RequestFactoryInterface $requestFactory */
   $requestFactory = $container->get(RequestFactoryInterface::class);

   /** @var HttpClientInterface $symfonyClient */
   $symfonyClient = $container->get(HttpClient::class);

Choosing The Right ID
---------------------

For most application services, prefer ``ClientInterface``:

- it reflects the actual contract your code needs;
- it is easier to mock in tests;
- it keeps your service independent from Symfony-specific features.

Reach for ``HttpClient::class`` when you specifically need native Symfony
capabilities such as ``request()``, streaming helpers, or ``withOptions()``.

.. note::

   ``HttpClient::class`` is a service identifier, not the runtime interface you
   would usually type-hint in a constructor. ``HttpClient::create()`` returns a
   ``Symfony\Contracts\HttpClient\HttpClientInterface`` implementation chosen at
   runtime, so constructor injection is usually clearer if you register your own
   alias for ``Symfony\Contracts\HttpClient\HttpClientInterface``.

Important Dependencies
----------------------

Resolving ``ClientInterface`` requires these services to be available first:

- ``Psr\Http\Message\ResponseFactoryInterface``
- ``Psr\Http\Message\StreamFactoryInterface``

This provider does not register them. In a FastForward application, they usually
come from ``FastForward\Http\Message\Factory\ServiceProvider\HttpMessageFactoryServiceProvider``.

The provider also does not register ``Psr\Http\Message\RequestFactoryInterface``.
If you want to build outgoing PSR-7 requests in your own services, make sure a
request factory provider is registered too.
