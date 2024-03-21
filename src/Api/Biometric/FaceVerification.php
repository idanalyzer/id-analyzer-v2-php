<?php

namespace IDAnalyzer2\Api\Biometric;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;

class FaceVerification extends ApiBase
{
    public string $uri = "/face";
    public string $method = "POST";

    function __construct()
    {
        $this->initFields([
            RequestPayload::Field('reference', 'string', true, null, 'Reference Image in base64 or remote URL. You may also reference image from another transaction by passing "ref:abcde" where abcde is the output image reference.'),
            RequestPayload::Field('face', 'string', false, null, 'Selfie photo in base64 or URL, you can provide multiple frames of images captured continuously by separating each image with a comma (,). You may also reference image from another transaction by passing "ref:abcde" where abcde is the output image reference.'),
            RequestPayload::Field('faceVideo', 'string', false, null, 'Selfie video in base64 or remote URL.'),
            RequestPayload::Field('profile', 'string', true, null, 'Profile ID.'),
            RequestPayload::Field('profileOverride', 'string', false, null, 'Override any particular setting on the existing profile.'),
            RequestPayload::Field('customData', 'string', false, null, 'Any arbitrary string you wish to save with the transaction. e.g Internal customer reference number.'),
        ]);
    }
}