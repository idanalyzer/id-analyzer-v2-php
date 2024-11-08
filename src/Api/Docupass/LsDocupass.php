<?php

namespace IDAnalyzer2\Api\Docupass;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;


class LsDocupass extends ApiBase {
    public string $uri = "/docupass";
    public string $method = "GET";

    function __construct() {
        $this->initFields([
            self::QueryParam("sort", "string", false, null, "Sort by id or completedat"),
            self::QueryParam("order", "string", false, null, "-1=Newest First (default); 1=Oldest First"),
            self::QueryParam("offset", "string", false, null, "Index of the starting entry"),
            self::QueryParam("limit", "string", false, null, "Number of items returned per call"),
            self::QueryParam("reference", "string", false, null, "Filter by reference"),
            self::QueryParam("customData", "string", false, null, "Filter by custom data"),
            self::QueryParam("profileId", "string", false, null, "Filter by profile ID"),
            self::QueryParam("decision", "string", false, null, "Filter by decision"),
            self::QueryParam("createdAtMin", "string", false, null, "Time range filter"),
            self::QueryParam("createdAtMax", "string", false, null, "Time range filter"),
            self::QueryParam("completedAtMin", "string", false, null, "Time range filter"),
            self::QueryParam("completedAtMax", "string", false, null, "Time range filter")
        ]);
    }
}