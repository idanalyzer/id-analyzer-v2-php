<?php

require("src/Scanner.php");
require("src/Profile.php");
require("src/APIException.php");
use IDAnalyzer2\Scanner;
use IDAnalyzer2\APIException;
use IDAnalyzer2\Profile;

try {
    $profile = new Profile(Profile::$SECURITY_MEDIUM);
    $scan = new Scanner();
    $scan->throwAPIException(true);
    print_r($result = $scan->quickScan("05.jpg", "", true));
    $scan->setProfile($profile);
    print_r($result = $scan->scan("05.jpg"));
} catch (APIException $e) {
    print_r($e->getMessage());
} catch (InvalidArgumentException $e) {
    print_r($e->getMessage());
} catch (\Exception $e) {
    print_r($e->getMessage());
}
