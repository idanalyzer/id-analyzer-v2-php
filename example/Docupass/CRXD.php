<?php

require_once __DIR__.'/../../vendor/autoload.php';

use IDAnalyzer2\Client;
use \IDAnalyzer2\Api\Docupass\CreateDocupass;
use \IDAnalyzer2\Api\Docupass\LsDocupass;
use \IDAnalyzer2\Api\Docupass\RmDocupass;

try {
    $client = new Client("hzq5EeZYZccV25p47oKz0LQQBst9PAgv");

    $cDocupass        = new CreateDocupass();
    $cDocupass->profile = 'security_medium';
    // or your profile id
    // $cDucupass->profile = 'ce482dafdb7444d5b8df79fd4c2a3b9b';
    $cDocupass->mode = 1; // Document Only

    list($cDocResult, $err) = $client->Do($cDocupass);
    if($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }

    //write file to current directory
    file_put_contents('create_docupass.json', json_encode($cDocResult));

    $rDocupass = new LsDocupass();
    $rDocupass->reference = $cDocResult->reference;

    list($rDocResult, $err) = $client->Do($rDocupass);
    if($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }

    //write file to current directory
    file_put_contents('ls_docupass.json', json_encode($rDocResult));

    $dDocupass = new RmDocupass();
    $dDocupass->reference = $cDocResult->reference;

    list($dDocResult, $err) = $client->Do($dDocupass);
    if($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }

    //write file to current directory
    file_put_contents('rm_docupass.json', json_encode($dDocResult));
} catch (\IDAnalyzer2\SDKException $e) {
    echo 'SDKException：'.$e->getMessage();
} catch (Exception $e) {
    echo 'Exceptipn：'.$e->getMessage();
}
