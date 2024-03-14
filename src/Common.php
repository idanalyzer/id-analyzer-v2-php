<?php

namespace IDAnalyzer2;

use DateTime;
use Exception;
use InvalidArgumentException;

class Common
{


    public static function mergeHttpPath($path1, $path2)
    {
        if ($path2 === "") return $path1;
        $paths = func_get_args();
        $last_key = func_num_args() - 1;
        array_walk($paths, function (&$val, $key) use ($last_key) {
            switch ($key) {
                case 0:
                    $val = rtrim($val, '/ ');
                    break;
                case $last_key:
                    $val = ltrim($val, '/ ');
                    break;
                default:
                    $val = trim($val, '/ ');
                    break;
            }
        });

        $first = array_shift($paths);
        $last = array_pop($paths);
        $paths = array_filter($paths); // clean empty elements to prevent double slashes
        array_unshift($paths, $first);
        $paths[] = $last;
        return implode('/', $paths);
    }

    public static function parseInput($str, $allowCache = false)
    {
        if ($allowCache && substr($str, 0, 4) === "ref:") {
            return $str;
        } else if (filter_var($str, FILTER_VALIDATE_URL)) {
            return $str;
        } else if (file_exists($str)) {
            return base64_encode(file_get_contents($str));
        } else if (strlen($str) > 100) {
            return $str;
        } else {
            throw new InvalidArgumentException("Invalid input image, file not found or malformed URL.");
        }
    }

    public static function getIDAnalyzerAPIKey()
    {
        return getenv('IDANALYZER_KEY', true) ?: getenv('IDANALYZER_KEY');
    }

    public static function getIDAnalyzerEndpoint($requestUri)
    {
        if (substr(strtolower($requestUri), 0, 4) == "http") {
            return $requestUri;
        }
        $region = getenv('IDANALYZER_REGION', true) ?: getenv('IDANALYZER_REGION');
        if (strtolower($region) === 'eu') {
            return Common::mergeHttpPath("https://api2-eu.idanalyzer.com/", $requestUri);
        } else if (substr(strtolower($region), 0, 4) == "http") {
            return Common::mergeHttpPath($region, $requestUri);
        } else {
            return Common::mergeHttpPath("https://v2-us1.idanalyzer.com/", $requestUri);
        }
    }


    /**
     * @throws APIException
     * @throws Exception
     */
    public static function callIDAnalyzerAPI($method, $path, $payload, $timeout = 60, $throwException = false, $saveFile = false)
    {

        $ch = curl_init();
        $url = Common::getIDAnalyzerEndpoint($path);

        if (is_array($payload)) {
            if ($method == "GET") {
                $url .= "?" . http_build_query($payload);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            }
        }
        $header = [
            'X-Api-Key: ' . Common::getIDAnalyzerAPIKey(),
        ];
        if ($saveFile != false) {
            $out = fopen($saveFile, "wb");
            curl_setopt($ch, CURLOPT_FILE, $out);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
        } else {
            curl_setopt($ch, CURLOPT_FAILONERROR, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'X-Api-Key: ' . Common::getIDAnalyzerAPIKey()));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);


        if (getenv('IDANALYZER_INSECURESSL') == "1") {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        }

        $response = curl_exec($ch);

        if (curl_error($ch) || curl_errno($ch)) {
            throw new Exception("Failed to connect to ID Analyzer API server: " . curl_error($ch) . " (" . curl_errno($ch) . ")");
        } else {
            if (!$saveFile) {
                $result = json_decode($response, true);

                if ($throwException) {
                    if (isset($result['error']) && is_array($result['error'])) {
                        throw new APIException($result['error']['message'], $result['error']['code']);
                    } else {
                        return $result;
                    }
                } else {
                    return $result;
                }
            }
        }
    }

    public static function isTimestamp($string)
    {
        try {
            new DateTime('@' . $string);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
}




