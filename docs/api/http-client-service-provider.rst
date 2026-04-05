HttpClientServiceProvider
=========================

.. php:class:: FastForward\Http\Client\ServiceProvider\HttpClientServiceProvider

   Registers the service factories exposed by ``fast-forward/http-client``.
   It implements ``Interop\Container\ServiceProviderInterface`` and publishes one
   Symfony transport entry point plus one PSR-18 client entry point.

Description
-----------

``HttpClientServiceProvider`` is the only class defined by this package. It has
no constructor arguments and no internal configuration object. Its job is to
return a small, explicit factory map and let container composition decide how
those services are overridden or complemented.

Factory Map
-----------

.. list-table::
   :header-rows: 1

   * - Service ID
     - Factory type
     - Result
   * - ``Symfony\Component\HttpClient\HttpClient``
     - ``FastForward\Container\Factory\MethodFactory``
     - Calls ``Symfony\Component\HttpClient\HttpClient::create()`` and returns a
       runtime-selected ``Symfony\Contracts\HttpClient\HttpClientInterface``
       implementation.
   * - ``Psr\Http\Client\ClientInterface``
     - ``FastForward\Container\Factory\InvokableFactory``
     - Builds ``Symfony\Component\HttpClient\Psr18Client`` using the Symfony
       transport plus PSR-17 response and stream factories.

Dependencies And Collaborators
------------------------------

The provider depends on several external classes and interfaces:

- ``Symfony\Component\HttpClient\HttpClient`` supplies the default transport
  factory method.
- ``Symfony\Component\HttpClient\Psr18Client`` adapts Symfony HttpClient to
  PSR-18.
- ``Psr\Http\Message\ResponseFactoryInterface`` and
  ``Psr\Http\Message\StreamFactoryInterface`` must already be resolvable in the
  container before ``ClientInterface`` can be built.
- ``FastForward\Container\Factory\MethodFactory`` and
  ``FastForward\Container\Factory\InvokableFactory`` perform the actual service
  creation steps.

Behavior Notes
--------------

- ``getFactories()`` returns exactly two registrations.
- ``getExtensions()`` returns an empty array.
- The provider does not register request, response, stream, or URI factory
  services on its own.
- The service ID ``HttpClient::class`` is a lookup key, not the exact runtime
  class you should expect after resolution.

Usage Example
-------------

.. code-block:: php

   use FastForward\Http\Client\ServiceProvider\HttpClientServiceProvider;
   use FastForward\Http\Message\Factory\ServiceProvider\HttpMessageFactoryServiceProvider;

   use function FastForward\Container\container;

   $container = container(
       new HttpMessageFactoryServiceProvider(),
       new HttpClientServiceProvider(),
   );

Methods
-------

.. php:method:: getFactories()

   Returns the package factory map. The map contains the Symfony transport entry
   and the PSR-18 client entry described above.

.. php:method:: getExtensions()

   Returns an empty extension map. Decoration and replacement are expected to be
   handled by the surrounding container composition.
