# Brandbank SOAP API Client

[![Latest Stable Version](https://img.shields.io/packagist/v/jecksolovyev/brandbank-soap-api-client.svg)](https://packagist.org/packages/jecksolovyev/brandbank-soap-api-client)

Please see examples below. 

## Installation
Install the latest version with

```bash
composer require jecksolovyev/brandbank-soap-api-client
```

## Requirements
Component works with PHP 7.1 or above.

## Submitting bugs and feature requests
Bugs and feature request are tracked on GitHub

## How to set up your products list 
```php
$items = ['3272770099486'];
$coverageReport = new RetailerFeedbackReport(new Message(new DateTime()));

foreach ($items as $item) {
    $coverageReport->addItem(new Item($item));
}

if ($api->callSupplyCoverageReport($coverageReport)->isSuccess()) {
    // everything is good, do something meaningful
}
```

## How to read new/updated product data from API

```php
require_once __DIR__ . '/vendor/autoload.php';

$api = new BrandbankSOAPAPIClient\BrandbankSOAPAPIClient(
    new BrandbankSOAPAPIClient\Authenticator\HeaderGuidAuthenticator('XXXX')
);

$r = $api->callGetUnsentProductData();
print_r($api->getLastResponseXml()); // see responce XML
print_r($r->getUnsentProductDataResult()->getMessage()); // get Message object
```

## License
This component is licensed under the MIT License - see the `LICENSE` file for details