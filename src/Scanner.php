<?php

namespace IDAnalyzer2;
require "Common.php";
use DateTime;
use Exception;
use InvalidArgumentException;


class Scanner
{

    private $throwError = false;
    private $config = array(
        "document" => "",
        "documentBack" => "",
        "face" => "",
        "faceVideo" => "",
        "profile" => "",
        "profileOverride" => array(),
        "verifyName" => "",
        "verifyDob" => "",
        "verifyAge" => "",
        "verifyAddress" => "",
        "verifyPostcode" => "",
        "verifyDocumentNumber" => "",
        "restrictCountry" => "",
        "restrictState" => "",
        "restrictType" => "",
        "ip" => "",
        "customData" => "",
        "client" => "php-sdk"
    );

    /**
     * Initialize ID Analyzer Scan API
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
     * Pass in user IP address to check if ID is issued from the same country as the IP address, if no value is provided http connection IP will be used.
     * @param string $ip
     * @return void
     */
    public function setUserIP($ip)
    {
        $this->config['ip'] = (string)$ip;
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
     * Automatically generate contract document using value parsed from uploaded ID
     * @param string $templateId Enter up to 5 contract template ID (seperated by comma)
     * @param string $format PDF, DOCX or HTML
     * @param array $extraFillData Array data in key-value pairs to autofill dynamic fields, data from user ID will be used first in case of a conflict. For example, passing {"myparameter":"abc"} would fill %{myparameter} in contract template with "abc".
     * @return void
     */
    public function setContractOptions($templateId, $format = "PDF", $extraFillData = array())
    {
        if ($templateId!=""){
            $this->config['contractGenerate'] = $templateId;
            $this->config['contractFormat'] = $format;
            if(is_array($extraFillData)){
                if(count($extraFillData)>0){
                    $this->config['contractPrefill'] = $extraFillData;
                }else{
                    unset($this->config['contractPrefill']);
                }
            }else{
                throw new InvalidArgumentException("extraFillData should be an array.");
            }
        }else{
            unset($this->config['contractGenerate']);
            unset($this->config['contractFormat']);
            unset($this->config['contractPrefill']);
        }
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
     * Check if customer information matches with uploaded document
     * @param string $documentNumber Document or ID number
     * @param string $fullName Full name
     * @param string $dob Date of birth in YYYY/MM/DD
     * @param string $ageRange Age range, example: 18-40
     * @param string $address Address
     * @param string $postcode Postcode
     * @return void
     */
    public function verifyUserInformation($documentNumber = "X1234567", $fullName = "ELON MUSK", $dob = "1990/01/01", $ageRange = "18-99", $address = "123 Sample St, California, US", $postcode = "90001")
    {
        if($documentNumber == ""){
            $this->config['verifyDocumentNumber'] = "";
        }else{
            $this->config['verifyDocumentNumber'] = (string)$documentNumber;
        }
        if($fullName == ""){
            $this->config['verifyName'] = "";
        }else{
            $this->config['verifyName'] = (string)$fullName;
        }
        if($dob == ""){
            $this->config['verifyDob'] = "";
        }else{
            if(DateTime::createFromFormat('!Y/m/d', $dob) === false){
                throw new InvalidArgumentException("Invalid birthday format (YYYY/MM/DD)");
            }
            $this->config['verifyDob'] = (string)$dob;
        }
        if($ageRange == ""){
            $this->config['verifyAge'] = "";
        }else{
            if (!preg_match('/^\d+-\d+$/', $ageRange)) {
                throw new InvalidArgumentException("Invalid age range format (minAge-maxAge)");
            }

            $this->config['verifyAge'] = (string)$ageRange;
        }
        if($address == ""){
            $this->config['verifyAddress'] = "";
        }else{
            $this->config['verifyAddress'] = (string)$address;
        }
        if($postcode == ""){
            $this->config['verifyPostcode'] = "";
        }else{
            $this->config['verifyPostcode'] = (string)$postcode;
        }
    }



    /**
     * Check if the document was issued by specified countries. Separate multiple values with comma. For example "US,CA" would accept documents from the United States and Canada.
     * @param string $countryCodes ISO ALPHA-2 Country Code separated by comma
     * @return void
     */
    public function restrictCountry($countryCodes = "US,CA,UK")
    {
        if($countryCodes == ""){
            $this->config['restrictCountry'] = "";
        }else{
            $this->config['restrictCountry'] = (string)$countryCodes;
        }

    }

    /**
     * Check if the document was issued by specified state. Separate multiple values with comma. For example "CA,TX" would accept documents from California and Texas.
     * @param string $states State full name or abbreviation separated by comma
     * @return void
     */
    public function restrictState($states = "CA,TX")
    {
        if($states == ""){
            $this->config['restrictState'] = "";
        }else{
            $this->config['restrictState'] = (string)$states;
        }

    }

    /**
     * Check if the document was one of the specified types. For example, "PD" would accept both passport and driver license.
     * @param string $documentType P: Passport, D: Driver's License, I: Identity Card
     * @return void
     */
    public function restrictType($documentType = "DIP")
    {
        if($documentType == ""){
            $this->config['restrictType'] = "";
        }else{
            $this->config['restrictType'] = (string)$documentType;
        }

    }

     /**
     * Initiate a new identity document scan & ID face verification transaction by providing input images.
     * @param string $documentFront Front of Document (file path, base64 content, url, or cache reference)
     * @param string $documentBack Back of Document (file path, base64 content or URL, or cache reference)
     * @param string $facePhoto Face Photo (file path, base64 content or URL, or cache reference)
     * @param string $faceVideo Face Video (file path, base64 content or URL)
     * @return array
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function scan($documentFront, $documentBack = "", $facePhoto = "", $faceVideo = ""){

        if($this->config['profile']==""){
            throw new InvalidArgumentException("KYC Profile not configured, please use setProfile before calling this function.");
        }

        $payload = $this->config;

        if($documentFront == ""){
            throw new InvalidArgumentException("Primary document image required.");
        }

        $payload['document'] = parseInput($documentFront, true);

        if($documentBack != ""){
            $payload['documentBack'] = parseInput($documentBack, true);
        }

        if($facePhoto != ""){
            $payload['face'] = parseInput($facePhoto, true);
        }else if($faceVideo != ""){
            $payload['faceVideo'] = parseInput($faceVideo);
        }

        return callIDAnalyzerAPI("POST", "scan", $payload, 60, $this->throwError);

    }



    /**
     * Initiate a quick identity document OCR scan by providing input images.
     * @param string $documentFront Front of Document (file path, base64 content or URL)
     * @param string $documentBack Back of Document (file path, base64 content or URL)
     * @param boolean $cacheImage Cache uploaded image(s) for 24 hours and obtain a cache reference for each image, the reference hash can be used to start standard scan transaction without re-uploading the file.
     * @return array
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function quickScan($documentFront, $documentBack = "", $cacheImage = false){

        $payload = array("saveFile"=>$cacheImage ? true : false);
        if($documentFront == ""){
            throw new InvalidArgumentException("Primary document image required.");
        }

        $payload['document'] = parseInput($documentFront);

        if($documentBack != ""){
            $payload['documentBack'] = parseInput($documentBack);
        }
        return callIDAnalyzerAPI("POST", "quickscan", $payload, 60, $this->throwError);
    }





}