<?php
include('_config.php');
$db = Database::DB();
$data=post('data',1);
$type=post('type',1);
if (strlen($data)<3){
	die('false');
}
echo isNotExisit($data,$type) ? 'true' : 'false';
$db->close();
?>