<?php

namespace IDAnalyzer2\Api\Transaction;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;use IDAnalyzer2\SDKException;

/**
 * Request for the Delete Transaction endpoint (`DELETE /transaction/{transactionId}`).
 *
 * Deletes the transaction identified by its transaction ID.
 *
 * @property string $transactionId
 */
class RmTransaction extends ApiBase
{
    public string $uri = "/transaction/{transactionId}";
    public string $method = "DELETE";

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