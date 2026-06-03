<?php

namespace IDAnalyzer2\Api\Profile;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

/**
 * Request for the Export KYC Profile endpoint (`GET /export/profile/{profileId}`).
 *
 * Downloads the export file for a KYC profile identified by its profile ID.
 *
 * @property string $profileId
 */
class ExportProfile extends ApiBase
{
    public string $uri = "/export/profile/{profileId}";
    public string $method = "GET";
    public bool $isFile = true;

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