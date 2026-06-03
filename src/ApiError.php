<?php

namespace IDAnalyzer2;

/**
 * Represents an error returned by the ID Analyzer API.
 *
 * Returned as the second element of the tuple produced by {@see Client::Do()}
 * when the API responds with `success === false`.
 *
 * @property int    $status  The HTTP status code associated with the error.
 * @property string $code    The machine-readable API error code.
 * @property string $message A human-readable description of the error.
 */
class ApiError {
    public int $status;
    public string $code;
    public string $message;

    /**
     * @param int    $status  The HTTP status code associated with the error.
     * @param string $code    The machine-readable API error code.
     * @param string $message A human-readable description of the error.
     */
    public function __construct(int $status, string $code, string $message) {
        $this->status = $status;
        $this->code = $code;
        $this->message = $message;
    }
}