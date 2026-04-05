Using The Native Symfony Client
===============================

The provider also publishes a direct entry point to Symfony HttpClient. This is
useful when you want Symfony-specific options or response helpers that are not
part of PSR-18.

Resolving The Native Client
---------------------------

The service ID is ``Symfony\Component\HttpClient\HttpClient``, but the resolved
object is a runtime-selected ``Symfony\Contracts\HttpClient\HttpClientInterface``
implementation.

.. code-block:: php

   use Symfony\Component\HttpClient\HttpClient;
   use Symfony\Contracts\HttpClient\HttpClientInterface;

   /** @var HttpClientInterface $symfonyClient */
   $symfonyClient = $container->get(HttpClient::class);

   $response = $symfonyClient->request('GET', 'https://example.com', [
       'headers' => [
           'Accept' => 'text/html',
       ],
       'timeout' => 10.0,
   ]);

   $statusCode = $response->getStatusCode();
   $content = $response->getContent(false);

Creating A Scoped Client
------------------------

If you frequently talk to the same API, clone the resolved client with options:

.. code-block:: php

   use Symfony\Component\HttpClient\HttpClient;
   use Symfony\Contracts\HttpClient\HttpClientInterface;

   /** @var HttpClientInterface $symfonyClient */
   $symfonyClient = $container->get(HttpClient::class);

   $apiClient = $symfonyClient->withOptions([
       'base_uri' => 'https://api.example.com',
       'headers' => [
           'Accept' => 'application/json',
           'Authorization' => 'Bearer '.$token,
       ],
       'timeout' => 5.0,
   ]);

   $response = $apiClient->request('GET', '/projects');
   $data = $response->toArray(false);

When This Path Fits Best
------------------------

Use the native Symfony client when:

- you want Symfony's ``request()`` API instead of PSR-18's ``sendRequest()``;
- you need response helpers such as ``toArray(false)`` or streaming tools;
- you want to work with Symfony option arrays directly.

Prefer :doc:`psr-18-client` when your own service only needs the standard
client contract.

.. note::

   Depending on your runtime, Symfony may return a Curl, Amp, or Native client
   implementation behind the scenes. That is expected behavior from
   ``HttpClient::create()`` and is one reason the service ID should be treated
   as a lookup key rather than as the precise runtime class.
