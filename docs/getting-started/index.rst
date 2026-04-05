Getting Started
===============

This section is written for first-time users of the package. It explains what
you need to install, why PSR-17 factories matter, and how to run one complete
request through the container without guessing which extra services must exist.

By the end of this section, you should understand:

- which Composer command matches your setup;
- why this package is usually paired with ``fast-forward/http-factory``;
- how to register the provider in a FastForward container;
- how to create a PSR-7 request and send it with the registered PSR-18 client.

.. toctree::
   :maxdepth: 2

   installation
   quickstart
