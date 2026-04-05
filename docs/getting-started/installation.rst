Installation
============

Install the package with Composer:

.. code-block:: bash

   composer require fast-forward/http-client

That command installs the service provider itself. Whether it is enough for your
project depends on what your container already knows how to build.

Recommended Installation Paths
------------------------------

.. list-table::
   :header-rows: 1

   * - Situation
     - Composer command
     - When to choose it
   * - You already register PSR-17 factories elsewhere
     - ``composer require fast-forward/http-client``
     - Use this when your container already provides
       ``ResponseFactoryInterface`` and ``StreamFactoryInterface``.
   * - You want explicit FastForward PSR-17 and PSR-18 providers
     - ``composer require fast-forward/http-client fast-forward/http-factory``
     - This is the clearest setup when you want separate providers and a
       predictable service graph.
   * - You want the easiest beginner setup
     - ``composer require fast-forward/http``
     - Use this when you want one metapackage that bundles the HTTP client and
       matching HTTP factory provider together.

Requirements
------------

.. list-table::
   :header-rows: 1

   * - Dependency
     - Constraint
     - Why it matters
   * - PHP
     - ``^8.3``
     - The package is written for PHP 8.3 and newer.
   * - ``fast-forward/container``
     - ``^1.4``
     - Provides the container and service-provider integration used throughout
       the examples in this documentation.
   * - ``psr/http-client``
     - ``^1.0``
     - Supplies the PSR-18 client contract exposed by the package.
   * - ``psr/http-factory``
     - ``^1.1``
     - Supplies the PSR-17 factory interfaces consumed by ``Psr18Client``.
   * - ``symfony/http-client``
     - ``^7.3``
     - Provides the transport implementation and the ``Psr18Client`` adapter.

.. important::

   ``psr/http-factory`` only installs interfaces. The actual
   ``ResponseFactoryInterface`` and ``StreamFactoryInterface`` services still
   have to come from your container. The recommended FastForward source is
   ``fast-forward/http-factory``.

What This Package Registers
---------------------------

``HttpClientServiceProvider`` publishes two service IDs:

- ``Symfony\Component\HttpClient\HttpClient`` via ``HttpClient::create()``;
- ``Psr\Http\Client\ClientInterface`` via ``Symfony\Component\HttpClient\Psr18Client``.

The second one depends on these container services already existing:

- ``Psr\Http\Message\ResponseFactoryInterface``
- ``Psr\Http\Message\StreamFactoryInterface``

If those services are missing, resolving ``ClientInterface`` will fail even
though the package itself is installed correctly.

Next Step
---------

Continue with :doc:`quickstart` for a complete working example that wires both
the HTTP factory provider and the HTTP client provider together.
