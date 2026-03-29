HttpClientServiceProvider
========================

.. php:class:: FastForward\Http\Client\ServiceProvider\HttpClientServiceProvider

   Provides a PSR-compliant HTTP client service provider for dependency injection containers.
   This service provider registers factories for HTTP client services, including:

   - ``Symfony\Component\HttpClient\HttpClient`` (default Symfony HTTP client)
   - ``Psr\Http\Client\ClientInterface`` (PSR-18 compatible client)

   **Usage:**

   .. code-block:: php

      use FastForward\Http\Client\ServiceProvider\HttpClientServiceProvider;
      use FastForward\Container\Container;

      $container = new Container([
          new HttpClientServiceProvider(),
      ]);

   **Methods:**

   .. php:method:: getFactories()

      Returns an associative array of service factories. Registers the default Symfony HttpClient and a PSR-18 compatible client.

   .. php:method:: getExtensions()

      Returns an associative array of service extensions. Returns an empty array if no extensions are registered.

   **Implements:**

   - :php:class:`Interop\Container\ServiceProviderInterface`
