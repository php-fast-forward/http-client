Quickstart
==========

This quickstart demonstrates how to use the FastForward HTTP Client with the FastForward container:

.. code-block:: php

   use FastForward\Container\container;
   use FastForward\Config\ArrayConfig;
   use FastForward\Container\ContainerInterface;

   $config = new ArrayConfig([
       ContainerInterface::class => [
           // Reference the service provider by class name
           FastForward\Http\Client\ServiceProvider\HttpClientServiceProvider::class,
       ],
   ]);

   $container = container($config);

   $client = $container->get(Psr\Http\Client\ClientInterface::class);
   $response = $client->sendRequest($yourPsr7Request);

You can now use the PSR-18 HTTP client in your application!