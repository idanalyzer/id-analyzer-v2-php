
# ID Analyzer V2 PHP SDK
This is a PHP SDK for [ID Analyzer Identity Verification APIs](https://www.idanalyzer.com), though all the APIs can be called with without the SDK using simple HTTP requests as outlined in the [documentation](https://idanalyzer.helptal.com/help), you can use this SDK to accelerate server-side development.

We strongly discourage users to connect to ID Analyzer API endpoint directly  from client-side applications that will be distributed to end user, such as mobile app, or in-browser JavaScript. Your API key could be easily compromised, and if you are storing your customer's information inside Vault they could use your API key to fetch all your user details. Therefore, the best practice is always to implement a client side connection to your server, and call our APIs from the server-side.

## Installation
Install through composer

```shell
composer require idanalyzer/id-analyzer-v2-php-sdk
```

## Quick Start
[Quick start with client library](https://idanalyzer.helptal.com/help/quick-start)

## Api Document
[ID Analyzer Document](https://idanalyzer.helptal.com/help)

## Base URL / Region
The SDK targets the US fleet (`https://api2.idanalyzer.com`) by default. To use
the EU fleet (`https://api2-eu.idanalyzer.com`), pass the zone to the client:

```php
$client = new IDAnalyzer2\Client("YOUR_API_KEY", "eu"); // "us" (default) or "eu"
```

## API Coverage
The SDK exposes the full ID Analyzer API v2 surface:

- **Scanner** — `StandardScan` (`/scan`), `QuickScan` (`/quickscan`), `VeryQuickScan` (`/veryquickscan`)
- **Biometric** — `FaceVerification` (`/face`), `LivenessVerification` (`/liveness`)
- **AML** — `AMLSearch` (`/aml`), `AMLV3Search` (`/amlv3`)
- **Contract** — `GenerateContract` (`/generate`) + template CRUD (`/contract`)
- **Transaction** — list/detail/update/delete (`/transaction`), export, image/file vault
- **Docupass** — `CreateDocupass`, `LsDocupass`, `DocupassDetail` (`/docupass/{reference}`), `RmDocupass`
- **Profile** — KYC profile CRUD + export (`/profile`)
- **Webhook** — list/resend/delete (`/webhook`)
- **Account** — `MyAccount` (`/myaccount`)

## Example
Check out the **/example** folder for usage demos.

## SDK Reference
Check out [ID Analyzer PHP Reference](https://idanalyzer.helptal.com/help/php)
