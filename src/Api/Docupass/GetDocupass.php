<?php
namespace IDAnalyzer2\Api\Docupass;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;

class GetDocupass extends ApiBase 
{
    public string $uri = "/docupass/{reference}";
    public string $method = "GET";
    
    function __construct() 
    {
        $this->initFields([
            self::RouteParam("reference", "string", true, null, "Docupass reference ID"),
        ]);
    }
}
