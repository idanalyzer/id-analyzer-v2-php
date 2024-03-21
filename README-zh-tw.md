
# ID Analyzer V2 PHP SDK
This is a PHP SDK for [ID Analyzer Identity Verification APIs](https://www.idanalyzer.com), though all the APIs can be called with without the SDK using simple HTTP requests as outlined in the [documentation](https://id-analyzer-v2.readme.io), you can use this SDK to accelerate server-side development.

We strongly discourage users to connect to ID Analyzer API endpoint directly  from client-side applications that will be distributed to end user, such as mobile app, or in-browser JavaScript. Your API key could be easily compromised, and if you are storing your customer's information inside Vault they could use your API key to fetch all your user details. Therefore, the best practice is always to implement a client side connection to your server, and call our APIs from the server-side.

## Installation
Install through composer

```shell
composer require idanalyzer/id-analyzer-v2-php-sdk
```

## Quick Start
[Quick start with client library](https://developer.idanalyzer.com/docs/quick-start#php)

## Api Document
[ID Analyzer Document](https://id-analyzer-v2.readme.io/docs/php)

## Example
Check out **/example** folder for more Python demos.

## SDK Reference
Check out [ID Analyzer PHP Reference](https://idanalyzer.github.io/id-analyzer-nodejs/)
