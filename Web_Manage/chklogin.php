<?php
$inc_path = "../inc/";
include($inc_path . '_config.php');
$errorhandle = new coderErrorHandle();
$username = trim(post('username', 1));
$password = trim(post('password', 1));
$code = trim(post('code', 1));
$remember_me = post('remember_me');
try {
    //把log清掉
    $_SESSION['loginfo'] = '';
    coderAdminLog::clearSession();
    if (!isset($_SESSION["VaildImgCode"])) {
        throw new Exception('超時，請重整頁面重新登入!');
    }
    if ($code == '' || $code != $_SESSION["VaildImgCode"]) {
        throw new Exception('圖形驗證碼不正確!');
    }
    if ($username == "" || $password == "") {
        throw new Exception('請輸入帳號與密碼!');
    }

    $db = Database::DB();

    coderAdmin::login($username, $password, $remember_me);
    $db->close();
    $code != $_SESSION["VaildImgCode"] = "";

} catch (Exception $e) {
    $errorhandle->setException($e);
}
if ($errorhandle->isException()) {
    $result['result'] = false;
    $result['msg'] = $errorhandle->getErrorMessage(false);
} else {
    $result['result'] = true;
}
echo json_encode($result);
?>