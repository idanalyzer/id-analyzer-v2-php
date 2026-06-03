<?php

namespace IDAnalyzer2\Api\Contract;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;use IDAnalyzer2\SDKException;

/**
 * Request for the Delete Contract Template endpoint (`DELETE /contract/{templateId}`).
 *
 * Deletes the contract template identified by its template ID.
 *
 * @property string $templateId
 */
class RmTemplate extends ApiBase
{
    public string $uri = "/contract/{templateId}";
    public string $method = "DELETE";

    /**
     * Initialize the request fields with their descriptors and defaults.
     *
     * @return void
     */
    function __construct()
    {
        $this->initFields([
            self::RouteParam("templateId", "string", true, null, "Template ID to delete"),
        ]);
    }
}