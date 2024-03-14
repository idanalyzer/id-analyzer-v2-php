<?php

namespace IDAnalyzer2\Api\Contract;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

class CreateTemplate extends ApiBase
{
    public string $uri = "/contract";
    public string $method = "POST";

    function __construct()
    {
        $this->initFields([
            RequestPayload::Field('name', 'string', false, null, 'Name of template'),
            RequestPayload::Field('content', 'string', false, null, 'HTML content'),
            RequestPayload::Field('orientation', 'string', false, null, '0=Portrait(Default) 1=Landscape'),
            RequestPayload::Field('font', 'string', false, null, 'Google font name'),
            RequestPayload::Field('timezone', 'string', false, null, 'TZ Database Name'),
        ]);
    }
}