Registered Services
===================

This page documents the service IDs published by the provider together with the
external classes you are most likely to encounter while using them.

Service IDs
-----------

.. list-table::
   :header-rows: 1

   * - Service ID
     - Runtime object
     - Prerequisites
     - Typical use
   * - ``Symfony\Component\HttpClient\HttpClient``
     - A ``Symfony\Contracts\HttpClient\HttpClientInterface`` implementation
       selected by Symfony at runtime
     - None beyond this package
     - Direct use of Symfony's native client API.
   * - ``Psr\Http\Client\ClientInterface``
     - ``Symfony\Component\HttpClient\Psr18Client``
     - ``HttpClient::class``, ``ResponseFactoryInterface``, and
       ``StreamFactoryInterface``
     - Portable application code built around PSR-18.

Important External Classes
--------------------------

.. list-table::
   :header-rows: 1

   * - Class or interface
     - Role in the package
   * - ``Symfony\Component\HttpClient\Psr18Client``
     - Adapts Symfony HttpClient to the PSR-18 ``ClientInterface`` contract.
   * - ``Psr\Http\Message\ResponseFactoryInterface``
     - Creates PSR-7 response instances while the Symfony response is converted.
   * - ``Psr\Http\Message\StreamFactoryInterface``
     - Creates PSR-7 streams for response bodies.
   * - ``FastForward\Container\Factory\MethodFactory``
     - Calls ``HttpClient::create()`` for the transport registration.
   * - ``FastForward\Container\Factory\InvokableFactory``
     - Instantiates ``Psr18Client`` with services resolved from the container.

Services This Package Does Not Register
---------------------------------------

Several related interfaces are commonly used next to this package, but they are
not published here:

- ``Psr\Http\Message\RequestFactoryInterface``
- ``Psr\Http\Message\ResponseFactoryInterface``
- ``Psr\Http\Message\StreamFactoryInterface``
- ``Psr\Http\Message\UriFactoryInterface``
- ``Symfony\Contracts\HttpClient\HttpClientInterface``

That last item is worth calling out explicitly: the provider registers the
service under ``Symfony\Component\HttpClient\HttpClient`` instead, because it is
using Symfony's static factory entry point. If you want constructor injection by
``HttpClientInterface``, add your own alias or custom registration in the
container composition layer.
