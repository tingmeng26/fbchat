<?php
include_once "_config.php";
include(dirname(__FILE__) . $slash . '_parameter.php');
set_time_limit(0);
ini_set('max_execution_time', 0);

$resp = array('result'=>true);

// var_dump($inc_fb_token);exit;

$sender_id = "3520852861302127"; //正式站
// $sender_id = "3740586519339024"; //測試站
$db = Database::DB();
$data = ['psid' => $sender_id];


 $r = [];
 $cp_data = [];
 $cp_data['message'] = imageTemplate($source_url . 'reward/0.jpg');
 $cp_data['key']  = 'reward';
 $r[] = $cp_data;
//  $cp_data = [];
//  $cp_data['message'] = imageTemplate($source_url . 'result/AU.jpg');
//  $cp_data['key']  = 'AU';
//  $r[] = $cp_data;
//  $cp_data = [];
//  $cp_data['message'] = imageTemplate($source_url . 'result/US.jpg');
//  $cp_data['key']  = 'US';
//  $r[] = $cp_data;
//  $cp_data = [];
//  $cp_data['message'] = imageTemplate($source_url . 'result/CA.jpg');
//  $cp_data['key']  = 'CA';
//  $r[] = $cp_data;
// for ($i = 1; $i <= 10; $i++) {
//     $v = $day_starts["Day".$i];
//     $cp_data = [];
//     $cp_data['message'] = imageTemplate($v['pic']);
//     $cp_data['key'] = "Day".$i;
//     $r[] = $cp_data;
// }

// $v = $contents["Q5"];
// $cp_data = [];
// $cp_data['message'] = imageTemplate($v['prize_pic']);
// $cp_data['key'] = "Q5_Prize";
// $r[] = $cp_data;

// $v = $contents["Q10"];
// $cp_data = [];
// $cp_data['message'] = imageTemplate($v['pic']);
// $cp_data['key'] = "Q10";
// $r[] = $cp_data;

// $v = $contents["Q10"];
// $cp_data = [];
// $cp_data['message'] = imageTemplate($v['prize_pic']);
// $cp_data['key'] = "Q10_Prize";
// $r[] = $cp_data;

foreach ($r  as $key => $_cp_data) {
    $key = $_cp_data['key'];
    unset($_cp_data['key']);
    $_cp_data['recipient'] = [
        'id' => $sender_id,
    ];
    //print_r($_cp_data);
    $cp_data = json_encode($_cp_data);
    $result = push($cp_data);
    $result = json_decode($result, 1);
    if (isset($result["attachment_id"])) {
        $d = [
            "keyname" => 'reward',
            "attachment_id" => $result["attachment_id"],
            "updatetime" =>datetime()
        ];
        $datau = $d;
        $db->query_insert_update('ielts2_data', $d, $datau);
    }
    $resp[] = $result;
    print_r($result);
}

$db->close();

echo json_encode($resp);
