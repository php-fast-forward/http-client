Getting Services
================

The FastForward HTTP Client registers the following services in your container:

+-----------------------------------------------+-----------------------------------------------+
| Service Interface                            | Implementation Source                         |
+===============================================+===============================================+
| ``Symfony\Component\HttpClient\HttpClient``  | Registered via ``MethodFactory::create()``    |
+-----------------------------------------------+-----------------------------------------------+
| ``Psr\Http\Client\ClientInterface``          | ``Symfony\Component\HttpClient\Psr18Client`` |
+-----------------------------------------------+-----------------------------------------------+

You can retrieve these services from the container as follows:

.. code-block:: php

   $httpClient = $container->get(Symfony\Component\HttpClient\HttpClient::class);
   $psr18Client = $container->get(Psr\Http\Client\ClientInterface::class);
