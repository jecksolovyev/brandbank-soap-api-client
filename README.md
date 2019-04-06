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

## First thing comes first
```php
require_once __DIR__ . '/vendor/autoload.php';

// initiate the API
$api = new BrandbankSOAPAPIClient\BrandbankSOAPAPIClient(
    new BrandbankSOAPAPIClient\Authenticator\HeaderGuidAuthenticator('XXXX')
);
```

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
$response = $api->callGetUnsentProductData();
$message = $response->getUnsentProductDataResult()->getMessage(); // get Message object
```

## Call acknowledge after feed successfully processed
```php
// assuming you've previously called $message = $api->callGetUnsentProductData()->getUnsentProductDataResult()->getMessage()
$api->callAcknowledgeMessage($message->getId());
```

## License
This component is licensed under the MIT License - see the `LICENSE` file for details