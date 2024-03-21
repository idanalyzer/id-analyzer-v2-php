<?php

namespace IDAnalyzer2\Api\Docupass;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;


class RmDocupass extends ApiBase {
    public string $uri = "/docupass/{reference}";
    public string $method = "DELETE";
    
    function __construct() {
        $this->initFields([
            RequestPayload::RouteParam("reference", "string", true, null, "Docupass reference ID"),
        ]);
    }
}