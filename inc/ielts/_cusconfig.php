<?php //上線設定檔
$webname = "FB Chatbot"; //網站名稱
$nowHost = '';

/*Database 資料庫*/
$server_name = $_SERVER['SERVER_NAME'];
if ($server_name == 'events.7to.com.tw') {
    $nowHost = 'Production';
} else {
    die('error');
}
switch ($nowHost) {
    case 'Production': //正式站
        $web_domain = "events.7to.com.tw";
        $web_port = ""; //port號
        $web_root = "/ieltschatbot/"; //前台cookie紀錄路徑

        $HS = "localhost";
        $ID = "fbieltschatbot";
        $PW = "vn3eR7lKwwdu09hg";
        $DB = "fbieltschatbot";
        $HS_read = "localhost";
        $ID_read = "fbieltschatbot";
        $PW_read = "vn3eR7lKwwdu09hg";
        $DB_read = "fbieltschatbot";
        break;
}

$weburl_cookiepath = $web_root; //前台cookie紀錄路徑 ex.'/'
$webmanageurl_cookiepath = $web_root . 'Web_Manage' . "/"; //後台cookie紀錄路徑 ex.'/Web_Manage/'
$session_domain = $web_domain; //允許seesion儲存的網域
$weburl = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https' : 'http') . "://" . $web_domain . (!empty($web_port) ? ':' . $web_port : '') . $web_root; //網址

/*Email(系統發信的寄件人)*/
$sys_email = "";
$sys_name = "";

/*SMTP Server*/
$smtp_auth = false;
$smtp_host = "127.0.0.1";
$smtp_port = 25;
$smtp_id   = "";
$smtp_pw   = "";
$smtp_isSMTP = false;
$smtp_secure = "";
