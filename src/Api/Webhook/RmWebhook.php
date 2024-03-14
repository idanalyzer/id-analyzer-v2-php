<?php

namespace IDAnalyzer2\Api\Webhook;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

class RmWebhook extends ApiBase
{
    public string $uri = "/webhook/{webhookId}";
    public string $method = "DELETE";

    function __construct()
    {
        $this->initFields([
            RequestPayload::RouteParam("webhookId", "string", true, null, "Webhook ID"),
        ]);
    }
}