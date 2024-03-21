<?php

require_once __DIR__.'/../../vendor/autoload.php';

use IDAnalyzer2\Client;
use IDAnalyzer2\Api\Biometric\FaceVerification;

try {
    $client = new Client("6EsqKOITW5Ge3cJYTGIGGNJZ3VmTEc64");

    $f1Bytes = file_get_contents('./f1.jpg');
    $f2Bytes = file_get_contents('./f2.jpg');

    $v = new FaceVerification();
    $v->reference = base64_encode($f1Bytes);
    $v->face = base64_encode($f2Bytes);
    $v->profile = "security_medium";

    [$result, $err] = $client->Do($v);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('face_version.json', json_encode($result));


} catch (\IDAnalyzer2\SDKException $e) {
    echo 'SDKException：'.$e->getMessage();
} catch (Exception $e) {
    echo 'Exceptipn：'.$e->getMessage();
}

