<?php
require("src/Docupass.php");
require("src/APIException.php");
use IDAnalyzer2\Docupass;
use IDAnalyzer2\APIException;

try {
    $docupass = new Docupass();
    $docupass->throwAPIException(true);
    print_r($docupass->createDocupass("bbd8436953ef426e98d078953f258835"));
    /*
    Array
    (
        [reference] => 4PDPN8DRYF17GTEGEUS1T1SN
        [url] => https://v2-us1.idanalyzer.com/verify/#4PDPN8DRYF17GTEGEUS1T1SN
        [expiry] => 0
        [customData] =>
        [qrCode] => base64
    )
    */
    print_r($docupass->listDocupass());
    print_r($docupass->deleteDocupass('4PDPN8DRYF17GTEGEUS1T1SN'));
} catch (APIException $e) {
    print_r($e->getMessage());
} catch (InvalidArgumentException $e) {
    print_r($e->getMessage());
} catch (\Exception $e) {
    print_r($e->getMessage());
}