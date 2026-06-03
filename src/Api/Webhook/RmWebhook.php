<?php

namespace IDAnalyzer2\Api\Webhook;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

/**
 * Request for the Delete Webhook Log endpoint (`DELETE /webhook/{webhookId}`).
 *
 * Deletes a webhook log entry identified by its webhook ID.
 *
 * @property string $webhookId
 */
class RmWebhook extends ApiBase
{
    public string $uri = "/webhook/{webhookId}";
    public string $method = "DELETE";

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