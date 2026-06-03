<?php

namespace IDAnalyzer2\Api\Transaction;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

/**
 * @property string $transactionId
 */
class TransactionDetail extends ApiBase
{
    public string $uri = "/transaction/{transactionId}";
    public string $method = "GET";

    function __construct()
    {
        $this->initFields([
            self::RouteParam("transactionId", "string", true, null, "Transaction ID")
        ]);
    }
}