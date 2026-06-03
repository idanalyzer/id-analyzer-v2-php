<?php

namespace IDAnalyzer2\Api\Webhook;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;use IDAnalyzer2\SDKException;

/**
 * Request for the Resend Webhook endpoint (`POST /webhook/{webhookId}`).
 *
 * Re-delivers a previously logged webhook event identified by its webhook ID.
 *
 * @property string $webhookId
 */
class ResendWebhook extends ApiBase
{
    public string $uri = "/webhook/{webhookId}";
    public string $method = "POST";

    /**
     * Initialize the request fields with their descriptors and defaults.
     *
     * @return void
     */
    function __construct()
    {
        $this->initFields([
            self::RouteParam("webhookId", "string", true, null, "Webhook ID"),
        ]);
    }
}