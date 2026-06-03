<?php

namespace IDAnalyzer2\Api\Transaction;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

/**
 * @property string $imageToken
 */
class OutputImage extends ApiBase
{
    public string $uri = "/imagevault/{imageToken}";
    public string $method = "GET";
    public bool $isFile = true;
    function __construct()
    {
        $this->initFields([
            self::RouteParam('imageToken', 'string', true, null, 'Image token retrieved from transaction image response'),
        ]);
    }
}