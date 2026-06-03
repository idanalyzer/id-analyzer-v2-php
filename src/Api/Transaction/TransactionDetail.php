<?php

namespace IDAnalyzer2\Api\Transaction;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

/**
 * Request for the Transaction Detail endpoint (`GET /transaction/{transactionId}`).
 *
 * Retrieves the full details of a single transaction by its transaction ID.
 *
 * @property string $transactionId
 */
class TransactionDetail extends ApiBase
{
    public string $uri = "/transaction/{transactionId}";
    public string $method = "GET";

    /**
     * Initialize the request fields with their descriptors and defaults.
     *
     * @return void
     */
    function __construct()
    {
        $this->initFields([
            self::RouteParam("transactionId", "string", true, null, "Transaction ID")
        ]);
    }
}