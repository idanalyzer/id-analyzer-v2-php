<?php

namespace IDAnalyzer2;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use IDAnalyzer2\ApiError;
use Psr\Http\Message\UriInterface;

class Client extends GuzzleClient {
    const ZoneMap = [
        'us' => 'https://api2.idanalyzer.com',
        'eu' => 'https://api2-eu.idanalyzer.com',
    ];
    protected string $apiKey;

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
     * @throws GuzzleException
     * @throws SDKException
     */
    public function Do(ApiBase $api): array {
        $api->validate();
        $resp = $this->request($api->method, $api->uriHook(), $api->options());
        return $this->parseResponse($resp, $api->isFile);
    }
}