<?php

namespace IDAnalyzer2\Api\Profile;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;use IDAnalyzer2\SDKException;

/**
 * Request for the Delete KYC Profile endpoint (`DELETE /profile/{profileId}`).
 *
 * Deletes the KYC profile identified by its profile ID.
 *
 * @property string $profileId
 */
class RmProfile extends ApiBase
{
    public string $uri = "/profile/{profileId}";
    public string $method = "DELETE";

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