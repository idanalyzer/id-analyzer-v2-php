# ID Analyzer PHP SDK — Identity Verification, KYC, Document & Biometric API

[![Packagist version](https://img.shields.io/packagist/v/idanalyzer/id-analyzer-v2-php-sdk.svg)](https://packagist.org/packages/idanalyzer/id-analyzer-v2-php-sdk)
[![PHP version](https://img.shields.io/packagist/php-v/idanalyzer/id-analyzer-v2-php-sdk.svg)](https://packagist.org/packages/idanalyzer/id-analyzer-v2-php-sdk)
[![license](https://img.shields.io/packagist/l/idanalyzer/id-analyzer-v2-php-sdk.svg)](LICENSE)

Official PHP client library for the **[ID Analyzer](https://www.idanalyzer.com) API v2** — automate identity document verification, KYC onboarding and biometric checks in minutes.

Scan and authenticate **passports, driver's licenses, ID cards, visas and residence permits from 190+ countries**, run **1:1 face match and liveness detection**, screen against **AML / PEP / sanctions** watchlists, and onboard users remotely with **DocuPass** hosted verification & e-signature.

- 🌐 **Website:** [www.idanalyzer.com](https://www.idanalyzer.com)
- 📚 **Developer docs & API reference:** [developer.idanalyzer.com](https://developer.idanalyzer.com/help)
- 📖 **Full SDK class reference (auto-generated):** [https://idanalyzer.github.io/id-analyzer-v2-php/](https://idanalyzer.github.io/id-analyzer-v2-php/)
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

## Usage

Every endpoint is a request class under `IDAnalyzer2\Api\…`. Set its public properties, then call `$client->Do($request)`, which returns a `[$result, $err]` tuple — `$result` is the decoded response object and `$err` is an `ApiError` (or `null`). Image/document inputs accept a base64 string, a file path/URL, or a `ref:` cache reference from a previous scan.

```php
require_once __DIR__.'/vendor/autoload.php';

use IDAnalyzer2\Client;
use IDAnalyzer2\Api\Scanner\StandardScan;

$client = new Client("YOUR_API_KEY");

$scan = new StandardScan();
$scan->document = base64_encode(file_get_contents('id_front.jpg'));
$scan->face     = base64_encode(file_get_contents('selfie.jpg'));   // optional biometric check
$scan->profile  = "security_medium";   // a preset, or your KYC profile ID

list($result, $err) = $client->Do($scan);
if ($err !== null) {
    echo 'API error: '.$err->message;
} else {
    echo $result->decision;   // accept / review / reject
}
```

## Examples

### Document scanning

```php
use IDAnalyzer2\Api\Scanner\QuickScan;       // fast OCR
use IDAnalyzer2\Api\Scanner\VeryQuickScan;   // fastest OCR-only

$qs = new QuickScan();
$qs->document  = base64_encode(file_get_contents('id_front.jpg'));
$qs->documentBack = base64_encode(file_get_contents('id_back.jpg')); // optional
$qs->saveFile  = true;   // cache the image 24h and return a ref: hash
list($result, $err) = $client->Do($qs);
```

### Biometric — face match & liveness

```php
use IDAnalyzer2\Api\Biometric\FaceVerification;
use IDAnalyzer2\Api\Biometric\LivenessVerification;

$face = new FaceVerification();
$face->reference = base64_encode(file_get_contents('id_portrait.jpg'));
$face->face      = base64_encode(file_get_contents('selfie.jpg'));
$face->profile   = "security_medium";
list($result, $err) = $client->Do($face);

$live = new LivenessVerification();
$live->face    = base64_encode(file_get_contents('selfie.jpg'));
$live->profile = "security_medium";
list($result, $err) = $client->Do($live);
```

### AML / PEP / sanctions screening

```php
use IDAnalyzer2\Api\AML\AMLSearch;
use IDAnalyzer2\Api\AML\AMLV3Search;

$aml = new AMLSearch();
$aml->name    = "John Smith";
$aml->country = "US";          // optional ISO-2 filter
list($result, $err) = $client->Do($aml);          // POST /aml

$amlv3 = new AMLV3Search();
$amlv3->text  = "John Smith";
$amlv3->limit = 10;
$amlv3->page  = 1;
list($result, $err) = $client->Do($amlv3);        // POST /amlv3
```

### KYB — business verification

Verify a business from its registration/incorporation document: extract details, check official company registries, screen against sanctions/PEP, and return directors/owners to verify. Supply a document and/or known business identifiers (at least one of document, legalName or registrationNumber).

```php
use IDAnalyzer2\Api\KYB\KYBVerify;

// From a registration/incorporation document
$kyb = new KYBVerify();
$kyb->document = base64_encode(file_get_contents('./registration.jpg'));
list($result, $err) = $client->Do($kyb);          // POST /kyb

// Or from known business details
$kyb = new KYBVerify();
$kyb->legalName          = "ACME CORPORATION";
$kyb->registrationNumber = "12345678";
$kyb->countryIso2        = "US";                  // ISO-2 country of registration
list($result, $err) = $client->Do($kyb);          // POST /kyb
```

### Contracts — generate & manage templates

```php
use IDAnalyzer2\Api\Contract\GenerateContract;
use IDAnalyzer2\Api\Contract\CreateTemplate;
use IDAnalyzer2\Api\Contract\LsTemplate;
use IDAnalyzer2\Api\Contract\TemplateDetail;
use IDAnalyzer2\Api\Contract\EdTemplate;
use IDAnalyzer2\Api\Contract\RmTemplate;

// Create a template
$create = new CreateTemplate();
$create->name        = "NDA";
$create->content     = "<p>Signed by %{fullName}</p>";
$create->orientation = "0";
$create->font        = "Arial";
$create->timezone    = "UTC";
list($tpl, $err) = $client->Do($create);
$templateId = $tpl->templateId;

// Generate a document from a template + data
$gen = new GenerateContract();
$gen->templateId = $templateId;
$gen->format     = "PDF";
$gen->fillData   = ["fullName" => "Mark"];
list($doc, $err) = $client->Do($gen);

// List / detail / edit / remove
$client->Do(new LsTemplate());
$detail = new TemplateDetail();  $detail->templateId = $templateId;  $client->Do($detail);
$rm = new RmTemplate();          $rm->templateId = $templateId;      $client->Do($rm);
```

### Transactions — history, decisions, vault & export

```php
use IDAnalyzer2\Api\Transaction\LsTransaction;
use IDAnalyzer2\Api\Transaction\TransactionDetail;
use IDAnalyzer2\Api\Transaction\EdTransaction;
use IDAnalyzer2\Api\Transaction\RmTransaction;
use IDAnalyzer2\Api\Transaction\OutputImage;
use IDAnalyzer2\Api\Transaction\OutputFile;
use IDAnalyzer2\Api\Transaction\ExportTransaction;

// List & fetch
$client->Do(new LsTransaction());
$detail = new TransactionDetail(); $detail->transactionId = "TX_ID"; $client->Do($detail);

// Update decision / delete
$ed = new EdTransaction(); $ed->transactionId = "TX_ID"; $ed->decision = "reject"; $client->Do($ed);
$rm = new RmTransaction(); $rm->transactionId = "TX_ID"; $client->Do($rm);

// Download a vault image / file (returns raw bytes)
$oi = new OutputImage(); $oi->imageToken = "IMAGE_TOKEN";
list($bytes, $err) = $client->Do($oi);
file_put_contents("image.jpg", $bytes);

$of = new OutputFile(); $of->fileName = "audit-report.pdf";
list($bytes, $err) = $client->Do($of);
file_put_contents($of->fileName, $bytes);

// Export an archive (zip is base64 in the response)
$et = new ExportTransaction();
$et->exportType = "json";
$et->createdAtMin = (string)(time() - 86400);
$et->createdAtMax = (string)time();
list($export, $err) = $client->Do($et);
file_put_contents("export.zip", base64_decode($export->Base64));
```

### DocuPass — hosted remote verification & e-signature

```php
use IDAnalyzer2\Api\Docupass\CreateDocupass;
use IDAnalyzer2\Api\Docupass\LsDocupass;
use IDAnalyzer2\Api\Docupass\DocupassDetail;
use IDAnalyzer2\Api\Docupass\RmDocupass;

$create = new CreateDocupass();
$create->profile = "security_medium";   // or your KYC profile ID
$create->mode    = 0;                    // 0=Document+Face, 1=Document, 2=Face, 3=e-Signature
list($docupass, $err) = $client->Do($create);
// send the user to the returned verification URL / reference
echo $docupass->reference;

$client->Do(new LsDocupass());
$d = new DocupassDetail(); $d->reference = $docupass->reference; $client->Do($d);
$rm = new RmDocupass();    $rm->reference = $docupass->reference; $client->Do($rm);
```

### KYC profiles

```php
use IDAnalyzer2\Api\Profile\CreateProfile;
use IDAnalyzer2\Api\Profile\LsProfile;
use IDAnalyzer2\Api\Profile\ProfileDetail;
use IDAnalyzer2\Api\Profile\EdProfile;
use IDAnalyzer2\Api\Profile\RmProfile;
use IDAnalyzer2\Api\Profile\ExportProfile;

$create = new CreateProfile();           // optionally set name, thresholds, decisions, acceptedDocuments, webhook…
list($profile, $err) = $client->Do($create);
$profileId = $profile->id;

$client->Do(new LsProfile());
$d = new ProfileDetail(); $d->profileId = $profileId; $client->Do($d);
$rm = new RmProfile();    $rm->profileId = $profileId; $client->Do($rm);

$ex = new ExportProfile(); $ex->profileId = $profileId; $client->Do($ex);
```

### Webhooks & account

```php
use IDAnalyzer2\Api\Webhook\LsWebhook;
use IDAnalyzer2\Api\Webhook\ResendWebhook;
use IDAnalyzer2\Api\Webhook\RmWebhook;
use IDAnalyzer2\Api\Account\MyAccount;

$client->Do(new LsWebhook());
$resend = new ResendWebhook(); $resend->webhookId = "WEBHOOK_ID"; $client->Do($resend);
$rm = new RmWebhook();         $rm->webhookId = "WEBHOOK_ID";     $client->Do($rm);

// Account quota & usage
list($account, $err) = $client->Do(new MyAccount());
```

Runnable versions of every example are in the [`/example`](example) folder.

## API reference

| Group | Request classes (`IDAnalyzer2\Api\…`) | Endpoint |
|---|---|---|
| Scanner | `Scanner\StandardScan` | `POST /scan` |
| | `Scanner\QuickScan` | `POST /quickscan` |
| | `Scanner\VeryQuickScan` | `POST /veryquickscan` |
| Biometric | `Biometric\FaceVerification` | `POST /face` |
| | `Biometric\LivenessVerification` | `POST /liveness` |
| AML | `AML\AMLSearch` | `POST /aml` |
| | `AML\AMLV3Search` | `POST /amlv3` |
| KYB | `KYB\KYBVerify` | `POST /kyb` |
| Contract | `Contract\GenerateContract` | `POST /generate` |
| | `Contract\CreateTemplate` / `LsTemplate` / `TemplateDetail` / `EdTemplate` / `RmTemplate` | `/contract` |
| Transaction | `Transaction\LsTransaction` / `TransactionDetail` / `EdTransaction` / `RmTransaction` | `/transaction` |
| | `Transaction\ExportTransaction` | `POST /export/transaction` |
| | `Transaction\OutputImage` / `OutputFile` | `/imagevault` · `/filevault` |
| Docupass | `Docupass\CreateDocupass` / `LsDocupass` / `DocupassDetail` / `RmDocupass` | `/docupass` |
| Profile | `Profile\CreateProfile` / `LsProfile` / `ProfileDetail` / `EdProfile` / `RmProfile` / `ExportProfile` | `/profile` |
| Webhook | `Webhook\LsWebhook` / `ResendWebhook` / `RmWebhook` | `/webhook` |
| Account | `Account\MyAccount` | `GET /myaccount` |

Full parameter-level reference: **[developer.idanalyzer.com/help/php](https://developer.idanalyzer.com/help/php)**.

## Resources

- [ID Analyzer website](https://www.idanalyzer.com)
- [Developer documentation & API reference](https://developer.idanalyzer.com/help)
- [PHP SDK guide](https://developer.idanalyzer.com/help/php)
- [Dashboard — get your API key](https://portal2.idanalyzer.com)

## Other ID Analyzer SDKs

[PHP](https://github.com/idanalyzer/id-analyzer-v2-php) · [Python](https://github.com/idanalyzer/id-analyzer-v2-python) · [Node.js](https://github.com/idanalyzer/id-analyzer-v2-nodejs) · [.NET](https://github.com/idanalyzer/id-analyzer-v2-dotnet) · [Java](https://github.com/idanalyzer/id-analyzer-v2-java) · [Go](https://github.com/idanalyzer/id-analyzer-v2-go)

## License

MIT © [ID Analyzer](https://www.idanalyzer.com) — see [LICENSE](LICENSE).
