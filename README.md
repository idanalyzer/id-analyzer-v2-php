
# ID Analyzer PHP SDK
This is a PHP SDK for [ID Analyzer Identity Verification APIs](https://www.idanalyzer.com), though all the APIs can be called with without the SDK using simple HTTP requests as outlined in the [documentation](https://id-analyzer-v2.readme.io), you can use this SDK to accelerate server-side development.

We strongly discourage users to connect to ID Analyzer API endpoint directly  from client-side applications that will be distributed to end user, such as mobile app, or in-browser JavaScript. Your API key could be easily compromised, and if you are storing your customer's information inside Vault they could use your API key to fetch all your user details. Therefore, the best practice is always to implement a client side connection to your server, and call our APIs from the server-side.

## Installation
Install through composer

```shell
composer require idanalyzer/id-analyzer-php-sdk
```
Alternatively, download this package and manually require the PHP files under **src** folder.

## Scanner
This category supports all scanning-related functions specifically used to initiate a new identity document scan & ID face verification transaction by uploading based64-encoded images.
![Sample ID](https://www.idanalyzer.com/img/sampleid1.jpg)
```injectablephp
<?php

require("src/Scanner.php");
require("src/Profile.php");
require("src/APIException.php");
use IDAnalyzer2\Scanner;
use IDAnalyzer2\APIException;
use IDAnalyzer2\Profile;

try {
    $profile = new Profile(Profile::$SECURITY_MEDIUM);
    $scan = new Scanner();
    $scan->throwAPIException(true);
    print_r($result = $scan->quickScan("05.jpg", "", true));
    $scan->setProfile($profile);
    print_r($result = $scan->scan("05.jpg"));
} catch (APIException $e) {
    print_r($e->getMessage());
} catch (InvalidArgumentException $e) {
    print_r($e->getMessage());
} catch (\Exception $e) {
    print_r($e->getMessage());
}

```

## Biometric
There are two primary functions within this class. The first one is verifyFace and the second is verifyLiveness.
```injectablephp
<?php

require("src/Biometric.php");
require("src/Profile.php");
require("src/APIException.php");
use IDAnalyzer2\Biometric;
use IDAnalyzer2\Profile;
use IDAnalyzer2\APIException;

try {
    $profile = new Profile(Profile::$SECURITY_MEDIUM);
    $biometric = new Biometric();
    $biometric->throwAPIException(true);
    $biometric->setProfile($profile);
    print_r($biometric->verifyFace("./01.jpg", './02.jpg'));
    print_r($biometric->verifyLiveness("./10.jpg", './6.mp4'));
} catch (APIException $e) {
    print_r($e->getMessage());
} catch (InvalidArgumentException $e) {
    print_r($e->getMessage());
} catch (\Exception $e) {
    print_r($e->getMessage());
}
```

## Contract
All contract-related feature sets are available in Contract class. There are three primary functions in this class.
```injectablephp
<?php

require("src/Contract.php");
require("src/APIException.php");
use IDAnalyzer2\Contract;
use IDAnalyzer2\APIException;

try {
    $contract = new Contract();
    $contract->throwAPIException(true);
    $temp = $contract->createTemplate("tempName", "<p>%{fullName}</p>");
    $tempId = $temp['templateId'];
    print_r($temp);
    print_r($contract->updateTemplate($tempId, "oldTemp", "<p>%{fullName}</p><p>Hello!!</p>"));
    print_r($contract->getTemplate($tempId));
    print_r($contract->listTemplate());
    print_r($contract->generate($tempId, "PDF", "", [
        'fullName' => 'Tian',
    ]));
    print_r($contract->deleteTemplate($tempId));
} catch (APIException $e) {
    print_r($e->getMessage());
} catch (InvalidArgumentException $e) {
    print_r($e->getMessage());
} catch (\Exception $e) {
    print_r($e->getMessage());
}
```

## Docupass
This category supports all rapid user verification based on the ids and the face images provided.
![DocuPass Screen](https://www.idanalyzer.com/img/docupassliveflow.jpg)
```injectablephp
<?php
require("src/Docupass.php");
require("src/APIException.php");
use IDAnalyzer2\Docupass;
use IDAnalyzer2\APIException;

try {
    $docupass = new Docupass();
    $docupass->throwAPIException(true);
    print_r($docupass->createDocupass("bbd8436953ef426e98d078953f258835"));
    /*
    Array
    (
        [reference] => 4PDPN8DRYF17GTEGEUS1T1SN
        [url] => https://v2-us1.idanalyzer.com/verify/#4PDPN8DRYF17GTEGEUS1T1SN
        [expiry] => 0
        [customData] =>
        [qrCode] => base64
    )
    */
    print_r($docupass->listDocupass());
    print_r($docupass->deleteDocupass('4PDPN8DRYF17GTEGEUS1T1SN'));
} catch (APIException $e) {
    print_r($e->getMessage());
} catch (InvalidArgumentException $e) {
    print_r($e->getMessage());
} catch (\Exception $e) {
    print_r($e->getMessage());
}
```

## Transaction
This function enables the developer to retrieve a single transaction record based on the provided transactionId.
```injectablephp
<?php

require("src/Transaction.php");
require("src/APIException.php");
use IDAnalyzer2\Transaction;
use IDAnalyzer2\APIException;

try {
    $transaction = new Transaction();
    $transaction->throwAPIException(true);
    print_r($transaction->getTransaction("bcefdaf921ca4393a6b9174ba44d3e8f"));
    print_r($transaction->listTransaction());
    print_r($transaction->updateTransaction("bcefdaf921ca4393a6b9174ba44d3e8f", "review"));
    print_r($transaction->deleteTransaction("bcefdaf921ca4393a6b9174ba44d3e8f"));
    $transaction->saveImage("9dd555648a7d594eadda39ea32adbd0fc08a1c79a9e4690cdc8d213f188f5376", "test.jpg");
    $transaction->saveFile("transaction-audit-report_iPYNUSKTD5HhpRb4tZpLdHMsiZKVZgWX.pdf", "test.pdf");
    $transaction->exportTransaction("./test.zip", [
        "a714d58a41874326874c7ce0052717ee",
        "cb45b0898aeb4a3b8fd578f136f4fafa"
    ], "json");

} catch (APIException $e) {
    print_r($e->getMessage());
} catch (InvalidArgumentException $e) {
    print_r($e->getMessage());
} catch (\Exception $e) {
    print_r($e->getMessage());
}
```

## Api Document
[ID Analyzer Document](https://id-analyzer-v2.readme.io/docs/php)

## Demo
Check out **/demo** folder for more Python demos.

## SDK Reference
Check out [ID Analyzer PHP Reference](https://idanalyzer.github.io/id-analyzer-nodejs/)
