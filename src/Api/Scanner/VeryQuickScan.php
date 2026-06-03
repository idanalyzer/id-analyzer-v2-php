<?php

namespace IDAnalyzer2\Api\Scanner;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;


/**
 * @property string $document
 * @property string $documentBack
 * @property bool $saveFile
 */
class VeryQuickScan extends ApiBase {
    public string $uri = "/veryquickscan";
    public string $method = "POST";

    function __construct() {
        $this->initFields([
             self::Field("document", "string", true, null, "Base64-encoded Document Image"),
             self::Field("documentBack", "string", false, null, "Base64-encoded Document(Back) Image"),
             self::Field("saveFile", "boolean", false, null, "Cache uploaded image(s) for 24 hours and obtain a cache hash for each image, the reference hash can be used to start standard scan transaction without re-uploading the file."),
        ]);
    }
}
