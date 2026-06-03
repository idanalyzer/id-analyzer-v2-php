<?php

namespace IDAnalyzer2\Api\Transaction;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;use IDAnalyzer2\SDKException;

/**
 * Request for the Edit Transaction endpoint (`PATCH /transaction/{transactionId}`).
 *
 * Updates the decision (reject/review/accept) of an existing transaction.
 *
 * @property string $decision
 * @property string $transactionId
 */
class EdTransaction extends ApiBase
{
    public string $uri = "/transaction/{transactionId}";
    public string $method = "PATCH";

    /**
     * Initialize the request fields with their descriptors and defaults.
     *
     * @return void
     */
    function __construct()
    {
        $this->initFields([
            self::Field('decision', 'string', true, null, 'reject, review, accept'),
            self::RouteParam('transactionId', 'string', true, null, 'Transaction ID'),
        ]);
    }
}