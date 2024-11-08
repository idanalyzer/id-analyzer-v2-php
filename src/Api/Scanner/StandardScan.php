<?php

namespace IDAnalyzer2\Api\Scanner;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;


class StandardScan extends ApiBase
{
    public string $uri = "/scan";
    public string $method = "POST";

    function __construct()
    {
        $this->initFields([
            self::Field('document', 'string', true, null, 'Base64-encoded Document Image, you may also reference image from another transaction by passing "ref:abcde" where abcde is the output image reference.'),
            self::Field('documentBack', 'string', false, null, 'Base64-encoded Document(Back) Image, you may also reference image from another transaction by passing "ref:abcde" where abcde is the output image reference.'),
            self::Field('face', 'string', false, null, 'Base64-encoded Face Image for Biometric Verification, you may submit multiple images by separating each image with a comma. Multiple images will improve liveness verification accuracy. You may also reference image from another transaction by passing "ref:abcde" where abcde is the output image reference.'),
            self::Field('faceVideo', 'string', false, null, 'Base64-encoded selfie video for Biometric Verification.'),
            self::Field('profile', 'string', true, null, 'Your custom KYC profile ID, or use one of the following preset profiles: "security_none", "security_low", "security_medium", "security_high"'),
            self::Field('profileOverride', 'object', false, null, 'Override one or more parameters on the existing profile, the object should be JSON style object adhering to Get KYC Profile API response.'),
            self::Field('restrictCountry', 'string', false, null, 'Accepted Issuer Country (ISO-Alpha2 Code separated by comma)'),
            self::Field('restrictState', 'string', false, null, 'Accepted Issuer State (ISO-Alpha2 Code separated by comma)'),
            self::Field('restrictType', 'string', false, null, 'Accepted ID Type (I=ID, P=Passport, D=Driving License, V=Visa, R=Residence Permit)'),
            self::Field('verifyName', 'string', false, null, 'Supply customer name to match with document'),
            self::Field('verifyDob', 'string', false, null, 'Supply customer birthday to match with document'),
            self::Field('verifyAge', 'string', false, null, 'Supply an age range to check if customer is within the age range. For example, "20-40", a warning will be triggered if age is under 20 or over 40.'),
            self::Field('verifyAddress', 'string', false, null, 'Supply customer address to match with document'),
            self::Field('verifyPostcode', 'string', false, null, 'Supply customer postcode to match with document'),
            self::Field('verifyDocumentNumber', 'string', false, null, 'Supply customer ID number to match with document'),
            self::Field('contractGenerate', 'string', false, null, 'Enter up to 5 contract template ID (separated by comma) to automatically generate contract document using value parsed from uploaded ID'),
            self::Field('contractFormat', 'string', false, null, 'PDF, DOCX or HTML'),
            self::Field('contractPrefill', 'object', false, null, 'JSON data in key-value pairs to autofill dynamic fields, data from user ID will be used first in case of a conflict. For example, passing {"myparameter":"abc"} would fill %{myparameter} in contract template with "abc".'),
            self::Field('ip', 'string', false, null, 'Pass in user IP address to check if ID is issued from the same country as the IP address, use value "user" to use connection IP.'),
            self::Field('customData', 'string', false, null, 'Any arbitrary string you wish to save with the transaction. e.g., Internal customer reference number'),
        ]);
    }

    /**
     * Automatically generate contract document using value parsed from uploaded ID
     * @param string $templateId Enter up to 5 contract template ID (seperated by comma)
     * @param string $format PDF, DOCX or HTML
     * @param array $extraFillData Array data in key-value pairs to autofill dynamic fields, data from user ID will be used first in case of a conflict. For example, passing {"myparameter":"abc"} would fill %{myparameter} in contract template with "abc".
     * @return void
     */
    public function setContractOptions(string $templateId, string $format = "PDF", array $extraFillData = []) {
        if ($templateId !== "") {
            $this->contractGenerate = $templateId;
            $this->contractFormat = $format;
            if (is_array($extraFillData)) {
                if (count($extraFillData) > 0) {
                    $this->contractPrefill = $extraFillData;
                }
            } else {
                throw new SDKException("extraFillData should be an array.");
            }
        }
    }
}