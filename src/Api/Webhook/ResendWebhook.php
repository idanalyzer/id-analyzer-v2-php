<?php

namespace IDAnalyzer2\Api\Webhook;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;use IDAnalyzer2\SDKException;

class ResendWebhook extends ApiBase
{
    public string $uri = "/webhook/{webhookId}";
    public string $method = "POST";

    function __construct()
    {
        $this->initFields([
            self::RouteParam("webhookId", "string", true, null, "Webhook ID"),
        ]);
    }
}