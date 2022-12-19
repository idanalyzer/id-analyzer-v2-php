<?php

require("src/Contract.php");
require("src/APIException.php");
use IDAnalyzer2\Contract;
use IDAnalyzer2\APIException;

try {
    $contract = new Contract();
    $contract->throwAPIException(true);
    $temp = $contract->createTemplate("tempName", "<p>%{fullName}</p>");
    $tempId = $temp['templateId'];
    print_r($temp);
    /*
    Array
    (
        [templateId] => V3BB49ZV2X1H
    )
    */

    print_r($contract->updateTemplate($tempId, "oldTemp", "<p>%{fullName}</p><p>Hello!!</p>"));
    print_r($contract->getTemplate($tempId));
    /*
        {"id":"V3BB49ZV2X1H","name":"oldTemp","content":"PHA+JXtmdWxsTmFtZX08L3A+PHA+SGVsbG8hITwvcD4=","orientation":"0","timezone":"UTC","font":"Open Sans","createdAt":1648547638,"updatedAt":1648547734}
    */
    print_r($contract->listTemplate());
    /*
Array
(
    [limit] => 10
    [offset] => 0
    [total] => 5
    [items] => Array
        (
            [0] => Array
                (
                    [id] => V3BB49ZV2X1H
                    [name] => oldTemp
                    [createdAt] => 1648547638
                    [updatedAt] => 1648547734
                )

            [1] => Array
                (
                    [id] => F5HCKJZ5RFT8
                    [name] => asdascqwcqwc
                    [createdAt] => 1647599406
                    [updatedAt] => 1647599406
                )

            [2] => Array
                (
                    [id] => ZJFNXW6YFKRR
                    [name] => Template
                    [createdAt] => 1646910995
                    [updatedAt] => 1646910995
                )

            [3] => Array
                (
                    [id] => ZT9EHVK8TDAA
                    [name] => Test Temp
                    [createdAt] => 1646638387
                    [updatedAt] => 1646730815
                )

            [4] => Array
                (
                    [id] => PZS82DFXX1UL
                    [name] => wqdqwd
                    [createdAt] => 1646638382
                    [updatedAt] => 1646638382
                )

        )

)
    */
    print_r($contract->generate($tempId, "PDF", "", [
        'fullName' => 'Tian',
    ]));
    /*
Array
(
    [success] => 1
    [outputFile] => Array
        (
            [0] => Array
                (
                    [name] => oldTemp
                    [fileName] => oldtemp_17xjF3KtrK95T8cwLQLPS3eyrQpWADJx.pdf
                    [fileUrl] => https://v2-us1.idanalyzer.com/filevault/oldtemp_17xjF3KtrK95T8cwLQLPS3eyrQpWADJx.pdf
                )

        )

    [executionTime] => 0.593211938
)
    */
    print_r($contract->deleteTemplate($tempId));
} catch (APIException $e) {
    print_r($e->getMessage());
} catch (InvalidArgumentException $e) {
    print_r($e->getMessage());
} catch (\Exception $e) {
    print_r($e->getMessage());
}