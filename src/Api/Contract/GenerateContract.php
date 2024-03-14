<?php

namespace IDAnalyzer2\Api\Contract;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

class GenerateContract extends ApiBase
{
    public string $uri = "/generate";
    public string $method = "POST";

    function __construct()
    {
        $this->initFields([
            RequestPayload::Field('templateId', 'string', true, null, 'Template ID'),
            RequestPayload::Field('format', 'string', true, null, 'PDF, DOCX or HTML'),
            RequestPayload::Field('transactionId', 'string', false, null, 'Fill the template with data from specified transaction'),
            RequestPayload::Field('fillData', 'object', false, null, 'JSON data in key-value pairs to autofill dynamic fields, data from user ID will be used first in case of a conflict. For example, passing {"myparameter":"abc"} would fill %{myparameter} in contract template with "abc".'),
        ]);
    }
}
