<?php

namespace IDAnalyzer2;
require "Common.php";
use Exception;
use InvalidArgumentException;

class Transaction
{

    private $throwError = false;


    /**
     * Initialize Transaction API
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
     * Retrieve a single transaction record
     * @param string $transactionId Transaction ID
     * @return array
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function getTransaction($transactionId){

        if($transactionId == ""){
            throw new InvalidArgumentException("Transaction ID required.");
        }

        return callIDAnalyzerAPI("GET", "transaction/".$transactionId, "", 30, $this->throwError);

    }


    /**
     * Retrieve a list of transaction history
     * @param integer $order Sort results by newest(-1) or oldest(1)
     * @param integer $limit Number of items to be returned per call
     * @param integer $offset Start the list from a particular entry index
     * @param integer $createdAtMin List transactions that were created after this timestamp
     * @param integer $createdAtMax List transactions that were created before this timestamp
     * @param string $filterCustomData Filter result by customData field
     * @param string $filterDecision Filter result by decision (accept, review, reject)
     * @param string $filterDocupass Filter result by Docupass reference
     * @param string $filterProfileId Filter result by KYC Profile ID
     * @return array
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function listTransaction($order = -1, $limit = 10, $offset = 0, $createdAtMin = 0, $createdAtMax = 0, $filterCustomData = "", $filterDecision = "", $filterDocupass = "", $filterProfileId = ""){

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

        if($createdAtMin > 0){
            if(isTimestamp($createdAtMin)){
                $payload["createdAtMin"] = $createdAtMin;
            }else{
                throw new InvalidArgumentException("'createdAtMin' should be a valid timestamp.");
            }
        }
        if($createdAtMax > 0){
            if(isTimestamp($createdAtMax)){
                $payload["createdAtMax"] = $createdAtMax;
            }else{
                throw new InvalidArgumentException("'createdAtMax' should be a valid timestamp.");
            }
        }
        if($filterCustomData != ""){
            $payload["customData"] = $filterCustomData;
        }
        if($filterDocupass != ""){
            $payload["docupass"] = $filterDocupass;
        }
        if($filterDecision != ""){
            $payload["decision"] = $filterDecision;
        }
        if($filterProfileId != ""){
            $payload["profileId"] = $filterProfileId;
        }



        return callIDAnalyzerAPI("GET", "transaction", $payload, 30, $this->throwError);

    }


    /**
     * Update transaction decision, updated decision will be relayed to webhook if set.
     * @param string $transactionId Transaction ID
     * @param string $decision New decision (accept, review or reject)
     * @return array
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function updateTransaction($transactionId, $decision){

        if($transactionId == ""){
            throw new InvalidArgumentException("Transaction ID required.");
        }
        if($decision !== "accept" && $decision !== "review" && $decision !== "reject"){
            throw new InvalidArgumentException("'decision' should be either accept, review or reject.");
        }

        return callIDAnalyzerAPI("PATCH", "transaction/".$transactionId, [
            'decision' => $decision,
        ], 30, $this->throwError);

    }


    /**
     * Delete a transaction
     * @param string $transactionId Transaction ID
     * @return array
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function deleteTransaction($transactionId){

        if($transactionId == ""){
            throw new InvalidArgumentException("Transaction ID required.");
        }

        return callIDAnalyzerAPI("DELETE", "transaction/".$transactionId, "", 30, $this->throwError);

    }


    /**
     * Download transaction image onto local file system
     * @param string $imageToken Image token from transaction API response
     * @param string $destination Full destination path including file name, file extension should be jpg, for example: '\home\idcard.jpg'
     * @return void
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function saveImage($imageToken, $destination){

        if($imageToken == ""){
            throw new InvalidArgumentException("'imageToken' required.");
        }

        if($destination == ""){
            throw new InvalidArgumentException("'destination' required.");
        }

        return callIDAnalyzerAPI("GET", "imagevault/".$imageToken, "", 30, $this->throwError, $destination);

    }


    /**
     * Download transaction file onto local file system using secured file name obtained from transaction
     * @param string $fileName Secured file name
     * @param string $destination Full destination path including file name, for example: '\home\auditreport.pdf'
     * @return void
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function saveFile($fileName, $destination){

        if($fileName == ""){
            throw new InvalidArgumentException("'fileName' required.");
        }

        if($destination == ""){
            throw new InvalidArgumentException("'destination' required.");
        }

        return callIDAnalyzerAPI("GET", "filevault/".$fileName, "", 30, $this->throwError, $destination);
    }


    /**
     * Download transaction archive onto local file system
     * @param string $destination Full destination path including file name, file extension should be zip, for example: '\home\archive.zip'
     * @param string $exportType 'csv' or 'json'
     * @param bool $ignoreUnrecognized Ignore unrecognized documents
     * @param bool $ignoreDuplicate Ignore duplicated entries
     * @param array $transactionId Export only the specified transaction IDs
     * @param integer $createdAtMin Export only transactions that were created after this timestamp
     * @param integer $createdAtMax Export only transactions that were created before this timestamp
     * @param string $filterCustomData Filter export by customData field
     * @param string $filterDecision Filter export by decision (accept, review, reject)
     * @param string $filterDocupass Filter export by Docupass reference
     * @param string $filterProfileId Filter export by KYC Profile ID
     * @return void
     * @throws InvalidArgumentException
     * @throws APIException
     * @throws Exception
     */
    public function exportTransaction($destination, $transactionId = array(), $exportType = "csv", $ignoreUnrecognized = false, $ignoreDuplicate = false, $createdAtMin = 0, $createdAtMax = 0, $filterCustomData = "", $filterDecision = "", $filterDocupass = "", $filterProfileId = ""){

        if($destination == ""){
            throw new InvalidArgumentException("'destination' required.");
        }

        if($exportType != "csv" && $exportType != "json"){
            throw new InvalidArgumentException("'exportType' should be either 'json' or 'csv'.");
        }

        $payload = array(
            "exportType" => $exportType,
            "ignoreUnrecognized" => $ignoreUnrecognized,
            "ignoreDuplicate" => $ignoreDuplicate
        );

        if(is_array($transactionId) && count($transactionId) > 0){
            $payload["transactionId"] = $transactionId;
        }

        if($createdAtMin > 0){
            if(isTimestamp($createdAtMin)){
                $payload["createdAtMin"] = $createdAtMin;
            }else{
                throw new InvalidArgumentException("'createdAtMin' should be a valid timestamp.");
            }
        }

        if($createdAtMax > 0){
            if(isTimestamp($createdAtMax)){
                $payload["createdAtMax"] = $createdAtMax;
            }else{
                throw new InvalidArgumentException("'createdAtMax' should be a valid timestamp.");
            }
        }

        if($filterCustomData != ""){
            $payload["customData"] = $filterCustomData;
        }
        if($filterDocupass != ""){
            $payload["docupass"] = $filterDocupass;
        }
        if($filterDecision != ""){
            $payload["decision"] = $filterDecision;
        }
        if($filterProfileId != ""){
            $payload["profileId"] = $filterProfileId;
        }
        $result = callIDAnalyzerAPI("POST", "export/transaction", $payload, 300, $this->throwError);

        if($result["Url"] != ""){
            callIDAnalyzerAPI("GET", $result["Url"], "", 300, $this->throwError, $destination);
        }
    }
}