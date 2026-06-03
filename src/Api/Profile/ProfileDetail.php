<?php

namespace IDAnalyzer2\Api\Profile;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

/**
 * Request for the KYC Profile Detail endpoint (`GET /profile/{profileId}`).
 *
 * Retrieves the full settings of a single KYC profile by its profile ID.
 *
 * @property string $profileId
 */
class ProfileDetail extends ApiBase
{
    public string $uri = "/profile/{profileId}";
    public string $method = "GET";

    /**
     * Initialize the request fields with their descriptors and defaults.
     *
     * @return void
     */
    function __construct()
    {
        $this->initFields([
            self::RouteParam('profileId', 'string', true, null, 'KYC Profile ID'),
        ]);
    }
}