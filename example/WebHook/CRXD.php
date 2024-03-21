<?php

require_once __DIR__.'/../../vendor/autoload.php';

use IDAnalyzer2\Client;
use \IDAnalyzer2\Api\Webhook\LsWebhook;
use \IDAnalyzer2\Api\Webhook\ResendWebhook;
use \IDAnalyzer2\Api\Webhook\RmWebhook;

try {
    $client = new Client("6EsqKOITW5Ge3cJYTGIGGNJZ3VmTEc64");

    $ls = new LsWebhook();
    [$lsResult, $err] = $client->Do($ls);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('ls_webhook.json', json_encode($lsResult));

    $resend = new ResendWebhook();
    $resend->webhookId = 'd5965e28b9654cf1aeb58bf7b66d543c';
    [$resendResult, $err] = $client->Do($resend);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('resend_webhook.json', json_encode($resendResult));

    $rm = new RmWebhook();
    $rm->webhookId = 'd5965e28b9654cf1aeb58bf7b66d543c';
    [$rmResult, $err] = $client->Do($rm);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('rm_webhook.json', json_encode($rmResult));
} catch (\IDAnalyzer2\SDKException $e) {
    echo 'SDKException：'.$e->getMessage();
} catch (Exception $e) {
    echo 'Exceptipn：'.$e->getMessage();
}
