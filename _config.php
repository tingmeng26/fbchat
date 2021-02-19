<?php
$inc_path="inc/";
include_once($inc_path."_config.php");
include_once($inc_path."_web_func.php");
$cache_path = $cache_path_web;
include_once($inc_path."_cache.php");

$db = Database::DB();
?>