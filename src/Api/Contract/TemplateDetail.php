<?php

namespace IDAnalyzer2\Api\Contract;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

/**
 * Request for the Contract Template Detail endpoint (`GET /contract/{templateId}`).
 *
 * Retrieves the details of a single contract template by its template ID.
 *
 * @property string $templateId
 */
class TemplateDetail extends ApiBase
{
    public string $uri = "/contract/{templateId}";
    public string $method = "GET";

    /**
     * Initialize the request fields with their descriptors and defaults.
     *
     * @return void
     */
    function __construct()
    {
        $this->initFields([
            self::RouteParam("templateId", "string", true, null, "Template ID"),
        ]);
    }
}