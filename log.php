<?php
include_once "_config.php";

$db = Database::DB();
$rows = $db->fetch_all_array("select * from message_log order by l_createtime desc limit 100");
// foreach($rows as $key=>$row){
// 	$rows[$key]['l_content'] = json_decode($rows[$key]['l_content'], 1);
// }
print_r($rows);

?>