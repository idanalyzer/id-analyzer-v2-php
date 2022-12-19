<?php

namespace IDAnalyzer2;

use Exception;
use InvalidArgumentException;

class Profile
{
    public static $SECURITY_NONE = "security_none";
    public static $SECURITY_LOW = "security_low";
    public static $SECURITY_MEDIUM = "security_medium";
    public static $SECURITY_HIGH = "security_high";
    private $URL_VALIDATION_REGEX = "#(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))#iS";

    public $profileId = "";
    public $profileOverride = array();


    /**
     * Initialize KYC Profile
     * @param string $profileId Custom profile ID or preset profile (security_none, security_low, security_medium, security_high). SECURITY_NONE will be used if left blank.
     * @throws Exception
     */
    function __construct($profileId)
    {
        if(getIDAnalyzerAPIKey() == "") throw new Exception("Please set API key via environment variable 'IDANALYZER_KEY'");
        if($profileId == "") $profileId = Profile::$SECURITY_NONE;
        $this->profileId = $profileId;
    }


    /**
     * Set profile configuration with provided JSON string
     * @param string $jsonString JSON string containing profile information
     * @return void
     */
    public function loadFromJson($jsonString)
    {
        $this->profileOverride = json_decode($jsonString, true);
    }


    /**
     * Canvas Size in pixels, input image larger than this size will be scaled down before further processing, reduced image size will improve inference time but reduce result accuracy. Set 0 to disable image resizing.
     * @param int $pixels
     * @return void
     */
    public function canvasSize($pixels)
    {
        $this->profileOverride['canvasSize'] = (int)$pixels;
    }

    /**
     * Correct image orientation for rotated images
     * @param boolean $enabled
     * @return void
     */
    public function orientationCorrection($enabled)
    {
        $this->profileOverride['orientationCorrection'] = $enabled === true;
    }


    /**
     * Enable to automatically detect and return the locations of signature, document and face.
     * @param boolean $enabled
     * @return void
     */
    public function objectDetection($enabled)
    {
        $this->profileOverride['objectDetection'] = $enabled === true;
    }


    /**
     * Enable to parse AAMVA barcode for US/CA ID/DL. Disable this to improve performance if you are not planning on scanning ID/DL from US or Canada.
     * @param boolean $enabled
     * @return void
     */
    public function AAMVABarcodeParsing($enabled)
    {
        $this->profileOverride['AAMVABarcodeParsing'] = $enabled === true;
    }

    /**
     * Whether scan transaction results and output images should be saved on cloud
     * @param boolean $enableSaveTransaction
     * @param boolean $enableSaveTransactionImages
     * @return void
     */
    public function saveResult($enableSaveTransaction, $enableSaveTransactionImages)
    {
        $this->profileOverride['saveResult'] = $enableSaveTransaction === true;
        if ($enableSaveTransaction === true) {
            $this->profileOverride['saveImage'] = $enableSaveTransactionImages === true;
        }
    }

    /**
     * Whether to return output image as part of API response
     * @param boolean $enableOutputImage
     * @param string $outputFormat "url" or "base64"
     * @return void
     */
    public function outputImage($enableOutputImage, $outputFormat = "url")
    {
        $this->profileOverride['outputImage'] = $enableOutputImage === true;
        if ($enableOutputImage === true) {
            $this->profileOverride['outputType'] = $outputFormat;
        }
    }

    /**
     * Crop image before saving and returning output
     * @param boolean $enableAutoCrop Enable to automatically remove any irrelevant pixels from the uploaded image before saving and outputting the final image.
     * @param boolean $enableAdvancedAutoCrop Enable to use advanced deskew feature on documents that are sheared.
     * @return void
     */
    public function autoCrop($enableAutoCrop, $enableAdvancedAutoCrop)
    {
        $this->profileOverride['crop'] = $enableAutoCrop === true;
        $this->profileOverride['advancedCrop'] = $enableAdvancedAutoCrop === true;
    }

    /**
     * Maximum width/height in pixels for output and saved image.
     * @param int $pixels
     * @return void
     */
    public function outputSize($pixels)
    {
        $this->profileOverride['outputSize'] = (int)$pixels;
    }


    /**
     * Generate a full name field using parsed first name, middle name and last name.
     * @param boolean $enabled
     * @return void
     */
    public function inferFullName($enabled)
    {
        $this->profileOverride['inferFullName'] = $enabled === true;
    }

    /**
     * If first name contains more than one word, move second word onwards into middle name field.
     * @param boolean $enabled
     * @return void
     */
    public function splitFirstName($enabled)
    {
        $this->profileOverride['splitFirstName'] = $enabled === true;
    }


    /**
     * Enable to generate a detailed PDF audit report for every transaction.
     * @param boolean $enabled
     * @return void
     */
    public function transactionAuditReport($enabled)
    {
        $this->profileOverride['transactionAuditReport'] = $enabled === true;
    }


    /**
     * Set timezone for audit reports. If left blank, UTC will be used. Refer to https://en.wikipedia.org/wiki/List_of_tz_database_time_zones TZ database name list.
     * @param string $timezone
     * @return void
     */
    public function setTimezone($timezone)
    {
        $this->profileOverride['timezone'] = (string)$timezone;
    }


    /**
     * A list of data fields key to be redacted before transaction storage, these fields will also be blurred from output & saved image.
     * @param array $fieldKeys
     * @throws InvalidArgumentException
     * @return void
     */
    public function obscure($fieldKeys)
    {
        if(!is_array($fieldKeys)){
            throw new InvalidArgumentException("Field keys should be an array of strings.");
        }
        $this->profileOverride['obscure'] = $fieldKeys;
    }

    /**
     * Enter a server URL to listen for Docupass verification and scan transaction results
     * @param string $url
     * @throws InvalidArgumentException
     * @return void
     */
    public function webhook($url = "https://www.example.com/webhook.php")
    {
        if (!preg_match($this->URL_VALIDATION_REGEX, $url)) {
            throw new InvalidArgumentException("Invalid URL format");
        }

        $urlinfo = parse_url($url);

        if(filter_var($urlinfo['host'], FILTER_VALIDATE_IP)) {
            if(!filter_var(
                $urlinfo['host'],
                FILTER_VALIDATE_IP,
                FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE |  FILTER_FLAG_NO_RES_RANGE
            )){
                throw new InvalidArgumentException("Invalid URL, the host does not appear to be a remote host.");
            }
        }
        if(strtolower($urlinfo['host'])=='localhost'){
            throw new InvalidArgumentException("Invalid URL, the host does not appear to be a remote host.");
        }
        if($urlinfo['scheme']!='http' && $urlinfo['scheme']!='https'){
            throw new InvalidArgumentException("Invalid URL, only http and https protocols are allowed.");
        }

        $this->profileOverride['webhook'] = (string)$url;
    }


    /**
     * Set validation threshold of a specified component
     * @param string $thresholdKey
     * @param float $thresholdValue
     * @return void
     */
    public function threshold($thresholdKey, $thresholdValue)
    {
        $this->profileOverride['thresholds'][$thresholdKey] = (float)$thresholdValue;
    }


    /**
     * Set decision trigger value
     * @param int $reviewTrigger If the final total review score is equal to or greater than this value, the final KYC decision will be "review"
     * @param int $rejectTrigger If the final total review score is equal to or greater than this value, the final KYC decision will be "reject". Reject has higher priority than review.
     * @return void
     */
    public function decisionTrigger($reviewTrigger = 1, $rejectTrigger = 1)
    {
        $this->profileOverride['decisionTrigger']["review"] = (int)$reviewTrigger;
        $this->profileOverride['decisionTrigger']["reject"] = (int)$rejectTrigger;
    }

    /**
     * Enable/Disable and fine-tune how each Document Validation Component affects the final decision.
     * @param int $code Document Validation Component Code / Warning Code
     * @param bool $enabled Enable the current Document Validation Component
     * @param float $reviewThreshold If the current validation has failed to pass, and the specified number is greater than or equal to zero, and the confidence of this warning is greater than or equal to the specified value, the "total review score" will be added by the weight value.
     * @param float $rejectThreshold If the current validation has failed to pass, and the specified number is greater than or equal to zero, and the confidence of this warning is greater than or equal to the specified value, the "total reject score" will be added by the weight value.
     * @param int $weight Weight to add to the total review and reject score if the validation has failed to pass.
     * @return void
     */
    public function setWarning($code = "UNRECOGNIZED_DOCUMENT", $enabled = true, $reviewThreshold = -1, $rejectThreshold = 0, $weight = 1)
    {
        $this->profileOverride['decisions'][$code] = array(
            "enabled"=>$enabled === true,
            "review"=>(float)$reviewThreshold,
            "reject"=>(float)$rejectThreshold,
            "weight"=>(int)$weight
        );
    }

    /**
     * Check if the document was issued by specified countries. Separate multiple values with comma. For example "US,CA" would accept documents from the United States and Canada.
     * @param string $countryCodes ISO ALPHA-2 Country Code separated by comma
     * @return void
     */
    public function restrictDocumentCountry($countryCodes = "US,CA,UK")
    {
        if($countryCodes == ""){
            $this->profileOverride['acceptedDocuments']['documentCountry'] = "";
        }else{
            $this->profileOverride['acceptedDocuments']['documentCountry'] = (string)$countryCodes;
        }
    }

    /**
     * Check if the document was issued by specified state. Separate multiple values with comma. For example "CA,TX" would accept documents from California and Texas.
     * @param string $states State full name or abbreviation separated by comma
     * @return void
     */
    public function restrictDocumentState($states = "CA,TX")
    {
        if($states == ""){
            $this->profileOverride['acceptedDocuments']['documentState']  = "";
        }else{
            $this->profileOverride['acceptedDocuments']['documentState']  = (string)$states;
        }

    }

    /**
     * Check if the document was one of the specified types. For example, "PD" would accept both passport and driver license.
     * @param string $documentType P: Passport, D: Driver's License, I: Identity Card
     * @return void
     */
    public function restrictDocumentType($documentType = "DIP")
    {
        if($documentType == ""){
            $this->profileOverride['acceptedDocuments']['documentType']  = "";
        }else{
            $this->profileOverride['acceptedDocuments']['documentType']  = (string)$documentType;
        }

    }




}