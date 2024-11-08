<?php

namespace IDAnalyzer2\Api\Profile;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

class ProfileDetail extends ApiBase
{
    public string $uri = "/profile/{profileId}";
    public string $method = "GET";

    function __construct()
    {
        $this->initFields([
            self::RouteParam('profileId', 'string', true, null, 'KYC Profile ID'),
        ]);
    }
}