<?php
$inc_path = __DIR__."/../inc/";

include_once($inc_path . "_config.php");
include_once($inc_path . "_web_func.php");
$cache_path = __DIR__."/../".$cache_path;
include_once($inc_path . "_cache.php");

$db = Database::DB();

$inc_fb_token = $ary_fanpage_settings[$fan_page_id]['page_token']; //粉專token
