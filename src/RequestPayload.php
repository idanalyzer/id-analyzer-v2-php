<?php

namespace IDAnalyzer2;
use IDAnalyzer2\SDKException;
trait RequestPayload
{
    /*
     * ["name" => Field(), "name" => Field(), ...]
     * */
    protected array $payload = [];

    public static function Field($name, $vType, $required = false, $default=null, $desc = ""): array {
        return [
            "name" => $name,
            "value" => $default,
            "vType" => $vType,
            "required" => $required,
            "desc" => $desc,
            "type" => "field"
        ];
    }

    public static function QueryParam($name, $vType, $required = false, $default=null, $desc = ""): array {
        return [
            "name" => $name,
            "value" => $default,
            "vType" => $vType,
            "required" => $required,
            "desc" => $desc,
            "type" => "query_param"
        ];
    }

    public static function RouteParam($name, $vType, $required = false, $default=null, $desc = ""): array {
        return [
            "name" => $name,
            "value" => $default,
            "vType" => $vType,
            "required" => $required,
            "desc" => $desc,
            "type" => "route_param"
        ];
    }

    public function initFields($fields = []) {
        foreach($fields as $field) {
            $this->payload[$field['name']] = $field;
        }
    }

    public function __get($name) {
        if(array_key_exists($name, $this->payload)) {
            return $this->payload[$name]["value"];
        } else {
            throw new SDKException("field name $name does not exist.");
        }
    }

    public function __set($name, $value) {
        if(array_key_exists($name, $this->payload)) {
            $this->payload[$name]["value"] = $value;
        } else {
            throw new SDKException("field name $name does not exist.");
        }
    }

    public function details(): string {
        $r = "";
        foreach($this->payload as $v) {
            $r .= $v["name"] . " (" . $v["type"] . ") " . ($v["required"] ? "required" : "optional") . " - " . $v["desc"] . "\n";
        }
        return $r;
    }

    public function json():array {
        $r = [];
        foreach($this->payload as $v) {
            if($v === null) continue;
            if($v['type'] !== 'field') continue;

            $r[$v["name"]] = $v["value"];
        }
        return $r;
    }

    public function query(): array {
        $r = [];
        foreach($this->payload as $v) {
            if($v === null) continue;
            if($v['type'] !== 'query_param') continue;

            $r[$v["name"]] = $v["value"];
        }
        return $r;
    }

    public function route(): array {
        $r = [];
        foreach($this->payload as $v) {
            if($v === null) continue;
            if($v['type'] !== 'route_param') continue;

            $r[$v["name"]] = $v["value"];
        }
        return $r;
    }

    public function validate() {
        foreach($this->payload as $field) {
            if($field["required"] && $field["value"] === null) {
                throw new SDKException("Field " . $field["name"] . " is required.");
            }
        }
    }
}