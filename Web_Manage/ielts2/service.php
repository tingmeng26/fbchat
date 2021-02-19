<?php
include_once('_config.php');
include_once('filterconfig.php');
$errorhandle = new coderErrorHandle();
try {

    $page_size = get("pagenum");
    include('getservicedata.php');

    $result['result'] = true;
    $result['data'] = $rows;
    $result['page'] = $sHelp->page_info;
    echo json_encode($result);
} catch (Exception $e) {
    $errorhandle->setException($e); // 收集例外
}

if ($errorhandle->isException()) {
    $result['result'] = false;
    $result['data'] = $errorhandle->getErrorMessage();
    echo json_encode($result);
}

?>