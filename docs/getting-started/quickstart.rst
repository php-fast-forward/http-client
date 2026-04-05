Quickstart
==========

This example uses both ``fast-forward/http-factory`` and
``fast-forward/http-client`` so it works in a fresh FastForward project without
hidden prerequisites.

.. code-block:: php

   <?php

   declare(strict_types=1);

   use FastForward\Http\Client\ServiceProvider\HttpClientServiceProvider;
   use FastForward\Http\Message\Factory\ServiceProvider\HttpMessageFactoryServiceProvider;
   use Psr\Http\Client\ClientInterface;
   use Psr\Http\Message\RequestFactoryInterface;

   use function FastForward\Container\container;

   $container = container(
       new HttpMessageFactoryServiceProvider(),
       new HttpClientServiceProvider(),
   );

   /** @var RequestFactoryInterface $requestFactory */
   $requestFactory = $container->get(RequestFactoryInterface::class);
   $request = $requestFactory
       ->createRequest('GET', 'https://example.com')
       ->withHeader('Accept', 'text/html');

   /** @var ClientInterface $client */
   $client = $container->get(ClientInterface::class);
   $response = $client->sendRequest($request);

   $statusCode = $response->getStatusCode();
   $body = (string) $response->getBody();

   // Example outcome:
   // $statusCode === 200
   // $body contains the HTML returned by https://example.com

What Happens Here
-----------------

- ``HttpMessageFactoryServiceProvider`` makes PSR-17 factories available in the
  container.
- ``HttpClientServiceProvider`` registers the Symfony transport and the PSR-18
  client adapter.
- ``RequestFactoryInterface`` creates an immutable PSR-7 request.
- ``ClientInterface`` sends that request and returns a PSR-7 response.

If You Prefer One Provider
--------------------------

If your project already depends on
`fast-forward/http <https://packagist.org/packages/fast-forward/http>`_, you can
register ``FastForward\Http\ServiceProvider\HttpServiceProvider`` instead of
listing the factory and client providers separately.

.. code-block:: php

   use FastForward\Http\ServiceProvider\HttpServiceProvider;

   use function FastForward\Container\container;

   $container = container(new HttpServiceProvider());

What To Read Next
-----------------

- :doc:`../usage/getting-services` for the service map and retrieval rules.
- :doc:`../usage/psr-18-client` for request-building and error-handling details.
- :doc:`../advanced/overriding-services` if you want custom timeouts, headers,
  or a different client registration strategy.
