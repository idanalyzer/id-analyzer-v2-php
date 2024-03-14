<?php

namespace IDAnalyzer2\Api\Transaction;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

class LsTransaction extends ApiBase
{
    public string $uri = "/transaction";
    public string $method = "GET";

    function __construct()
    {
        $this->initFields([
            RequestPayload::QueryParam('limit', 'integer', false, null, 'Number of items to be returned per call'),
            RequestPayload::QueryParam('offset', 'integer', false, null, 'Start the list from a particular entry index'),
            RequestPayload::QueryParam('order', 'integer', false, null, 'Sort results by newest(-1) or oldest(1)'),
            RequestPayload::QueryParam('profileId', 'string', false, null, 'Filter result by KYC Profile ID'),
            RequestPayload::QueryParam('decision', 'string', false, null, 'Filter result by current decision'),
            RequestPayload::QueryParam('customData', 'string', false, null, 'Filter result by customData field'),
            RequestPayload::QueryParam('createdAtMin', 'string', false, null, 'List transactions that were created after this timestamp'),
            RequestPayload::QueryParam('createdAtMax', 'string', false, null, 'List transactions that were created before this timestamp'),
            RequestPayload::QueryParam('docupass', 'string', false, null, 'Filter result by Docupass reference'),
        ]);
    }
}