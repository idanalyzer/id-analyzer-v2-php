<?php

namespace IDAnalyzer2;
use IDAnalyzer2\SDKException;

/**
 * Provides field registration, magic accessors, validation and serialization
 * for API request objects.
 *
 * Used by {@see ApiBase}. Fields are declared with {@see Field()},
 * {@see QueryParam()} and {@see RouteParam()}, registered via {@see initFields()},
 * then read/written through PHP magic accessors and serialized into the JSON body,
 * query string and URI route parameters of an outgoing request.
 */
trait RequestPayload
{
    /*
     * ["name" => Field(), "name" => Field(), ...]
     * */
    protected array $payload = [];

    /**
     * Define a request body (JSON) field descriptor.
     *
     * @param string $name     The field name as sent in the request body.
     * @param string $vType    The value type (e.g. `string`, `integer`, `boolean`).
     * @param bool   $required Whether the field must be set before the request is sent. Defaults to false.
     * @param mixed  $default  The default value for the field. Defaults to null.
     * @param string $desc     A human-readable description of the field. Defaults to an empty string.
     *
     * @return array The field descriptor.
     */
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

    /**
     * Define a query-string parameter descriptor.
     *
     * @param string $name     The parameter name as sent in the query string.
     * @param string $vType    The value type (e.g. `string`, `integer`, `boolean`).
     * @param bool   $required Whether the parameter must be set before the request is sent. Defaults to false.
     * @param mixed  $default  The default value for the parameter. Defaults to null.
     * @param string $desc     A human-readable description of the parameter. Defaults to an empty string.
     *
     * @return array The query parameter descriptor.
     */
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

    /**
     * Define a URI route parameter descriptor.
     *
     * The value substitutes a `{name}` placeholder in the request URI when it is
     * resolved by {@see ApiBase::uriHook()}.
     *
     * @param string $name     The parameter name, matching a `{name}` placeholder in the URI.
     * @param string $vType    The value type (e.g. `string`, `integer`, `boolean`).
     * @param bool   $required Whether the parameter must be set before the request is sent. Defaults to false.
     * @param mixed  $default  The default value for the parameter. Defaults to null.
     * @param string $desc     A human-readable description of the parameter. Defaults to an empty string.
     *
     * @return array The route parameter descriptor.
     */
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

    /**
     * Register a set of field descriptors on this request.
     *
     * @param array $fields A list of descriptors created by {@see Field()}, {@see QueryParam()} or {@see RouteParam()}. Defaults to an empty array.
     *
     * @return void
     */
    public function initFields($fields = []) {
        foreach($fields as $field) {
            $this->payload[$field['name']] = $field;
        }
    }

    /**
     * Magic getter returning a registered field's current value.
     *
     * @param string $name The field name.
     *
     * @return mixed The current value of the field.
     *
     * @throws SDKException If no field with the given name is registered.
     */
    public function __get($name) {
        if(array_key_exists($name, $this->payload)) {
            return $this->payload[$name]["value"];
        } else {
            throw new SDKException("field name $name does not exist.");
        }
    }

    /**
     * Magic setter assigning a value to a registered field.
     *
     * @param string $name  The field name.
     * @param mixed  $value The value to assign.
     *
     * @return void
     *
     * @throws SDKException If no field with the given name is registered.
     */
    public function __set($name, $value) {
        if(array_key_exists($name, $this->payload)) {
            $this->payload[$name]["value"] = $value;
        } else {
            throw new SDKException("field name $name does not exist.");
        }
    }

    /**
     * Build a human-readable, multi-line description of every registered field.
     *
     * @return string One line per field listing its name, type, required/optional status and description.
     */
    public function details(): string {
        $r = "";
        foreach($this->payload as $v) {
            $r .= $v["name"] . " (" . $v["type"] . ") " . ($v["required"] ? "required" : "optional") . " - " . $v["desc"] . "\n";
        }
        return $r;
    }

    /**
     * Collect the registered body fields as a name/value map for the JSON request body.
     *
     * @return array A map of field name to current value for every `field`-type entry.
     */
    public function json():array {
        $r = [];
        foreach($this->payload as $v) {
            if($v === null) continue;
            if($v['type'] !== 'field') continue;

            $r[$v["name"]] = $v["value"];
        }
        return $r;
    }

    /**
     * Collect the registered query parameters as a name/value map for the query string.
     *
     * @return array A map of parameter name to current value for every `query_param`-type entry.
     */
    public function query(): array {
        $r = [];
        foreach($this->payload as $v) {
            if($v === null) continue;
            if($v['type'] !== 'query_param') continue;

            $r[$v["name"]] = $v["value"];
        }
        return $r;
    }

    /**
     * Collect the registered route parameters as a name/value map for URI substitution.
     *
     * @return array A map of parameter name to current value for every `route_param`-type entry.
     */
    public function route(): array {
        $r = [];
        foreach($this->payload as $v) {
            if($v === null) continue;
            if($v['type'] !== 'route_param') continue;

            $r[$v["name"]] = $v["value"];
        }
        return $r;
    }

    /**
     * Ensure every required field has been assigned a value.
     *
     * @return void
     *
     * @throws SDKException If a required field is still null.
     */
    public function validate() {
        foreach($this->payload as $field) {
            if($field["required"] && $field["value"] === null) {
                throw new SDKException("Field " . $field["name"] . " is required.");
            }
        }
    }
}