# Maxicash PHP

[![Latest Stable Version](https://poser.pugx.org/ngandu-dev/maxicash/version)](https://packagist.org/packages/ngandu-dev/maxicash)
[![Total Downloads](https://poser.pugx.org/ngandu-dev/maxicash/downloads)](https://packagist.org/packages/ngandu-dev/maxicash)
[![Quality](https://github.com/ngandu-dev/maxicash-php/actions/workflows/quality.yml/badge.svg)](https://github.com/ngandu-dev/maxicash-php/actions/workflows/quality.yml)
[![Tests](https://github.com/ngandu-dev/maxicash-php/actions/workflows/test.yml/badge.svg)](https://github.com/ngandu-dev/maxicash-php/actions/workflows/test.yml)
[![License](https://poser.pugx.org/ngandu-dev/maxicash/license)](https://packagist.org/packages/ngandu-dev/maxicash)


The MaxiCash Integration Platform enables Merchants to integrate with the MaxiCash platform in order to receive payments through their mobile apps or their websites. The API uses JSON to interact with .Net client or open source platforms like PHP. see more at [Maxicash Documentation](https://developer.maxicashapp.com/Default)

## Features

- Query-string payment URLs
- Donation URLs for NGOs
- Sandbox and live environments

## Requirements

- PHP 8.4 or later
- Composer 2

## Installation
You can use the PHP client by installing the Composer package and adding it to your application’s dependencies:

```bash
composer require ngandu-dev/maxicash
```
## Usage 
The MaxiCash Gateway enables the Merchant to Collect Payment into their MaxiCash account using multiple payment channels such as Credit Cards, MaxiCash, Paypal, Mobile Money and Mobile Banking.

### Authentication
* **Step 1**. Download the MaxiCash Mobile App and signup...
* **Step 2**. Contact us to upgrade your account to a Merchant Account info@maxicashapp.com
You will receive a Merchant Form to complete in order to provide your business details and preferred Cash out Wallet or Banking Details.
* **Step 3**. Once the paperwork is completed, you will be issued with Live and Sandbox Accounts (MerchantID and MerchantPassword)


```php
use Ngandu\Maxicash\Client as Maxicash;
use Ngandu\Maxicash\Credential;
use Ngandu\Maxicash\PaymentEntry;
use Ngandu\Maxicash\Environment;

$maxicash = new Maxicash(
    credential: new Credential('marchand_id', 'marchand_password'),
    environment: Environment::SANDBOX // use `Environment::LIVE` for live
);
```

### Create a Payment Entry
```php
$entry = new PaymentEntry(
    credential: $maxicash->credential,
    amount: intval(47.50 * 100), // amount in cents
    reference: "this text will be shown on maxicash payment page",
    acceptUrl: "your_website_accept_url",
    declineUrl: "your_website_decline_url",
);
```
> **Note**: we hightly recommand your `accept` and `decline` urls to be unique for each transaction, thus users will not be able to reuse them to validate other transactions, on your side save the transaction with a unique generated token (a.k.a transaction reference) and use it as parameter to your accept and decline urls, don't use it for the `PaymentEntry->reference`; once the user is redirected to your accept url, validate the token and grant access to the paid resource (with your own business logic). 


### Redirect to Maxicash Gateway
Redirect your user to the maxicash gateway to continue the payment process

> **Note** : If you're using Turbo Drive in your Symfony application, disable it on payment links in your twig templates

```php
$url = $maxicash->queryStringURLPayment($entry);
```
> **Note** : we highly recommand to do a `server side` redirection, this url can be modified and leak your maxicash credentials when displayed to your user in any manner (eg: a link, button or form) ! you can use the `header("Location: $url")` fonction in vanilla PHP or return a `RedirectResponse($url)` in your controller when using Symfony or Laravel frameworks`

### Donate Button for NGOs
Once you sign up as an NGO Merchant

```php
$donationUrl = $maxicash->donationUrl()
```

## Development

```bash
composer install
composer format
composer quality
```

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md) before opening an issue or pull request.

## Security

Report vulnerabilities privately as described in [SECURITY.md](SECURITY.md).

## License

Released under the [MIT License](LICENSE).

## Contributors

<a href="https://github.com/ngandu-dev/maxicash-php/graphs/contributors" title="Show all contributors">
  <img src="https://contrib.rocks/image?repo=ngandu-dev/maxicash-php" alt="Contributors" />
</a>
