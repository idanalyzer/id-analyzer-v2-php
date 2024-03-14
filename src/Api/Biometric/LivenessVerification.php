<?php

namespace IDAnalyzer2\Api\Biometric;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

class LivenessVerification extends ApiBase
{
    public string $uri = "/liveness";
    public string $method = "POST";

    function __construct()
    {
        $this->initFields([
            RequestPayload::Field('face', 'string', false, null, 'Reference Image in base64 or remote URL'),
            RequestPayload::Field('faceVideo', 'string', false, null, 'Selfie video in base64 or remote URL'),
            RequestPayload::Field('profile', 'string', true, null, 'Profile ID'),
            RequestPayload::Field('profileOverride', 'object', false, null, 'Override any particular setting on the existing profile'),
            RequestPayload::Field('customData', 'string', false, null, 'Any arbitrary string you wish to save with the transaction. e.g Internal customer reference number'),
        ]);
    }
}