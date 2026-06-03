<?php

namespace IDAnalyzer2\Api\Docupass;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;


/**
 * Request for the Docupass Detail endpoint (`GET /docupass/{reference}`).
 *
 * Retrieves the details of a single Docupass session by its reference ID.
 *
 * @property string $reference
 */
class DocupassDetail extends ApiBase {
    public string $uri = "/docupass/{reference}";
    public string $method = "GET";

    /**
     * Initialize the request fields with their descriptors and defaults.
     *
     * @return void
     */
    function __construct() {
        $this->initFields([
            self::RouteParam("reference", "string", true, null, "Docupass reference ID"),
        ]);
    }
}
