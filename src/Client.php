<?php

namespace IDAnalyzer2;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use IDAnalyzer2\ApiError;
use Psr\Http\Message\UriInterface;

/**
 * HTTP client for the ID Analyzer v2 API.
 *
 * Wraps a Guzzle client pre-configured with the regional base URI and API key
 * authentication header. Dispatch request objects (subclasses of {@see ApiBase})
 * through {@see Do()}.
 */
class Client extends GuzzleClient {
    const ZoneMap = [
        'us' => 'https://api2.idanalyzer.com',
        'eu' => 'https://api2-eu.idanalyzer.com',
    ];
    protected string $apiKey;

    /**
     * Create a new API client.
     *
     * @param string $apiKey Your ID Analyzer API key, sent as the `X-Api-Key` header.
     * @param string $zone   The regional zone to target; one of `us` or `eu`. Defaults to `us`.
     *
     * @throws SDKException If an unknown zone is supplied.
     */
    public function __construct($apiKey, $zone='us') {
        $this->apiKey = $apiKey;
        if(!array_key_exists($zone, self::ZoneMap)) {
            throw new SDKException("Invalid zone (valid zones: us, eu)");
        }
        parent::__construct([
            'base_uri' => self::ZoneMap[$zone],
            'headers' => [
                'X-Api-Key' => $this->apiKey,
            ],
        ]);
    }

    /**
     * Parse an HTTP response into a result/error tuple.
     *
     * Decodes the JSON response body. On an API-level failure (`success === false`)
     * the second tuple element is an {@see ApiError}; otherwise it is `null`. When
     * `$isFile` is true and the body is not JSON, the raw body is returned as the result.
     *
     * @param ResponseInterface $resp   The HTTP response to parse.
     * @param bool              $isFile Whether the response is expected to be a binary file rather than JSON. Defaults to false.
     *
     * @return array A two-element tuple `[mixed $result, ApiError|null $error]`.
     *
     * @throws SDKException If the response body is not valid JSON and `$isFile` is false.
     */
    protected function parseResponse(ResponseInterface $resp, bool $isFile = false): array {
        $body = $resp->getBody();
        $json = json_decode($body);
        if($json === null) {
            if($isFile) {
                return [$body, null];
            }
            throw new SDKException("Failed to parse response: " . $body);
        }
        if(isset($json->success) && $json->success === false) {
            return [null, new ApiError($json->error->status, $json->error->message, $json->error->code)];
        }
        return [$json, null];
    }

    /**
     * Validate and dispatch an API request.
     *
     * Validates the request object, sends it to the API using its HTTP method,
     * resolved URI and options, then parses the response.
     *
     * @param ApiBase $api The request object to execute (e.g. QuickScan, LsTransaction).
     *
     * @return array A two-element tuple `[mixed $result, ApiError|null $error]`.
     *
     * @throws GuzzleException If the underlying HTTP request fails at the transport level.
     * @throws SDKException    If request validation fails or the response cannot be parsed.
     */
    public function Do(ApiBase $api): array {
        $api->validate();
        $resp = $this->request($api->method, $api->uriHook(), $api->options());
        return $this->parseResponse($resp, $api->isFile);
    }
}