Compatibility
=============

This page summarizes the version and contract expectations visible from the
current repository state.

Version Matrix
--------------

.. list-table::
   :header-rows: 1

   * - Component
     - Constraint in this repository
     - Notes
   * - PHP
     - ``^8.3``
     - All examples and package code target PHP 8.3 and newer.
   * - ``fast-forward/container``
     - ``^1.4``
     - Required directly by this package.
   * - ``psr/http-client``
     - ``^1.0``
     - Defines the PSR-18 client contract.
   * - ``psr/http-factory``
     - ``^1.1``
     - Supplies the PSR-17 interfaces expected by ``Psr18Client``.
   * - ``symfony/http-client``
     - ``^7.3``
     - Provides the transport layer and PSR-18 adapter.

Contract Compatibility
----------------------

.. list-table::
   :header-rows: 1

   * - Contract
     - How this package relates to it
   * - PSR-11
     - Users typically consume the final registrations through a PSR-11
       container.
   * - ``Interop\Container\ServiceProviderInterface``
     - ``HttpClientServiceProvider`` implements this interface directly.
   * - PSR-18
     - The package exposes ``Psr\Http\Client\ClientInterface``.
   * - PSR-17
     - The package consumes PSR-17 response and stream factories from the
       container but does not register them itself.

Recommended Package Combinations
--------------------------------

.. list-table::
   :header-rows: 1

   * - Goal
     - Suggested packages
   * - Use this package with your own PSR-17 implementation
     - ``fast-forward/http-client`` plus your chosen PSR-17 registrations
   * - Full FastForward PSR-17 and PSR-18 setup
     - ``fast-forward/http-client`` plus ``fast-forward/http-factory``
   * - Simplest all-in-one HTTP onboarding
     - ``fast-forward/http``

Practical Note
--------------

When you combine this package with ``fast-forward/http-factory``, Composer will
resolve a ``fast-forward/container`` version compatible with both packages. In
the current repository state, the companion ``fast-forward/http-factory`` package
targets ``fast-forward/container`` ``^1.5``, so combined installs naturally move
toward that shared version range.
