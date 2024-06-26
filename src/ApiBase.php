<?php

namespace IDAnalyzer2;

class ApiBase
{

    use RequestPayload;

    public string $uri;
    public string $method;

    public bool $isFile = false;

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