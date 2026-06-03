<?php

namespace IDAnalyzer2\Api\Contract;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

/**
 * @property string $templateId
 */
class TemplateDetail extends ApiBase
{
    public string $uri = "/contract/{templateId}";
    public string $method = "GET";

    function __construct()
    {
        $this->initFields([
            self::RouteParam("templateId", "string", true, null, "Template ID"),
        ]);
    }
}