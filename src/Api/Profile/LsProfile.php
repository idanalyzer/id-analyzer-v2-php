<?php

namespace IDAnalyzer2\Api\Profile;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

/**
 * Request for the List KYC Profiles endpoint (`GET /profile`).
 *
 * Retrieves the list of KYC profiles configured on the account.
 */
class LsProfile extends ApiBase
{
    public string $uri = "/profile";
    public string $method = "GET";
}