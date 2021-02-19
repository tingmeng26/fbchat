<?php
$inc_path="../inc/";
include($inc_path.'_config.php');
coderAdmin::loginOut();
header('location:login.php');
?>