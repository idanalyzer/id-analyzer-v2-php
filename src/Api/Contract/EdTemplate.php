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
            self::Field('name', 'string', false, null, ''),
            self::Field('content', 'string', false, null, ''),
            self::Field('orientation', 'string', false, null, ''),
            self::Field('font', 'string', false, null, ''),
            self::Field('timezone', 'string', false, null, ''),
            self::RouteParam('templateId', 'string', true, null, 'Template ID'),
        ]);
    }
}
