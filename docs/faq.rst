FAQ
===

What does this package actually register?
-----------------------------------------

It registers two service IDs:

- ``Psr\Http\Client\ClientInterface`` as a ``Symfony\Component\HttpClient\Psr18Client``;
- ``Symfony\Component\HttpClient\HttpClient`` as the result of
  ``HttpClient::create()``.

See :doc:`api/registered-services` for the full map.

Why is installing this package alone sometimes not enough?
----------------------------------------------------------

Because the PSR-18 client registration depends on
``Psr\Http\Message\ResponseFactoryInterface`` and
``Psr\Http\Message\StreamFactoryInterface`` already existing in your container.
This package requires the PSR-17 interfaces, but it does not ship concrete
factory services by itself.

Do I need ``fast-forward/http-factory``?
----------------------------------------

If your container does not already provide PSR-17 factories, yes. In a typical
FastForward application, that is the recommended companion package. If you want
an easier one-step setup, install ``fast-forward/http`` instead.

Which service should I inject in my own classes?
------------------------------------------------

Prefer ``Psr\Http\Client\ClientInterface`` unless you explicitly need
Symfony-specific features. It is the clearest contract for application services
and the easiest one to mock in tests.

Why does ``$container->get(HttpClient::class)`` not return an actual ``HttpClient`` object?
---------------------------------------------------------------------------------------------

Because ``Symfony\Component\HttpClient\HttpClient`` is used here as a service ID
for the static factory entry point. The object you receive is whatever
``HttpClient::create()`` selected for the current runtime, usually an instance
that implements ``Symfony\Contracts\HttpClient\HttpClientInterface``.

Do 4xx and 5xx responses throw exceptions?
------------------------------------------

Not when you use the PSR-18 ``sendRequest()`` method. HTTP error responses are
still normal responses. Exceptions are reserved for request construction issues,
transport failures, or response conversion failures.

Does this package register request, response, stream, or URI factories?
-----------------------------------------------------------------------

No. Those factories belong to the PSR-17 layer and should come from another
provider, typically ``fast-forward/http-factory`` in the FastForward ecosystem.

How do I set headers, timeouts, or a base URI?
----------------------------------------------

Override the ``HttpClient::class`` service or replace the ``ClientInterface``
registration in your container composition. See
:doc:`advanced/overriding-services` for working examples.

Can I replace Symfony with another PSR-18 implementation?
---------------------------------------------------------

Yes. Override ``Psr\Http\Client\ClientInterface`` with your own factory or
provider. The package does not force decoration through ``getExtensions()``; it
expects replacement to happen at the container-composition level.

Can I use this package outside ``fast-forward/container``?
----------------------------------------------------------

Yes, but only if your environment knows how to consume an
``Interop\Container\ServiceProviderInterface`` or if you translate the
registrations into your container's native format. The package itself is not a
standalone PSR-11 container.

What versions should I check before upgrading?
----------------------------------------------

Review PHP, ``fast-forward/container``, and ``symfony/http-client`` compatibility
first, then verify that your PSR-17 provider still matches the client setup. The
:doc:`compatibility` page summarizes the current expectations from this
repository.

Why does ``getExtensions()`` return an empty array?
---------------------------------------------------

Because the package is intentionally narrow. It publishes the default factories
and leaves decoration, aliases, and replacement decisions to the outer container
composition.
