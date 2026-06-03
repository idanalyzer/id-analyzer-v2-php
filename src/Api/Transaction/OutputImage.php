<?php

namespace IDAnalyzer2\Api\Transaction;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

/**
 * Request for the Output Image endpoint (`GET /imagevault/{imageToken}`).
 *
 * Downloads a stored output image from the image vault by its image token.
 *
 * @property string $imageToken
 */
class OutputImage extends ApiBase
{
    public string $uri = "/imagevault/{imageToken}";
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
            self::RouteParam('imageToken', 'string', true, null, 'Image token retrieved from transaction image response'),
        ]);
    }
}