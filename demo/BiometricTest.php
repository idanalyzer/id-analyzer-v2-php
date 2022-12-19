<?php

require("src/Biometric.php");
require("src/Profile.php");
require("src/APIException.php");
use IDAnalyzer2\Biometric;
use IDAnalyzer2\Profile;
use IDAnalyzer2\APIException;

try {
    $profile = new Profile(Profile::$SECURITY_MEDIUM);
    $biometric = new Biometric();
    $biometric->throwAPIException(true);
    $biometric->setProfile($profile);
    print_r($biometric->verifyFace("./01.jpg", './02.jpg'));
    print_r($biometric->verifyLiveness("./10.jpg", './6.mp4'));
} catch (APIException $e) {
    print_r($e->getMessage());
} catch (InvalidArgumentException $e) {
    print_r($e->getMessage());
} catch (\Exception $e) {
    print_r($e->getMessage());
}