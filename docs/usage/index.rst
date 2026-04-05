Usage
=====

The package exposes only two service IDs, but they serve different audiences:

- use ``Psr\Http\Client\ClientInterface`` when your application should stay on
  the PSR-18 contract;
- use ``Symfony\Component\HttpClient\HttpClient`` when you intentionally want
  Symfony-specific features such as ``request()`` and ``withOptions()``.

The pages below explain how to retrieve those services, how they relate to
PSR-17 factories, and which path is usually best for new code.

.. toctree::
   :maxdepth: 2

   getting-services
   psr-18-client
   symfony-http-client
   use-cases
