<?php
$inc_path = "../../inc/";
$manage_path = "../";
$authkey = 'event';
$logkey = 'ielts2';
include('../_config.php');

coderAdmin::vaild($authkey);
$auth = coderAdmin::Auth($authkey);

$table = coderDBConf::$ielts2;

$get_id = get("get_id");

$page_title = coderAdminLog::$type[$logkey]['name'];
$page = request_pag("page");
$page_desc = "{$page_title}-您可在此檢視玩家資料。";
$mtitle = '<li class="active">' . $page_title . '</li>';
$mainicon = $auth["icon"];
global $COUNTRY_NAME;
$page_size = -1;
