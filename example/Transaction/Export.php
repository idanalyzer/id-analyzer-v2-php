<?php

require_once __DIR__.'/../../vendor/autoload.php';

use IDAnalyzer2\Client;
use IDAnalyzer2\Api\Transaction\OutputFile;
use IDAnalyzer2\Api\Transaction\OutputImage;
use IDAnalyzer2\Api\Transaction\ExportTransaction;

try {
    $client = new Client("6EsqKOITW5Ge3cJYTGIGGNJZ3VmTEc64");

    $of = new OutputFile();
    $of->fileName = "transaction-audit-report_RVXSlyLscYmAJOC326cFf6l3vNy7kEzD.pdf";

    [$ofResult, $err] = $client->Do($of);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents($of->fileName, $ofResult);

    $oi = new OutputImage();
    $oi->imageToken = "9f279958acb35aff9c592d7d8aead0d57fb2415e0ed7919157e83c0470d8d72a";

    [$oiResult, $err] = $client->Do($oi);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents("img.jpg", $oiResult);

    $et = new ExportTransaction();
    $et->exportType = "json";
    $et->createdAtMin = "" . (time() - 3600 * 24 * 1);
    $et->createdAtMax = "" . (time());
    $et->ignoreUnrecognized = true;
    $et->ignoreDuplicate = true;

    [$etResult, $err] = $client->Do($et);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }

    //write file to current directory
    file_put_contents("export_Transactions.zip", base64_decode($etResult->Base64));

} catch (\IDAnalyzer2\SDKException $e) {
    echo 'SDKException：'.$e->getMessage();
} catch (Exception $e) {
    echo 'Exceptipn：'.$e->getMessage();
}

