# ID Analyzer PHP SDK — Identity Verification, KYC, Document & Biometric API

[![Packagist version](https://img.shields.io/packagist/v/idanalyzer/id-analyzer-v2-php-sdk.svg)](https://packagist.org/packages/idanalyzer/id-analyzer-v2-php-sdk)
[![PHP version](https://img.shields.io/packagist/php-v/idanalyzer/id-analyzer-v2-php-sdk.svg)](https://packagist.org/packages/idanalyzer/id-analyzer-v2-php-sdk)
[![license](https://img.shields.io/packagist/l/idanalyzer/id-analyzer-v2-php-sdk.svg)](LICENSE)

Official PHP client library for the **[ID Analyzer](https://www.idanalyzer.com) API v2** — automate identity document verification, KYC onboarding and biometric checks in minutes.

Scan and authenticate **passports, driver's licenses, ID cards, visas and residence permits from 190+ countries**, run **1:1 face match and liveness detection**, screen against **AML / PEP / sanctions** watchlists, and onboard users remotely with **DocuPass** hosted verification & e-signature.

- 🌐 **Website:** [www.idanalyzer.com](https://www.idanalyzer.com)
- 📚 **Developer docs & API reference:** [developer.idanalyzer.com](https://developer.idanalyzer.com/help)
- 🔑 **Get your API key:** [portal2.idanalyzer.com](https://portal2.idanalyzer.com)
- 💬 **Support:** support@idanalyzer.com

## Features

- **Document OCR & authentication** — passport, driver's license, ID card, visa & residence-permit recognition from 190+ countries, including MRZ and PDF417 / AAMVA barcode parsing.
- **Biometric verification** — 1:1 face match and liveness / presentation-attack detection.
- **AML screening** — PEP, sanctions, watchlist and adverse-media checks.
- **DocuPass** — hosted, no-code remote identity verification, KYC/AML onboarding and legally-binding e-signature.
- **KYC profiles, transaction vault, contract generation and webhooks.**
- **US & EU data-residency regions.**

> ⚠️ Never embed your API key in client-side apps (mobile, browser JS). Call the API from your server.

## Installation

```bash
composer require idanalyzer/id-analyzer-v2-php-sdk
```

Requires PHP 7.4+ (Guzzle 7, PSR-4).

## Authentication & region

Pass the zone as the second constructor argument — `"us"` (default, `https://api2.idanalyzer.com`) or `"eu"` (`https://api2-eu.idanalyzer.com`):

```php
$client = new IDAnalyzer2\Client("YOUR_API_KEY", "eu");
```

## Quick start

The SDK uses a request object per endpoint: set its public properties, then call `$client->Do($request)`, which returns `[$result, $err]`.

```php
require_once __DIR__.'/vendor/autoload.php';

use IDAnalyzer2\Client;
use IDAnalyzer2\Api\Scanner\QuickScan;

$client = new Client("YOUR_API_KEY");

$scan = new QuickScan();
$scan->document = base64_encode(file_get_contents('id_front.jpg'));
$scan->saveFile = true;

list($result, $err) = $client->Do($scan);
if ($err !== null) {
    echo 'API error: '.$err->message;
} else {
    file_put_contents('result.json', json_encode($result));
}
```

## Examples

```php
use IDAnalyzer2\Api\AML\AMLSearch;
use IDAnalyzer2\Api\AML\AMLV3Search;
use IDAnalyzer2\Api\Docupass\CreateDocupass;

// AML / PEP / sanctions screening
$aml = new AMLSearch();
$aml->name = "John Smith";
list($result, $err) = $client->Do($aml);          // POST /aml

// DocuPass — hosted remote verification link
$dp = new CreateDocupass();
$dp->profile = "YOUR_PROFILE_ID";
list($docupass, $err) = $client->Do($dp);
```

More demos in the [`/example`](example) folder.

## API coverage

Request classes live under `IDAnalyzer2\Api\…` and cover the complete ID Analyzer API v2 surface:

| Group | Classes |
|---|---|
| Scanner | `StandardScan` (`/scan`), `QuickScan`, `VeryQuickScan` |
| Biometric | `FaceVerification`, `LivenessVerification` |
| AML | `AMLSearch` (`/aml`), `AMLV3Search` (`/amlv3`) |
| Contract | `GenerateContract` + template CRUD |
| Transaction | list / detail / edit / delete / export + image & file vault |
| Docupass | `CreateDocupass`, `LsDocupass`, `DocupassDetail`, `RmDocupass` |
| Profile | KYC profile CRUD + export |
| Webhook | `LsWebhook`, `ResendWebhook`, `RmWebhook` |
| Account | `MyAccount` |

## Resources

- [ID Analyzer website](https://www.idanalyzer.com)
- [Developer documentation & API reference](https://developer.idanalyzer.com/help)
- [PHP SDK guide](https://developer.idanalyzer.com/help/php)
- [Dashboard — get your API key](https://portal2.idanalyzer.com)

## Other ID Analyzer SDKs

[PHP](https://github.com/idanalyzer/id-analyzer-v2-php) · [Python](https://github.com/idanalyzer/id-analyzer-v2-python) · [Node.js](https://github.com/idanalyzer/id-analyzer-v2-nodejs) · [.NET](https://github.com/idanalyzer/id-analyzer-v2-dotnet) · [Java](https://github.com/idanalyzer/id-analyzer-v2-java) · [Go](https://github.com/idanalyzer/id-analyzer-v2-go)

## License

MIT © [ID Analyzer](https://www.idanalyzer.com) — see [LICENSE](LICENSE).
