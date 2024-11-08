<?php

namespace IDAnalyzer2\Api\Transaction;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;use IDAnalyzer2\SDKException;

class OutputFile extends ApiBase
{
    public string $uri = "/filevault/{fileName}";
    public string $method = "GET";
    public bool $isFile = true;


    function __construct()
    {
        $this->initFields([
            self::RouteParam('fileName', 'string', true, null, 'File name returned by transaction API'),
        ]);
    }
}