API Reference
=============

FastForward HTTP Client ships one public provider class. The rest of the package
surface is defined by the service IDs that this provider publishes into a
container and by the external classes those services use behind the scenes.

Public Surface At A Glance
--------------------------

.. list-table::
   :header-rows: 1

   * - Item
     - Kind
     - Responsibility
   * - ``FastForward\Http\Client\ServiceProvider\HttpClientServiceProvider``
     - Class
     - Publishes the package factories and declares that there are no service
       extensions.
   * - ``Psr\Http\Client\ClientInterface``
     - Service ID
     - Exposes the PSR-18 client adapter built with ``Psr18Client``.
   * - ``Symfony\Component\HttpClient\HttpClient``
     - Service ID
     - Exposes the native Symfony transport entry point built from
       ``HttpClient::create()``.

.. toctree::
   :maxdepth: 2

   http-client-service-provider
   registered-services
