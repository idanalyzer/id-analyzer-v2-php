<?php

namespace IDAnalyzer2;
use Exception;

/**
 * Exception thrown by the SDK for client-side and response-handling errors
 * (e.g. invalid configuration, missing required fields, or unparseable responses).
 */
class SDKException extends Exception {}