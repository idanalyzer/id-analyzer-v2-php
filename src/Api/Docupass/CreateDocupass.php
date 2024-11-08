<?php

namespace IDAnalyzer2\Api\Docupass;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

class CreateDocupass extends ApiBase
{
    public string $uri = "/docupass";
    public string $method = "POST";

    function __construct()
    {
        $this->initFields([
            self::Field('profile', 'string', true, null, 'Custom KYC Profile ID'),
            self::Field('mode', 'string', true, null, '0=Document+Face, 1=Document Only, 2=Face Only, 3=e-Signature Only'),
            self::Field('verifyAddress', 'string', false, null, ""),
            self::Field('verifyDocumentNumber', 'string', false, null, ""),
            self::Field('verifyAge', 'string', false, null, ""),
            self::Field('verifyName', 'string', false, null, ""),
            self::Field('verifyDOB', 'string', false, null, ""),
            self::Field('verifyPostcode', 'string', false, null, ""),
            self::Field('userPhone', 'string', false, null, 'Supply user phone number for verification, must enable phoneVerification in profile settings.'),
            self::Field('customData', 'string', false, null, ""),
            self::Field('language', 'string', false, null, 'Override auto language detection'),
            self::Field('reusable', 'boolean', false, null, 'Whether the generated link can be used to verify multiple person'),
            self::Field('referenceDocument', 'string', false, null, 'Base64 encoded document image, if supplied, no document front image will be captured.'),
            self::Field('referenceDocumentBack', 'string', false, null, 'Base64 encoded document back image, if supplied, no document back image will be captured.'),
            self::Field('referenceFace', 'string', false, null, 'Base64 encoded face image, if supplied, no face image will be captured. Required if mode=2.'),
            self::Field('contractGenerate', 'string', false, null, 'Generate up to 5 documents using information from uploaded ID, without user reviewing or signing the document.'),
            self::Field('contractSign', 'string', false, null, 'Generate a document using information from uploaded ID, and have the user review and sign the document after identity verification. Required for mode=3.'),
            self::Field('contractFormat', 'string', false, null, 'PDF, DOCX, HTML'),
            self::Field('contractPrefill', 'object', false, null, 'JSON data in key-value pairs to autofill dynamic fields, data from user ID will be used first in case of a conflict. For example, passing {"myparameter":"abc"} would fill %{myparameter} in contract template with "abc".'),
        ]);
    }
}