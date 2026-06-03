<?php

namespace IDAnalyzer2\Api\Account;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\SDKException;

/**
 * Request for the My Account endpoint (`GET /myaccount`).
 *
 * Retrieves the current account details, including quota and usage information.
 */
class MyAccount extends ApiBase
{
    public string $uri = "/myaccount";
    public string $method = "GET";

    /**
     * Construct the request. This endpoint takes no parameters.
     *
     * @return void
     */
    function __construct() {}
}