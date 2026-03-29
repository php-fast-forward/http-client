Use Cases
=========

Here are some common use cases for the FastForward HTTP Client:

**1. Sending a PSR-7 Request:**

.. code-block:: php

   $client = $container->get(Psr\Http\Client\ClientInterface::class);
   $response = $client->sendRequest($psr7Request);

**2. Using the Symfony HttpClient Directly:**

.. code-block:: php

   $httpClient = $container->get(Symfony\Component\HttpClient\HttpClient::class);
   $response = $httpClient->request('GET', 'https://example.com');

**3. Dependency Injection:**

You can type-hint ``Psr\Http\Client\ClientInterface`` in your services to receive the PSR-18 client automatically when using the FastForward container.

.. code-block:: php

   class MyService {
       public function __construct(Psr\Http\Client\ClientInterface $client) {
           $this->client = $client;
       }
   }
