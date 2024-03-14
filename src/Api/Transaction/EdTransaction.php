<?php

namespace IDAnalyzer2\Api\Transaction;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;use IDAnalyzer2\SDKException;

class EdTransaction extends ApiBase
{
    public string $uri = "/transaction/{transactionId}";
    public string $method = "PATCH";

    function __construct()
    {
        $this->initFields([
            RequestPayload::QueryParam('decision', 'string', true, null, 'reject, review, accept'),
            RequestPayload::RouteParam('transactionId', 'string', true, null, 'Transaction ID'),
        ]);
    }
}