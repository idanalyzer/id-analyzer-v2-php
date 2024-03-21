<?php

require_once __DIR__.'/../../vendor/autoload.php';

use IDAnalyzer2\Client;
use IDAnalyzer2\Api\Profile\CreateProfile;
use IDAnalyzer2\Api\Profile\LsProfile;
use IDAnalyzer2\Api\Profile\ProfileDetail;
use IDAnalyzer2\Api\Profile\RmProfile;
use IDAnalyzer2\Api\Profile\EdProfile;

try {
    $client = new Client("6EsqKOITW5Ge3cJYTGIGGNJZ3VmTEc64");

    $create = new CreateProfile();

    [$result, $err] = $client->Do($create);
    if ($err != null) {
        echo 'ApiError：'.$err->message;

        return;
    }
//write file to current directory
    file_put_contents('create_profile_result.json', json_encode($result));

    $profileId = $result->id;

    $detail            = new ProfileDetail();
    $detail->profileId = $profileId;
    [$result, $err] = $client->Do($detail);
    if ($err != null) {
        echo 'ApiError：'.$err->message;

        return;
    }
//write file to current directory
    file_put_contents('profile_detail_result.json', json_encode($result));

    $edit                         = new EdProfile();
    $edit->profileId              = $profileId;
    $edit->name                   = $result->name.'_update';
    $edit->canvasSize             = $result->canvasSize;
    $edit->orientationCorrection  = $result->orientationCorrection;
    $edit->objectDetection        = $result->objectDetection;
    $edit->AAMVABarcodeParsing    = $result->AAMVABarcodeParsing;
    $edit->saveResult             = $result->saveResult;
    $edit->saveImage              = $result->saveImage;
    $edit->outputImage            = $result->outputImage;
    $edit->outputType             = $result->outputType;
    $edit->crop                   = $result->crop;
    $edit->advancedCrop           = $result->advancedCrop;
    $edit->outputSize             = $result->outputSize;
    $edit->inferFullName          = $result->inferFullName;
    $edit->splitFirstName         = $result->splitFirstName;
    $edit->transactionAuditReport = $result->transactionAuditReport;
    $edit->timezone               = $result->timezone;
    $edit->obscure                = $result->obscure;
    $edit->webhook                = $result->webhook;
    $edit->thresholds             = $result->thresholds;
    $edit->decisionTrigger        = $result->decisionTrigger;
    $edit->decisions              = $result->decisions;
    $edit->docupass               = $result->docupass;
    $edit->acceptedDocuments      = $result->acceptedDocuments;
    [$result, $err] = $client->Do($edit);
    if ($err != null) {
        echo 'ApiError：'.$err->message;

        return;
    }
//write file to current directory
    file_put_contents('edit_profile_result.json', json_encode($result));

    $list = new LsProfile();
    [$result, $err] = $client->Do($list);
    if ($err != null) {
        echo 'ApiError：'.$err->message;

        return;
    }
//write file to current directory
    file_put_contents('list_profile_result.json', json_encode($result));

    $rm            = new RmProfile();
    $rm->profileId = $profileId;
    [$result, $err] = $client->Do($rm);
    if ($err != null) {
        echo 'ApiError：'.$err->message;

        return;
    }
//write file to current directory
    file_put_contents('remove_profile_result.json', json_encode($result));

} catch (\IDAnalyzer2\SDKException $e) {
    echo 'SDKException：'.$e->getMessage();
} catch (Exception $e) {
    echo 'Exceptipn：'.$e->getMessage();
}

