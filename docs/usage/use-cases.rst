Use Cases
=========

This page focuses on practical scenarios that new users usually need before they
care about customization details.

Injecting A Client Into An Application Service
----------------------------------------------

The most common pattern is to inject ``ClientInterface`` together with a request
factory into a small gateway class:

.. code-block:: php

   use Psr\Http\Client\ClientInterface;
   use Psr\Http\Message\RequestFactoryInterface;

   final class StatusPageClient
   {
       public function __construct(
           private ClientInterface $client,
           private RequestFactoryInterface $requests,
       ) {
       }

       public function isHealthy(): bool
       {
           $request = $this->requests->createRequest(
               'GET',
               'https://www.githubstatus.com/api/v2/status.json',
           );

           $response = $this->client->sendRequest($request);

           return 200 === $response->getStatusCode();
       }
   }

This approach keeps your class portable and easy to test because it depends only
on PSR interfaces.

Using The Package In A Fresh FastForward Project
------------------------------------------------

If you are starting from scratch, register both the HTTP factory provider and
the HTTP client provider:

.. code-block:: php

   use FastForward\Http\Client\ServiceProvider\HttpClientServiceProvider;
   use FastForward\Http\Message\Factory\ServiceProvider\HttpMessageFactoryServiceProvider;

   use function FastForward\Container\container;

   $container = container(
       new HttpMessageFactoryServiceProvider(),
       new HttpClientServiceProvider(),
   );

This is the clearest setup because every dependency is visible in one place.

Using The Metapackage For Faster Onboarding
------------------------------------------

If the goal is simply "give me the full FastForward HTTP stack", install
``fast-forward/http`` and register ``FastForward\Http\ServiceProvider\HttpServiceProvider``.
That metapackage aggregates the matching factory and client providers so new
projects can start with one provider instead of two.

Choosing The Right Shape
------------------------

.. list-table::
   :header-rows: 1

   * - Need
     - Recommended shape
   * - Standard client abstraction for app code
     - Inject ``Psr\Http\Client\ClientInterface``.
   * - Symfony-specific request options or response helpers
     - Resolve ``Symfony\Component\HttpClient\HttpClient`` and work with the
       returned ``HttpClientInterface`` implementation.
   * - One-step onboarding for a new project
     - Install ``fast-forward/http``.
   * - Fine-grained control over providers and overrides
     - Register ``HttpMessageFactoryServiceProvider`` and
       ``HttpClientServiceProvider`` explicitly.

Next Step
---------

Once the basic scenarios above are clear, continue with
:doc:`../advanced/integration` and :doc:`../advanced/overriding-services` for
container composition and customization details.
