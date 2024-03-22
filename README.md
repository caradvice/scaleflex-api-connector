### Description:

Introducing our PHP API Connector for Scaleflex, the digital asset management platform designed to streamline media workflows. Our connector offers seamless integration with Scaleflex, enabling developers to effortlessly interact with Scaleflex's robust features and functionalities directly from their PHP applications.

With intuitive methods and comprehensive documentation, our API connector empowers developers to effortlessly manage digital assets, streamline media operations, and enhance user experiences within their PHP projects. Whether you're building a content-rich website, a dynamic media application, or a sophisticated digital platform, our PHP API Connector for Scaleflex provides the essential bridge for leveraging Scaleflex's powerful capabilities with ease.

### Requirements:

- PHP ^8.1
- composer
- Laravel ^10.0

### Usage:

- Add package to your project
  ```bash
    composer require drive/scaleflex-api-connector`
    ```
- Copy configuration file to your project
  ```bash
    php artisan vendor:publish --provider="Drive\ScaleflexApiConnector\ScaleflexServiceProvider" --tag="config"`
  ```
- Set required environment variable values
  - `SCALEFLEX_CONTAINER_ID` - Container ID (can be found in Scaleflex hub)
  - `SCALEFLEX_API_KEY` - API key for Scaleflex API

### Endpoint Coverage:

- [Remote File Upload](https://developers.scaleflex.com/#e3b464d2-c176-418b-890c-acaaa369b521)

### Testing:

Test suite is available in the package. To run tests, execute the following command:

#### Feature Tests:
```bash
composer run test
```

#### Code Coverage:
```bash
composer run coverage
```
