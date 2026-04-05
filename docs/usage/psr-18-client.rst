Using The PSR-18 Client
=======================

``Psr\Http\Client\ClientInterface`` is the best default for application code. It
keeps your services on a standard contract while still using Symfony HttpClient
under the hood through ``Symfony\Component\HttpClient\Psr18Client``.

Sending A Basic Request
-----------------------

.. code-block:: php

   use Psr\Http\Client\ClientInterface;
   use Psr\Http\Message\RequestFactoryInterface;

   /** @var RequestFactoryInterface $requestFactory */
   $requestFactory = $container->get(RequestFactoryInterface::class);
   $request = $requestFactory->createRequest('GET', 'https://example.com');

   /** @var ClientInterface $client */
   $client = $container->get(ClientInterface::class);
   $response = $client->sendRequest($request);

   $statusCode = $response->getStatusCode();
   $body = (string) $response->getBody();

Sending JSON Or Other Bodies
----------------------------

For requests with a body, combine a request factory with a stream factory:

.. code-block:: php

   use Psr\Http\Client\ClientInterface;
   use Psr\Http\Message\RequestFactoryInterface;
   use Psr\Http\Message\StreamFactoryInterface;

   /** @var RequestFactoryInterface $requestFactory */
   $requestFactory = $container->get(RequestFactoryInterface::class);

   /** @var StreamFactoryInterface $streamFactory */
   $streamFactory = $container->get(StreamFactoryInterface::class);

   $payload = json_encode([
       'email' => 'jane@example.com',
       'name' => 'Jane',
   ], JSON_THROW_ON_ERROR);

   $request = $requestFactory
       ->createRequest('POST', 'https://api.example.com/users')
       ->withHeader('Content-Type', 'application/json')
       ->withBody($streamFactory->createStream($payload));

   /** @var ClientInterface $client */
   $client = $container->get(ClientInterface::class);
   $response = $client->sendRequest($request);

Error Handling
--------------

PSR-18 distinguishes between transport problems and normal HTTP responses:

- network failures and invalid requests raise ``Psr\Http\Client\ClientExceptionInterface``
  implementations;
- HTTP responses such as 404 and 500 do not raise exceptions on their own;
- your code should inspect the status code when a non-success response matters.

.. code-block:: php

   use Psr\Http\Client\ClientExceptionInterface;

   try {
       $response = $client->sendRequest($request);
   } catch (ClientExceptionInterface $exception) {
       // The request could not be sent or the response could not be created.
   }

   if ($response->getStatusCode() >= 400) {
       // Handle the application-level error response here.
   }

Gotcha For New Users
--------------------

``Symfony\Component\HttpClient\Psr18Client`` also implements some PSR-17 and URI
factory interfaces internally, but this package only registers it under
``Psr\Http\Client\ClientInterface``. Keep using dedicated factory services from
your HTTP factory package instead of relying on those extra interfaces being
exposed automatically.
