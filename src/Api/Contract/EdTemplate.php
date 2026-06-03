<?php

namespace IDAnalyzer2\Api\Contract;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;


/**
 * Request for the Edit Contract Template endpoint (`POST /contract/{templateId}`).
 *
 * Updates an existing contract template identified by its template ID.
 *
 * @property string $name
 * @property string $content
 * @property string $orientation
 * @property string $font
 * @property string $timezone
 * @property string $templateId
 */
class EdTemplate extends ApiBase
{
    public string $uri = "/contract/{templateId}";
    public string $method = "POST";

    /**
     * Initialize the request fields with their descriptors and defaults.
     *
     * @return void
     */
    function __construct()
    {
        $this->initFields([
            self::Field('name', 'string', false, null, ''),
            self::Field('content', 'string', false, null, ''),
            self::Field('orientation', 'string', false, null, ''),
            self::Field('font', 'string', false, null, ''),
            self::Field('timezone', 'string', false, null, ''),
            self::RouteParam('templateId', 'string', true, null, 'Template ID'),
        ]);
    }
}
