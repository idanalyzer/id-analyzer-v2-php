<?php

namespace IDAnalyzer2\Api\Docupass;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;


class LsDocupass extends ApiBase {
    public string $uri = "/docupass";
    public string $method = "GET";

    function __construct() {
        $this->initFields([
            RequestPayload::QueryParam("sort", "string", false, null, "Sort by id or completedat"),
            RequestPayload::QueryParam("order", "string", false, null, "-1=Newest First (default); 1=Oldest First"),
            RequestPayload::QueryParam("offset", "string", false, null, "Index of the starting entry"),
            RequestPayload::QueryParam("limit", "string", false, null, "Number of items returned per call"),
            RequestPayload::QueryParam("reference", "string", false, null, "Filter by reference"),
            RequestPayload::QueryParam("customData", "string", false, null, "Filter by custom data"),
            RequestPayload::QueryParam("profileId", "string", false, null, "Filter by profile ID"),
            RequestPayload::QueryParam("decision", "string", false, null, "Filter by decision"),
            RequestPayload::QueryParam("createdAtMin", "string", false, null, "Time range filter"),
            RequestPayload::QueryParam("createdAtMax", "string", false, null, "Time range filter"),
            RequestPayload::QueryParam("completedAtMin", "string", false, null, "Time range filter"),
            RequestPayload::QueryParam("completedAtMax", "string", false, null, "Time range filter")
        ]);
    }
}