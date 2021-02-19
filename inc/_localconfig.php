<?php //程式人員設定檔
if(($_SERVER['SERVER_NAME']=='127.0.0.1' || $_SERVER['SERVER_NAME']=='localhost') && php_uname('n')=='JANE-PC'){
	$nowHost = 'Jane';
}elseif($_SERVER['SERVER_NAME']=='59.127.37.46'){
	$nowHost = 'ServerCoder';
}elseif($_SERVER['SERVER_NAME']=='demo.coder.com.tw'){
    $nowHost = 'DemoCoder';
}elseif(php_uname('n')=='KHAI-PC'){
    $nowHost = 'khai';
}else{
  $nowHost = 'mark';
}

switch ($nowHost) {
	case 'Jane':
		$web_domain = "localhost";
		$web_port = "7777";//port號
		$web_root="/";//前台cookie紀錄路徑

		$HS = "127.0.0.1";
		$ID = "root";
		$PW = "123";
		$DB = "nestlebaby";

		$HS_read = "127.0.0.1";
		$ID_read = "root";
		$PW_read = "123";
		$DB_read = "nestlebaby";
		break;
	case 'ServerCoder':
		$web_domain = "59.127.37.46";
		$web_port = "8082";//port號
		$web_root="/";//前台cookie紀錄路徑

		$HS = "localhost";
		$ID = "root";
		$PW = "123456";
		$DB = "";

		$HS_read = "127.0.0.1";
		$ID_read = "root";
		$PW_read = "123456";
		$DB_read = "";
		break;
    case 'DemoCoder':
        $web_domain = "59.127.37.46";
        $web_port = "";//port號
        $web_root="/";//前台cookie紀錄路徑
    
        $HS = "localhost";
        $ID = "codercom_root";
        $PW = "Toysroom888";
        $DB = "codercom_web";
    
        $HS_read = "127.0.0.1";
        $ID_read = "codercom_root";
        $PW_read = "Toysroom888";
        $DB_read = "codercom_web";
		break;
	case 'khai':
        $web_domain = "localhost";
        $web_port = "";//port號
        $web_root="/eray/fbchatbot/";//前台cookie紀錄路徑
    
        $HS = "localhost";
        $ID = "codercom_root";
        $PW = "Toysroom888";
        $DB = "eray_fbchatbot_fossil";
    
        $HS_read = "127.0.0.1";
        $ID_read = "codercom_root";
        $PW_read = "Toysroom888";
        $DB_read = "eray_fbchatbot_fossil";
        break;
        case 'mark':
          $web_domain = "localhost";
          $web_port = "";//port號
          $web_root="/fbchat/";//前台cookie紀錄路徑
      
          $HS = "localhost";
          $ID = "root";
          $PW = "";
          $DB = "fbchat";
      
          $HS_read = "127.0.0.1";
          $ID_read = "root";
          $PW_read = "";
          $DB_read = "fbchat";
          break;
}
