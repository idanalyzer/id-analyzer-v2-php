<?php

require_once __DIR__.'/../../vendor/autoload.php';

use IDAnalyzer2\Client;
use IDAnalyzer2\Api\Contract\CreateTemplate;
use IDAnalyzer2\Api\Contract\LsTemplate;
use IDAnalyzer2\Api\Contract\EdTemplate;
use IDAnalyzer2\Api\Contract\RmTemplate;
use IDAnalyzer2\Api\Contract\TemplateDetail;

try {
    $client = new Client("6EsqKOITW5Ge3cJYTGIGGNJZ3VmTEc64");

    $ls = new LsTemplate();

    [$lsResult, $err] = $client->Do($ls);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('ls_template.json', json_encode($lsResult));

    $create = new CreateTemplate();
    $create->name = "Test Template";
    $create->content = "<p>qwdqw</p>";
    $create->orientation = "0";
    $create->font = "Arial";
    $create->timezone = "UTC";
    [$createResult, $err] = $client->Do($create);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('create_template.json', json_encode($createResult));

    $templateId = $createResult->templateId;

    $detail = new TemplateDetail();
    $detail->templateId = $templateId;
    [$detailResult, $err] = $client->Do($detail);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('template_detail.json', json_encode($detailResult));

    $ed = new EdTemplate();
    $ed->templateId = $templateId;
    $ed->name = $detailResult->name . "_update";
    $ed->content = $detailResult->content;
    $ed->orientation = $detailResult->orientation;
    $ed->font = $detailResult->font;
    $ed->timezone = $detailResult->timezone;

    [$edResult, $err] = $client->Do($ed);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('ed_template.json', json_encode($edResult));

    $rm = new RmTemplate();
    $rm->templateId = $templateId;
    [$rmResult, $err] = $client->Do($rm);
    if ($err != null) {
        echo 'ApiError：'.$err->message;
        return;
    }
    //write file to current directory
    file_put_contents('rm_template.json', json_encode($rmResult));


} catch (\IDAnalyzer2\SDKException $e) {
    echo 'SDKException：'.$e->getMessage();
} catch (Exception $e) {
    echo 'Exceptipn：'.$e->getMessage();
}
