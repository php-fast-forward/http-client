🚀 FastForward HTTP Client

[![PHP Version](https://img.shields.io/badge/PHP-^8.1-8892BF?logo=php)](https://www.php.net/)
[![License](https://img.shields.io/github/license/php-fast-forward/http-client)](https://opensource.org/licenses/MIT)
[![CI](https://github.com/php-fast-forward/http-client/actions/workflows/ci.yml/badge.svg)](https://github.com/php-fast-forward/http-client/actions)

A [PSR-11](https://www.php-fig.org/psr/psr-11/) compatible service provider that registers a fully functional set of [PSR-18](https://www.php-fig.org/psr/psr-18/)  HTTP client using Symfony HttpClient and Psr18Client.

Designed to work out of the box with the [`php-fast-forward/container`](https://github.com/php-fast-forward/container) autowiring system.

---

## 📦 Installation

```bash
composer require fast-forward/http-client
```

## ✅ Features
- Registers the default _Symfony HttpClient_ using `HttpClient::create()
- Registers the PSR-18 _Psr18Client_ with its dependencies injected
- Provides aliases for:
  - _Psr\Http\Client\ClientInterface_
  - _Symfony\Component\HttpClient\HttpClient_

## 🛠️ Usage

If you’re using `fast-forward/container`:
```php
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
```

## 🔧 Services Registered

The following services will be automatically registered in your container when using `HttpClientServiceProvider`:

| Service Interface                         | Implementation Source                      |
|-------------------------------------------|--------------------------------------------|
| `Symfony\Component\HttpClient\HttpClient` | Registered via `MethodFactory::create()`   |
| `Psr\Http\Client\ClientInterface`         | `Symfony\Component\HttpClient\Psr18Client` |

---

## 📂 License

This package is open-source software licensed under the [MIT License](https://opensource.org/licenses/MIT).

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!  
Feel free to open a [GitHub Issue](https://github.com/php-fast-forward/http-client/issues) or submit a Pull Request.
