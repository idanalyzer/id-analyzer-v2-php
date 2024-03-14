<?php

namespace IDAnalyzer2\Api\Account;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\SDKException;

class MyAccount extends ApiBase
{
    public string $uri = "/myaccount";
    public string $method = "GET";

    function __construct() {}
}