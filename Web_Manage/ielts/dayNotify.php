<?php
include_once('_config.php');
set_time_limit(0);
ini_set('max_execution_time', 0); //0=NOLIMIT
$psid = post("psid", 1);
$errorhandle = new coderErrorHandle();
try {
    include(ROOT_DIR.'ielts/_parameter.php');
    
    $db = Database::DB();

    NotifyEveryDay($psid);

    $result['result'] = true;
    
    echo json_encode($result);
    $db->close();
} catch (Exception $e) {
    $errorhandle->setException($e); // 收集例外
}

if ($errorhandle->isException()) {
    $result['result'] = false;
    $result['data'] = $errorhandle->getErrorMessage();
    echo json_encode($result);
}

?>