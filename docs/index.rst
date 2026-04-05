FastForward HTTP Client
=======================

FastForward HTTP Client is a focused integration package for projects that want
to resolve a PSR-18 HTTP client from a FastForward-compatible container. It
connects Symfony HttpClient to PSR contracts so application code can depend on
``Psr\Http\Client\ClientInterface`` while still keeping a direct path to
Symfony's native client when needed.

If you are new to the package, start with :doc:`getting-started/installation`
and :doc:`getting-started/quickstart`. If you want the shortest path to a full
FastForward HTTP stack, consider the
`fast-forward/http <https://packagist.org/packages/fast-forward/http>`_
metapackage, which bundles this package together with the matching FastForward
HTTP factory provider.

.. important::

   This package does not register PSR-17 factories on its own. To resolve
   ``Psr\Http\Client\ClientInterface``, your container must already provide
   ``Psr\Http\Message\ResponseFactoryInterface`` and
   ``Psr\Http\Message\StreamFactoryInterface``. In a FastForward application,
   the usual solution is to register
   ``FastForward\Http\Message\Factory\ServiceProvider\HttpMessageFactoryServiceProvider``
   from ``fast-forward/http-factory`` or to install ``fast-forward/http``.

Useful Links
------------

- `GitHub Repository <https://github.com/php-fast-forward/http-client>`_
- `Packagist Package <https://packagist.org/packages/fast-forward/http-client>`_
- `Issue Tracker <https://github.com/php-fast-forward/http-client/issues>`_
- `Coverage Report <https://php-fast-forward.github.io/http-client/coverage/index.html>`_
- `Symfony HttpClient Documentation <https://symfony.com/doc/current/http_client.html>`_

What You Will Find Here
-----------------------

- a beginner-first setup guide for ``fast-forward/http-client`` on its own and
  in combination with ``fast-forward/http-factory``;
- an explanation of the two registered service IDs, what they resolve to, and
  when to use each one;
- practical examples for PSR-18 requests, direct Symfony HttpClient usage, and
  common override patterns;
- API notes for ``HttpClientServiceProvider`` and the external classes it
  collaborates with;
- compatibility and troubleshooting notes for first-time users.

.. toctree::
   :maxdepth: 2
   :caption: Contents:

   getting-started/index
   usage/index
   advanced/index
   api/index
   links/index
   faq
   compatibility
