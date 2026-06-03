<?php

namespace IDAnalyzer2\Api\Docupass;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;


/**
 * Request for the Delete Docupass endpoint (`DELETE /docupass/{reference}`).
 *
 * Deletes the Docupass session identified by its reference ID.
 *
 * @property string $reference
 */
class RmDocupass extends ApiBase {
    public string $uri = "/docupass/{reference}";
    public string $method = "DELETE";

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