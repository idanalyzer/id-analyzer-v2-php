<?php

require_once __DIR__.'/../../vendor/autoload.php';

use IDAnalyzer2\Client;
use IDAnalyzer2\Api\Contract\GenerateContract;

try {
    $client = new Client("6EsqKOITW5Ge3cJYTGIGGNJZ3VmTEc64");

    $gen = new GenerateContract();
    $gen->templateId = "JW2QH3G4SC88";
    $gen->format = "PDF";
    $gen->fillData = [
        "name" => "Mark",
    ];
    [$genResult, $err] = $client->Do($gen);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('contract.json', json_encode($genResult));

} catch (\IDAnalyzer2\SDKException $e) {
    echo 'SDKException：'.$e->getMessage();
} catch (Exception $e) {
    echo 'Exceptipn：'.$e->getMessage();
}
