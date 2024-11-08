<?php

namespace IDAnalyzer2\Api\Profile;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

class EdProfile extends ApiBase
{
    public string $uri = "/profile/{profileId}";
    public string $method = "PUT";

    function __construct()
    {
        $this->initFields([
            self::Field('name', 'string', true, null, 'Profile Name'),
            self::Field('canvasSize', 'number', true, null, 'Canvas Size in pixels, input image larger than this size will be scaled down before further processing, reduced image size will improve inference time but reduce result accuracy.'),
            self::Field('orientationCorrection', 'boolean', true, null, 'Correct image orientation for rotated images'),
            self::Field('objectDetection', 'boolean', true, null, 'Enable to automatically detect and return the locations of signature, document and face.'),
            self::Field('AAMVABarcodeParsing', 'boolean', true, null, 'Enable to parse AAMVA barcode for US/CA ID/DL. Disable this to improve performance if you are not planning on scanning ID/DL from US or Canada.'),
            self::Field('saveResult', 'boolean', true, null, 'Whether transaction results should be saved'),
            self::Field('saveImage', 'boolean', true, null, 'If saveResult is enabled, whether output images should also be saved on cloud.'),
            self::Field('outputImage', 'boolean', true, null, 'Whether to return output image as part of API response'),
            self::Field('outputType', 'string', true, null, 'Output processed image in either "base64" or "url".'),
            self::Field('crop', 'boolean', true, null, 'Enable to automatically remove any irrelevant pixels from the uploaded image before saving and outputting the final image.'),
            self::Field('advancedCrop', 'boolean', true, null, 'Enable to use advanced deskew feature on documents that are sheared.'),
            self::Field('outputSize', 'number', true, null, 'Maximum pixel width/height for output & saved image.'),
            self::Field('inferFullName', 'boolean', true, null, 'Generate a full name field using parsed first name, middle name and last name.'),
            self::Field('splitFirstName', 'boolean', true, null, 'If first name contains more than one word, move second word onwards into middle name field.'),
            self::Field('transactionAuditReport', 'boolean', true, null, 'Enable to generate a detailed PDF audit report for every transaction.'),
            self::Field('timezone', 'string', true, null, 'Set timezone for audit reports. If left blank, UTC will be used. Refer to https://en.wikipedia.org/wiki/List_of_tz_database_time_zones TZ database name list.'),
            self::Field('obscure', 'array', true, null, 'A list of data fields key to be redacted before transaction storage, these fields will also be blurred from output & saved image.'),
            self::Field('webhook', 'string', true, null, 'Enter a server URL to listen for Docupass verification and scan transaction results'),
            self::Field('thresholds', 'object', true, null, 'Control the threshold of Document Validation Components, numbers should be float between 0 to 1.'),
            self::Field('decisionTrigger', 'object', true, null, 'For every failed validation'),
            self::Field('decisions', 'object', true, null, 'Enable/Disable and fine-tune how each Document Validation Component affects the final decision.'),
            self::Field('docupass', 'object', true, null, 'Docupass express identity verification / e-signature module settings'),
            self::Field('acceptedDocuments', 'object', true, null, 'Only accept specified type of document from specific countries and/or states.'),
            self::RouteParam('profileId', 'string', true, null, 'KYC Profile ID'),
        ]);
    }
}
