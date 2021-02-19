<?php
$inc_path = "../../inc/";
$manage_path = "../";
$authkey = 'event';
$logkey = 'ha3';
include('../_config.php');

coderAdmin::vaild($authkey);
$auth = coderAdmin::Auth($authkey);

$table = coderDBConf::$ha3;

$get_id = get("get_id");

$page_title = coderAdminLog::$type[$logkey]['name'];
$page = request_pag("page");
$page_desc = "{$page_title}-您可在此檢視玩家資料。";
$mtitle = '<li class="active">' . $page_title . '</li>';
$mainicon = $auth["icon"];

$page_size = -1;

$incary_results = [
    1 => '壯',
    2 => '霸',
    3 => '歡',
    4 => '躁',
];