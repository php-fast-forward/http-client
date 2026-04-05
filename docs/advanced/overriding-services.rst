Overriding Services
===================

The provider itself does not expose custom configuration knobs. Instead, you
customize behavior by composing your container so a different service wins for a
given ID.

Override The Symfony Transport
------------------------------

If you want custom default options such as timeouts, headers, or a base URI,
register your own ``HttpClient::class`` service before
``HttpClientServiceProvider`` when you use the ``container()`` helper.

.. code-block:: php

   use FastForward\Container\ServiceProvider\ArrayServiceProvider;
   use FastForward\Http\Client\ServiceProvider\HttpClientServiceProvider;
   use FastForward\Http\Message\Factory\ServiceProvider\HttpMessageFactoryServiceProvider;
   use Symfony\Component\HttpClient\HttpClient;

   use function FastForward\Container\container;

   $overrideProvider = new ArrayServiceProvider([
       HttpClient::class => static fn() => HttpClient::createForBaseUri(
           'https://api.example.com',
           [
               'headers' => [
                   'Accept' => 'application/json',
               ],
               'timeout' => 5.0,
           ],
       ),
   ]);

   $container = container(
       $overrideProvider,
       new HttpMessageFactoryServiceProvider(),
       new HttpClientServiceProvider(),
   );

In this composition, ``ClientInterface`` will automatically pick up your custom
transport because ``Psr18Client`` asks the container for ``HttpClient::class``.

Replace The PSR-18 Registration Entirely
----------------------------------------

If you want full control over how ``ClientInterface`` is built, override that ID
directly:

.. code-block:: php

   use FastForward\Container\ServiceProvider\ArrayServiceProvider;
   use FastForward\Http\Client\ServiceProvider\HttpClientServiceProvider;
   use FastForward\Http\Message\Factory\ServiceProvider\HttpMessageFactoryServiceProvider;
   use Psr\Container\ContainerInterface as PsrContainerInterface;
   use Psr\Http\Client\ClientInterface;
   use Psr\Http\Message\ResponseFactoryInterface;
   use Psr\Http\Message\StreamFactoryInterface;
   use Symfony\Component\HttpClient\HttpClient;
   use Symfony\Component\HttpClient\Psr18Client;

   use function FastForward\Container\container;

   $customClientProvider = new ArrayServiceProvider([
       ClientInterface::class => static fn(PsrContainerInterface $container): ClientInterface => new Psr18Client(
           HttpClient::create([
               'timeout' => 2.5,
           ]),
           $container->get(ResponseFactoryInterface::class),
           $container->get(StreamFactoryInterface::class),
       ),
   ]);

   $container = container(
       $customClientProvider,
       new HttpMessageFactoryServiceProvider(),
       new HttpClientServiceProvider(),
   );

Order Rules Matter
------------------

FastForward offers two different composition styles, and the override rule is
different in each one:

.. list-table::
   :header-rows: 1

   * - Composition style
     - Override rule
   * - ``container($override, $defaults)``
     - Earlier sources win.
   * - ``new AggregateServiceProvider($defaults, $override)``
     - Later providers overwrite earlier factory keys.

Pick the rule that matches how you normally structure application configuration.

Why ``getExtensions()`` Is Empty
--------------------------------

``HttpClientServiceProvider`` returns an empty extension map. That is
intentional: this package publishes a small, explicit factory set and leaves
decoration or replacement decisions to the container composition layer.
