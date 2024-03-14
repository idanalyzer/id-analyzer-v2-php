<?php

namespace IDAnalyzer2;

class ApiError {
    public int $status;
    public string $code;
    public string $message;

    public function __construct(int $status, string $code, string $message) {
        $this->status = $status;
        $this->code = $code;
        $this->message = $message;
    }
}