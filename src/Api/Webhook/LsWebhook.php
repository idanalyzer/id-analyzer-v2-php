<?php

namespace IDAnalyzer2\Api\Webhook;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

class LsWebhook extends ApiBase
{
    public string $uri = "/webhook";
    public string $method = "GET";

    function __construct()
    {
        $this->initFields([
            RequestPayload::QueryParam('limit', 'integer', false, null, 'Number of items returned per call'),
            RequestPayload::QueryParam('offset', 'integer', false, null, 'Start from a particular entry'),
            RequestPayload::QueryParam('order', 'integer', false, null, 'Sort results by newest(-1) or oldest(1)'),
            RequestPayload::QueryParam('event', 'string', false, null, 'Filter result by event name'),
            RequestPayload::QueryParam('success', 'integer', false, null, 'Filter result by success status'),
            RequestPayload::QueryParam('createdAtMin', 'string', false, null, 'List transactions that were created after this timestamp'),
            RequestPayload::QueryParam('createdAtMax', 'string', false, null, 'List transactions that were created before this timestamp'),
        ]);
    }
}