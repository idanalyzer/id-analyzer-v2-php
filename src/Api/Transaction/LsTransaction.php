<?php

namespace IDAnalyzer2\Api\Transaction;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

/**
 * Request for the List Transactions endpoint (`GET /transaction`).
 *
 * Retrieves a paginated, filterable list of scan/verification transactions.
 *
 * @property int $limit
 * @property int $offset
 * @property int $order
 * @property string $profileId
 * @property string $decision
 * @property string $customData
 * @property string $createdAtMin
 * @property string $createdAtMax
 * @property string $docupass
 */
class LsTransaction extends ApiBase
{
    public string $uri = "/transaction";
    public string $method = "GET";

    /**
     * Initialize the request fields with their descriptors and defaults.
     *
     * @return void
     */
    function __construct()
    {
        $this->initFields([
            self::QueryParam('limit', 'integer', false, null, 'Number of items to be returned per call'),
            self::QueryParam('offset', 'integer', false, null, 'Start the list from a particular entry index'),
            self::QueryParam('order', 'integer', false, null, 'Sort results by newest(-1) or oldest(1)'),
            self::QueryParam('profileId', 'string', false, null, 'Filter result by KYC Profile ID'),
            self::QueryParam('decision', 'string', false, null, 'Filter result by current decision'),
            self::QueryParam('customData', 'string', false, null, 'Filter result by customData field'),
            self::QueryParam('createdAtMin', 'string', false, null, 'List transactions that were created after this timestamp'),
            self::QueryParam('createdAtMax', 'string', false, null, 'List transactions that were created before this timestamp'),
            self::QueryParam('docupass', 'string', false, null, 'Filter result by Docupass reference'),
        ]);
    }
}