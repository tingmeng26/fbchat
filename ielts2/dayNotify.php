<?php
include_once "_config.php";
set_time_limit(0);
ini_set('max_execution_time', 0); //0=NOLIMIT
include(dirname(__FILE__) . $slash . '_parameter.php');

$resp = array('result'=>true);

NotifyEveryDay();

// $inc_fb_token="EAAKkAyDW5ygBADs3sD4mSmXrqWjY99UIRL2kfioSyhLm5TRgNdvwPu2DMSHZBRIwIMm3doWFJRBY9hYT2meTcFhWfqwqKALPtf4tJj1oD9gjUegsiQ4BDNxci4YRqZCRbw717hitNCeTsVDjgJMaVZBPjuyKRGanXzDLOgmE0dp0BLOnWZAM2IM4PP9z3RoZD";
// $sender_id = "4235622276478128";
// $_cp_data = [];
// $_cp_data['recipient'] = [
//     'id' => $sender_id,
// ];
// $_cp_data['message'] = textTemplate('嗨,您好 現在是:'.datetime('Y-m-d H:i:s'));
// $cp_data = json_encode($_cp_data);
// $result = push($cp_data);

$db->close();

echo json_encode($resp);