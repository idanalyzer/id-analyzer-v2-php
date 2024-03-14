<?php

namespace IDAnalyzer2\Api\Profile;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

class LsProfile extends ApiBase
{
    public string $uri = "/profile";
    public string $method = "GET";
}