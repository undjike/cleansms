<p align="center"><img src="https://my.cleansms.biz/assets/images/logo.png" alt="logo"></p>

<p align="center">
<a href="https://packagist.org/packages/undjike/cleansms"><img src="https://poser.pugx.org/undjike/cleansms/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/undjike/cleansms"><img src="https://poser.pugx.org/undjike/cleansms/license.svg" alt="License"></a>
<a href="https://packagist.org/packages/undjike/cleansms"><img src="https://poser.pugx.org/undjike/cleansms/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/undjike/cleansms"><img src="https://poser.pugx.org/undjike/cleansms/dependents.svg" alt="Dependents"></a>
</p>

## Introduction

This PHP package enables you to easily send SMS using CleanSMS Service.
It has an elegant syntax, and it is very easy to install and use.

Just few steps, and it's ready.

Create an account on <a href="https://www.cleansms.biz/">CleanSMS</a>, configure it and generate API Key.
Then, let's start.

## Installation

This package can be installed via composer. Just type :

```bash
composer require undjike/plan-subscription-system
```

This will download everything needed for the package to work in your project.

## Usage

After installation, you can send SMS.

```php
use Undjike\CleanSmsPhp\CleanSms;

CleanSms::create()
     ->apiKey('SMS_API_KEY')
     ->email('YOUR_CLEANSMS_EMAIL')
     ->sendSms(
         'MESSAGE_TO_SEND',
         'RECEIVER_PHONE_NUMBER (Ex: +237*****, +245*****, ...)'
     );

/**
    Return "1" if the message is successfully sent, "0" if not.
    The response can be a JSON in some cases like 'no balance'.
*/
```

**Note**: `RECEIVER_PHONE_NUMBER` can be an **_array_** of valid phone numbers, or a **_string_** containing numbers separated by ` ,`.


You can query you account balance using this package.

```php
use Undjike\CleanSmsPhp\CleanSms;

CleanSms::create()
     ->apiKey('SMS_API_KEY')
     ->email('YOUR_CLEANSMS_EMAIL')
     ->getCredit();

/**
    Return the number of SMS remaining in your account. (Ex: "3")
*/
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.