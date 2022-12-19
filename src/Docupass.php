<?php

namespace IDAnalyzer2;
require("Common.php");
use Exception;
use InvalidArgumentException;


class Docupass
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
     * Retrieve a list of Docupass
     * @param integer $order Sort results by newest(-1) or oldest(1)
     * @param integer $limit Number of items to be returned per call
     * @param integer $offset Start the list from a particular entry index
     * @return array
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function listDocupass($order = -1, $limit = 10, $offset = 0){

        if($order !== 1 && $order !== -1){
            throw new InvalidArgumentException("'order' should be integer of 1 or -1.");
        }

        if(!is_numeric($limit) || $limit <= 0 || $limit >= 100){
            throw new InvalidArgumentException("'limit' should be a positive integer greater than 0 and less than or equal to 100.");
        }

        if(!is_numeric($offset)){
            throw new InvalidArgumentException("'offset' should be an integer.");
        }

        $payload = [
            "order" => $order,
            "limit" => $limit,
            "offset" => $offset,
        ];

        return callIDAnalyzerAPI("GET", "docupass", $payload, 30, $this->throwError);
    }

    /**
     * @param $contractFormat
     * @param $contractGenerate
     * @param $contractPrefill
     * @param $contractSign
     * @param $customData
     * @param $language
     * @param $mode
     * @param $profile
     * @param $referenceDocument
     * @param $referenceDocumentBack
     * @param $referenceFace
     * @param $reusable
     * @param $userPhone
     * @param $verifyAddress
     * @param $verifyAge
     * @param $verifyDOB
     * @param $verifyDocumentNumber
     * @param $verifyName
     * @param $verifyPostcode
     * @return mixed|void
     * @throws APIException
     */
    public function createDocupass(
        $profile = null,
        $contractFormat = 'pdf', $contractGenerate='', $contractPrefill='',
        $contractSign = '', $customData = '', $language = '', $mode = 0,
        $referenceDocument = null, $referenceDocumentBack=null, $referenceFace=null,
        $reusable=false, $userPhone='', $verifyAddress='', $verifyAge='', $verifyDOB='',
        $verifyDocumentNumber='', $verifyName='', $verifyPostcode='') {
        $payload = [];
        $ref = new \ReflectionMethod(Docupass::class, 'createDocupass');
        foreach ($ref->getParameters() as $param) {
            $name = $param->getName();
            if(${$name} !== null && ${$name} !== '') {
                $payload[$name] = ${$name};
            }
        }

        return callIDAnalyzerAPI("POST", "docupass", $payload, 30, $this->throwError);
    }

    /**
     * @param $reference
     * @return mixed|void
     * @throws APIException
     */
    public function deleteDocupass($reference='') {
        if($reference === '')
            throw new InvalidArgumentException("'reference' is required.");

        return callIDAnalyzerAPI("DELETE", "docupass/$reference", null, 30, $this->throwError);
    }
}