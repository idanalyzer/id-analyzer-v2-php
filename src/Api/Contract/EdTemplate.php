<?php

namespace IDAnalyzer2\Api\Contract;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;


class EdTemplate extends ApiBase
{
    public string $uri = "/contract/{templateId}";
    public string $method = "POST";

    function __construct()
    {
        $this->initFields([
            RequestPayload::Field('name', 'string', false, null, ''),
            RequestPayload::Field('content', 'string', false, null, ''),
            RequestPayload::Field('orientation', 'string', false, null, ''),
            RequestPayload::Field('font', 'string', false, null, ''),
            RequestPayload::Field('timezone', 'string', false, null, ''),
            RequestPayload::RouteParam('templateId', 'string', true, null, 'Template ID'),
        ]);
    }
}
