<?php

namespace IDAnalyzer2\Api\Transaction;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;use IDAnalyzer2\SDKException;

/**
 * Request for the Output File endpoint (`GET /filevault/{fileName}`).
 *
 * Downloads a generated output file (e.g. a contract or audit report) from the
 * file vault by its file name.
 *
 * @property string $fileName
 */
class OutputFile extends ApiBase
{
    public string $uri = "/filevault/{fileName}";
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
            self::RouteParam('fileName', 'string', true, null, 'File name returned by transaction API'),
        ]);
    }
}