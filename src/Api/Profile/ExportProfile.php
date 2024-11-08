<?php

namespace IDAnalyzer2\Api\Profile;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

class ExportProfile extends ApiBase
{
    public string $uri = "/export/profile/{profileId}";
    public string $method = "GET";
    public bool $isFile = true;

    function __construct()
    {
        $this->initFields([
            self::RouteParam('profileId', 'string', true, null, 'KYC Profile ID'),
        ]);
    }
}