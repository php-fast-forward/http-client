Dependencies
============

This package is intentionally small, so understanding its dependencies is the
best way to understand the package itself.

Direct Runtime Dependencies
---------------------------

.. list-table::
   :header-rows: 1

   * - Package
     - Kind
     - Why it exists here
   * - `PHP <https://www.php.net/>`_
     - Runtime
     - The package targets PHP 8.3 and newer.
   * - `fast-forward/container <https://packagist.org/packages/fast-forward/container>`_
     - FastForward runtime dependency
     - Supplies container integration and the factory helper classes used by the
       provider.
   * - `psr/http-client <https://packagist.org/packages/psr/http-client>`_
     - Standard interface package
     - Defines ``Psr\Http\Client\ClientInterface``.
   * - `psr/http-factory <https://packagist.org/packages/psr/http-factory>`_
     - Standard interface package
     - Defines the PSR-17 factory interfaces consumed by ``Psr18Client``.
   * - `symfony/http-client <https://packagist.org/packages/symfony/http-client>`_
     - Transport implementation
     - Provides ``HttpClient`` and ``Psr18Client``.

Recommended Companion Packages
------------------------------

These packages are not required by this repository directly, but they are the
most common companions in real FastForward applications:

.. list-table::
   :header-rows: 1

   * - Package
     - Why you might add it
   * - `fast-forward/http-factory <https://packagist.org/packages/fast-forward/http-factory>`_
     - Registers the PSR-17 factory services required to build
       ``Psr\Http\Client\ClientInterface`` successfully.
   * - `fast-forward/http <https://packagist.org/packages/fast-forward/http>`_
     - Bundles the FastForward HTTP factory and HTTP client providers for the
       simplest onboarding path.
   * - `fast-forward/http-message <https://packagist.org/packages/fast-forward/http-message>`_
     - Provides FastForward HTTP message utilities used by the factory layer in
       the broader FastForward HTTP stack.
   * - `nyholm/psr7-server <https://packagist.org/packages/nyholm/psr7-server>`_
     - Used by ``fast-forward/http-factory`` to provide concrete PSR-17 and
       server-request support.

Relevant Standards
------------------

- `PSR-18 <https://www.php-fig.org/psr/psr-18/>`_ defines the client contract
  exposed by this package.
- `PSR-17 <https://www.php-fig.org/psr/psr-17/>`_ defines the factory
  interfaces that the registered ``Psr18Client`` expects from the container.
- `PSR-11 <https://www.php-fig.org/psr/psr-11/>`_ defines the container
  contract most users interact with after registration.

Runtime Note About Symfony
--------------------------

Symfony's ``HttpClient::create()`` chooses the best available client at runtime.
Depending on your environment, that may be a Curl, Amp, or Native client. This
package does not force one transport implementation; it delegates that decision
to Symfony.
