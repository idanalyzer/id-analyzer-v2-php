<?php

require_once __DIR__.'/../../vendor/autoload.php';

use IDAnalyzer2\Client;
use IDAnalyzer2\Api\Transaction\LsTransaction;
use IDAnalyzer2\Api\Transaction\EdTransaction;
use IDAnalyzer2\Api\Transaction\RmTransaction;
use IDAnalyzer2\Api\Transaction\TransactionDetail;

try {
    $client = new Client("6EsqKOITW5Ge3cJYTGIGGNJZ3VmTEc64");

    $ls = new LsTransaction();

    [$lsResult, $err] = $client->Do($ls);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('ls_transaction.json', json_encode($lsResult));

    $transactionId = "e2a783fddd6148e9a667205b38bbbefc";

    $detail = new TransactionDetail();
    $detail->transactionId = $transactionId;
    [$detailResult, $err] = $client->Do($detail);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('transaction_detail.json', json_encode($detailResult));

    $ed = new EdTransaction();
    $ed->transactionId = $transactionId;
    $ed->decision = 'reject';
    [$edResult, $err] = $client->Do($ed);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('ed_transaction.json', json_encode($edResult));

    $rm = new RmTransaction();
    $rm->transactionId = $transactionId;
    [$rmResult, $err] = $client->Do($rm);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('rm_transaction.json', json_encode($rmResult));

} catch (\IDAnalyzer2\SDKException $e) {
    echo 'SDKException：'.$e->getMessage();
} catch (Exception $e) {
    echo 'Exceptipn：'.$e->getMessage();
}

