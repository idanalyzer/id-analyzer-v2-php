<?php

namespace IDAnalyzer2\Api\Contract;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

class LsTemplate extends ApiBase
{
    public string $uri = "/contract";
    public string $method = "GET";

    function __construct()
    {
        $this->initFields([
            RequestPayload::QueryParam('limit', 'integer', false, null, 'Number of items returned per call'),
            RequestPayload::QueryParam('offset', 'integer', false, null, 'Start from a particular entry'),
            RequestPayload::QueryParam('order', 'integer', false, null, 'Sort results by newest(-1) or oldest(1)'),
            RequestPayload::QueryParam('templateid', 'string', false, null, 'Filter result by template ID'),
        ]);
    }
}