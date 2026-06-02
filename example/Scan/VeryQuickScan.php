<?php

require_once __DIR__.'/../../vendor/autoload.php';

use IDAnalyzer2\Client;
use IDAnalyzer2\Api\Scanner\VeryQuickScan;

try {
    $imgBytes = file_get_contents('./1.jpg');

    $client = new Client("6EsqKOITW5Ge3cJYTGIGGNJZ3VmTEc64");

    $vscan = new VeryQuickScan();
    $vscan->document = base64_encode($imgBytes);
    $vscan->saveFile = true;

    list($result, $err) = $client->Do($vscan);
    if($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('very_quick_scan_result.json', json_encode($result));


} catch (\IDAnalyzer2\SDKException $e) {
    echo 'SDKException：'.$e->getMessage();
}  catch (Exception $e) {
    echo 'Exceptipn：' . $e->getMessage();
}
