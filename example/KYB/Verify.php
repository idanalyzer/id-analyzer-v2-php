<?php

require_once __DIR__.'/../../vendor/autoload.php';

use IDAnalyzer2\Client;
use IDAnalyzer2\Api\KYB\KYBVerify;

try {
    $client = new Client("6EsqKOITW5Ge3cJYTGIGGNJZ3VmTEc64");

    // Verify a business from its registration/incorporation document: extract
    // details, check official company registries, screen against sanctions/PEP,
    // and return directors/owners to verify. A document is required; an optional
    // profile selects the KYC profile.
    $kyb = new KYBVerify();
    $kyb->document = base64_encode(file_get_contents('./registration.jpg'));

    // Optionally apply a KYC profile:
    // $kyb->profile = "your-profile-id";

    [$result, $err] = $client->Do($kyb);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('kybVerify.json', json_encode($result));


} catch (\IDAnalyzer2\SDKException $e) {
    echo 'SDKException：'.$e->getMessage();
} catch (Exception $e) {
    echo 'Exceptipn：'.$e->getMessage();
}
