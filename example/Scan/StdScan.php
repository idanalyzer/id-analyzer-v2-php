<?php

require_once __DIR__.'/../../vendor/autoload.php';

use IDAnalyzer2\Client;
use IDAnalyzer2\Api\Scanner\StandardScan;

try {
    $imgBytes = file_get_contents('./1.jpg');

    $client = new Client("6EsqKOITW5Ge3cJYTGIGGNJZ3VmTEc64");

    $scan = new StandardScan();
    $scan->document = base64_encode($imgBytes);
    $scan->profile = "security_medium";

    // or your profile id
    // $scan->profile = "ce482dafdb7444d5b8df79fd4c2a3b9b";

    list($result, $err) = $client->Do($scan);
    if($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('std_scan_result.json', json_encode($result));
} catch (\IDAnalyzer2\SDKException $e) {
    echo 'SDKException：'.$e->getMessage();
}  catch (Exception $e) {
    echo 'Exceptipn：' . $e->getMessage();
}

