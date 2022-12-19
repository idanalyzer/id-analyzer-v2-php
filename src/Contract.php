<?php

namespace IDAnalyzer2;

require("Common.php");

use Exception;
use InvalidArgumentException;

class Contract
{

    private $throwError = false;

    /**
     * Initialize Contract API
     * @return void
     * @throws Exception
     */
    function __construct()
    {
        if(getIDAnalyzerAPIKey() == "") throw new Exception("Please set API key via environment variable 'IDANALYZER_KEY'");
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
     * Generate document using template and transaction data
     * @param string $templateId Template ID
     * @param string $format PDF, DOCX or HTML
     * @param string $transactionId Fill the template with data from specified transaction
     * @param array $fillData Array data in key-value pairs to autofill dynamic fields, data from user ID will be used first in case of a conflict. For example, passing {"myparameter":"abc"} would fill %{myparameter} in contract template with "abc".
     * @return array
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function generate($templateId, $format = "PDF", $transactionId = "", $fillData = array()){
        $payload = array("format"=>$format);
        if($templateId == ""){
            throw new InvalidArgumentException("Template ID required.");
        }else{
            $payload['templateId'] = $templateId;
        }
        if($transactionId != ""){
            $payload['transactionId'] = $transactionId;
        }

        if(is_array($fillData)){
            if(count($fillData)>0){
                $payload['fillData'] = $fillData;
            }
        }else{
            throw new InvalidArgumentException("fillData should be an array.");
        }

        return callIDAnalyzerAPI("POST", "generate", $payload, 30, $this->throwError);
    }



    /**
     * Retrieve a list of contract templates
     * @param integer $order Sort results by newest(-1) or oldest(1)
     * @param integer $limit Number of items to be returned per call
     * @param integer $offset Start the list from a particular entry index
     * @param string $filterTemplateId Filter result by template ID
     * @return array
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function listTemplate($order = -1, $limit = 10, $offset = 0, $filterTemplateId = ""){

        if($order !== 1 && $order !== -1){
            throw new InvalidArgumentException("'order' should be integer of 1 or -1.");
        }

        if(!is_numeric($limit) || $limit <= 0 || $limit >= 100){
            throw new InvalidArgumentException("'limit' should be a positive integer greater than 0 and less than or equal to 100.");
        }

        if(!is_numeric($offset)){
            throw new InvalidArgumentException("'offset' should be an integer.");
        }

        $payload = array(
            "order" => $order,
            "limit" => $limit,
            "offset" => $offset
        );

        if($filterTemplateId != ""){
            $payload["templateid"] = $filterTemplateId;
        }

        return callIDAnalyzerAPI("GET", "contract", $payload, 30, $this->throwError);

    }


    /**
     * Get contract template
     * @param string $templateId Template ID
     * @return array
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function getTemplate($templateId){

        if($templateId == ""){
            throw new InvalidArgumentException("Template ID required.");
        }

        return callIDAnalyzerAPI("GET", "contract/".$templateId, "", 30, $this->throwError);

    }


    /**
     * Delete contract template
     * @param string $templateId Template ID
     * @return array
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function deleteTemplate($templateId){

        if($templateId == ""){
            throw new InvalidArgumentException("Template ID required.");
        }

        return callIDAnalyzerAPI("DELETE", "contract/".$templateId, "", 30, $this->throwError);

    }

    /**
     * Create new contract template
     * @param string $name Template name
     * @param string $content Template HTML content
     * @param string $orientation 0=Portrait(Default) 1=Landscape
     * @param string $timezone Template timezone
     * @param string $font Template font
     * @return array
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function createTemplate($name, $content, $orientation="0", $timezone = "UTC", $font = "Open Sans"){

        if($name == ""){
            throw new InvalidArgumentException("Template name required.");
        }

        if($content == ""){
            throw new InvalidArgumentException("Template content required.");
        }

        $payload = array(
            "name" => $name,
            "content" => $content,
            "orientation" => $orientation,
            "timezone" => $timezone,
            "font" => $font
        );


        return callIDAnalyzerAPI("POST", "contract", $payload, 30, $this->throwError);

    }

    /**
     * Update contract template
     * @param string $templateId Template ID
     * @param string $name Template name
     * @param string $content Template HTML content
     * @param string $orientation 0=Portrait(Default) 1=Landscape
     * @param string $timezone Template timezone
     * @param string $font Template font
     * @return array
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function updateTemplate($templateId, $name, $content, $orientation="0", $timezone = "UTC", $font = "Open Sans"){

        if($templateId == ""){
            throw new InvalidArgumentException("Template ID required.");
        }

        if($name == ""){
            throw new InvalidArgumentException("Template name required.");
        }

        if($content == ""){
            throw new InvalidArgumentException("Template content required.");
        }

        $payload = array(
            "name" => $name,
            "content" => $content,
            "orientation" => $orientation,
            "timezone" => $timezone,
            "font" => $font
        );


        return callIDAnalyzerAPI("POST", "contract/".$templateId, $payload, 30, $this->throwError);

    }
}