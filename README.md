### Scaleflex API Connector
[![Latest Stable Version](http://poser.pugx.org/drive/scaleflex-api-connector/v)](https://packagist.org/packages/drive/scaleflex-api-connector) [![PHP Version](http://poser.pugx.org/drive/scaleflex-api-connector/require/php)](https://packagist.org/packages/drive/scaleflex-api-connector) [![Downloads](http://poser.pugx.org/drive/scaleflex-api-connector/downloads)](https://packagist.org/packages/drive/scaleflex-api-connector) [![Tests](https://github.com/caradvice/scaleflex-api-connector/actions/workflows/run-tests.yml/badge.svg)](https://github.com/caradvice/scaleflex-api-connector/actions/workflows/run-tests.yml) [![codecov](https://codecov.io/gh/caradvice/scaleflex-api-connector/graph/badge.svg?token=TBDYXHENGN)](https://codecov.io/gh/caradvice/scaleflex-api-connector)

#### Description:

The Scaleflex PHP API Connector is a powerful tool designed to seamlessly integrate your PHP applications with Filerobot, a comprehensive digital asset management platform offered by Scaleflex. With this connector, developers can effortlessly leverage Filerobot's robust features to manage, optimize, and deliver digital assets within their PHP projects.

#### Requirements:

- PHP ^8.2
- composer
- Laravel (or `illuminate/support` and `illuminate/config`) 10.48+, 11, 12 or 13
- Guzzle ^7.8.1 or ^8, PSR-7 ^2.6 or ^3

#### Usage:

- Add package to your project
  ```bash
    composer require caradvice/scaleflex-api-connector
    ```
- Copy configuration file to your project
  ```bash
    php artisan vendor:publish --provider="Drive\ScaleflexApiConnector\ScaleflexServiceProvider" --tag="config"`
  ```
- Set required environment variable values
  - `SCALEFLEX_CONTAINER_ID` - Container ID (can be found in Scaleflex hub)
  - `SCALEFLEX_API_KEY` - API key for Scaleflex API
- Optional environment variables
  - `SCALEFLEX_CONNECT_TIMEOUT` - seconds to wait for a connection (default `5`, `0` disables)
  - `SCALEFLEX_TIMEOUT` - seconds to wait for the whole request, including uploads (default `30`, `0` disables)

#### Endpoint Coverage:

- [File Details](https://developers.scaleflex.com/#5a97d86a-0f37-460a-b87d-502269ed406d)
- [File Search](https://developers.scaleflex.com/#43bfc74c-fd29-46be-83bf-b1e7bc8556e2)
- [Multipart File Upload](https://developers.scaleflex.com/#ed2b17ed-5131-4b5d-a9c2-c40d74154f32)
- [Base64 File Upload](https://developers.scaleflex.com/#75975094-04fa-402d-8125-ade2618881b9)
- [Remote File Upload](https://developers.scaleflex.com/#e3b464d2-c176-418b-890c-acaaa369b521)

#### Testing:

Test suite is available in the package. To run tests, execute the following command:

##### Feature Tests:
```bash
composer test
```

##### Code Coverage:
```bash
composer coverage
```
