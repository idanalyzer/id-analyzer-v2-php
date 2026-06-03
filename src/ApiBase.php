<?php

namespace IDAnalyzer2;

/**
 * Base class for every API request object.
 *
 * Concrete request classes (e.g. QuickScan, LsTransaction) extend this class,
 * declare their endpoint {@see $uri} and HTTP {@see $method}, and register their
 * fields through the {@see RequestPayload} trait. The {@see Client} consumes the
 * resulting object via {@see Client::Do()}.
 */
class ApiBase
{

    use RequestPayload;

    public string $uri;
    public string $method;

    public bool $isFile = false;

    /**
     * Build the Guzzle request options for this request.
     *
     * Combines the JSON body fields and query parameters registered on this
     * request into the array shape expected by Guzzle (`json` and/or `query`).
     *
     * @return array The Guzzle request options (may contain `json` and `query` keys).
     */
    public function options(): array
    {
        $json  = $this->json();
        $query = $this->query();
        $op    = [];
        if ($json) {
            $op['json'] = $json;
        }
        if ($query) {
            $op['query'] = $query;
        }

        return $op;
    }

    /**
     * Resolve the request URI by substituting its route parameters.
     *
     * Replaces every `{name}` placeholder in {@see $uri} with the value of the
     * matching route parameter registered on this request.
     *
     * @return string The fully resolved request URI with route parameters substituted.
     */
    public function uriHook(): string
    {
        $uri    = $this->uri;
        $routes = $this->route();

        foreach ($routes as $name => $value) {
            $uri = str_replace(
                "{".$name."}", $value,
                $uri
            );
        }

        return $uri;
    }

}