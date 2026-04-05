Integration
===========

FastForward HTTP Client is intentionally small. It registers a transport entry
point and a PSR-18 adapter, then relies on the surrounding container composition
to provide the PSR-17 collaborators required by that adapter.

Dependency Graph
----------------

The main service resolution path looks like this:

.. code-block:: text

   Psr\Http\Client\ClientInterface
       -> Symfony\Component\HttpClient\Psr18Client
           -> Symfony\Component\HttpClient\HttpClient::class
           -> Psr\Http\Message\ResponseFactoryInterface
           -> Psr\Http\Message\StreamFactoryInterface

This means the provider is complete only when your container can already resolve
the two PSR-17 factory interfaces.

Recommended FastForward Compositions
------------------------------------

Use one of these compositions depending on how explicit you want the setup to
be:

.. list-table::
   :header-rows: 1

   * - Composition style
     - What you register
     - Why you might choose it
   * - Explicit providers
     - ``HttpMessageFactoryServiceProvider`` and
       ``HttpClientServiceProvider``
     - Best when you want the service graph to stay obvious in configuration.
   * - Metapackage provider
     - ``FastForward\Http\ServiceProvider\HttpServiceProvider``
     - Best when you want one entry point for the full FastForward HTTP stack.
   * - Custom PSR-17 implementation
     - Your own registrations for ``ResponseFactoryInterface`` and
       ``StreamFactoryInterface`` plus ``HttpClientServiceProvider``
     - Best when you already have a house standard for PSR-7 and PSR-17.

Registration With The Container Helper
--------------------------------------

.. code-block:: php

   use FastForward\Http\Client\ServiceProvider\HttpClientServiceProvider;
   use FastForward\Http\Message\Factory\ServiceProvider\HttpMessageFactoryServiceProvider;

   use function FastForward\Container\container;

   $container = container(
       new HttpMessageFactoryServiceProvider(),
       new HttpClientServiceProvider(),
   );

Because ``container()`` resolves sources from left to right, the order of your
providers matters when you later start overriding services. See
:doc:`overriding-services` for the details.

Using The Package Outside FastForward Container
-----------------------------------------------

The package exports an ``Interop\Container\ServiceProviderInterface``
implementation. It plugs in directly only where that interface is understood.

If your application uses another PSR-11 container, you have two main options:

- translate the two service registrations into that container's native format;
- compose this provider through a FastForward container layer that your
  application consumes as a PSR-11 container.

Common Integration Mistake
--------------------------

If you see an error related to missing ``ResponseFactoryInterface`` or
``StreamFactoryInterface``, the HTTP client provider itself is usually not the
problem. The missing piece is almost always the PSR-17 factory provider that
should have been registered before it.
