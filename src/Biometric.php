<?php

namespace IDAnalyzer2;

require("Common.php");

use Exception;
use InvalidArgumentException;
use IDAnalyzer2\Profile;

class Biometric
{

    private $throwError = false;
    private $config = array(
        "profile" => "",
        "profileOverride" => array(),
        "customData" => "",
        "client" => "php-sdk"
    );

    /**
     * Initialize Face API
     * @return void
     * @throws Exception
     */
    function __construct()
    {
        if(getIDAnalyzerAPIKey() == "") throw new Exception("Please set API key via environment variable 'IDANALYZER_KEY'");
    }


    /**
     * Set an API parameter and its value, this function allows you to set any API parameter without using the built-in functions
     * @param string $parameterKey Parameter key
     * @param string $parameterValue Parameter value
     * @return void
     */
    public function setParameter($parameterKey, $parameterValue)
    {
        $this->config[$parameterKey] = $parameterValue;
    }


    /**
     * Whether an exception should be thrown if API response contains an error message
     * @param bool $throwException Throw exception upon API error, defaults to false
     * @return void
     */
    public function throwAPIException($throwException = false)
    {
        $this->throwError = $throwException == true;
    }


    /**
     * Set an arbitrary string you wish to save with the transaction. e.g Internal customer reference number
     * @param string $customData
     * @return void
     */
    public function setCustomData($customData)
    {
        $this->config['customData'] = (string)$customData;
    }


    /**
     * Set KYC Profile
     * @param Profile $profile KYCProfile object
     * @return void
     * @throws InvalidArgumentException
     */
    public function setProfile($profile)
    {

        if ($profile instanceof Profile) {
            $this->config['profile'] = $profile->profileId;
            if(count($profile->profileOverride)>0){
                $this->config['profileOverride'] = $profile->profileOverride;
            }else{
                unset($this->config['profileOverride']);
            }
        }else{
            throw new InvalidArgumentException("Provided profile is not a 'KYCProfile' object.");
        }
    }


    /**
     * Perform 1:1 face verification using selfie photo or selfie video, against a reference face image.
     * @param string $referenceFaceImage Front of Document (file path, base64 content, url, or cache reference)
     * @param string $facePhoto Face Photo (file path, base64 content or URL, or cache reference)
     * @param string $faceVideo Face Video (file path, base64 content or URL)
     * @return array
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function verifyFace($referenceFaceImage, $facePhoto = "", $faceVideo = ""){

        if($this->config['profile']==""){
            throw new InvalidArgumentException("KYC Profile not configured, please use setProfile before calling this function.");
        }

        $payload = $this->config;

        if($referenceFaceImage == "") {
            throw new InvalidArgumentException("Reference face image required.");
        }
        if($facePhoto == "" && $faceVideo == ""){
            throw new InvalidArgumentException("Verification face image required.");
        }

        $payload['reference'] = parseInput($referenceFaceImage, true);


        if($facePhoto != ""){
            $payload['face'] = parseInput($facePhoto, true);
        }else if($faceVideo != ""){
            $payload['faceVideo'] = parseInput($faceVideo);
        }

        return callIDAnalyzerAPI("POST", "face", $payload, 30, $this->throwError);

    }

    /**
     * Perform standalone liveness check on a selfie photo or video.
     * @param string $facePhoto Face Photo (file path, base64 content or URL, or cache reference)
     * @param string $faceVideo Face Video (file path, base64 content or URL)
     * @return array
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function verifyLiveness($facePhoto = "", $faceVideo = ""){

        if($this->config['profile']==""){
            throw new InvalidArgumentException("KYC Profile not configured, please use setProfile before calling this function.");
        }

        $payload = $this->config;


        if($facePhoto == "" && $faceVideo == ""){
            throw new InvalidArgumentException("Verification face image required.");
        }

        if($facePhoto != ""){
            $payload['face'] = parseInput($facePhoto, true);
        }else if($faceVideo != ""){
            $payload['faceVideo'] = parseInput($faceVideo);
        }

        return callIDAnalyzerAPI("POST", "liveness", $payload, 30, $this->throwError);


    }

}