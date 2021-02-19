<?php
include(dirname(__FILE__) . $slash . '_parameter.php');
$cp_data = [];


foreach ($e_data['messaging'] as $messaging) {

  $sender_id = $messaging['sender']['id'];
  $restart = false;
  // 判斷由分享導回或是postback
  if (!empty($messaging['referral'])) {
    // 分享動態進入填 email 抽獎流程  完成分享自redirect url 導回  帶有 referral 物件
    $shared = $messaging['referral']['ref'] ?? "";
    if (!empty($shared)) {

      // 判斷若已輸入過email 則直接回傳結尾訊息
      $userData = DBResult($sender_id);
      if (!empty($userData['email'])) {
        $cp_datas = getResponse('suggest', ['psid' => $sender_id]);
      } else {
        $cp_datas = getResponse($shared, ['psid' => $sender_id]);
      }
      foreach ($cp_datas  as $key => $_cp_data) {
        $_cp_data['recipient'] = [
          'id' => $sender_id,
        ];
        $cp_data = json_encode($_cp_data);
        push($cp_data);
      }
    }
  } else {
    $payload = $messaging['postback']['payload'] ?? "";
    if ($payload == "開始遊戲") {
      $restart = true;
    }

    if ($payload == "" || $payload == null) {
      $payload = $messaging['message']['quick_reply']['payload'] ?? "";
    }

    if ($payload == "" || $payload == null) {
      $payload = $messaging['message']['text'] ?? "";
      if ($payload == "測試開始遊戲") {
        $restart = true;
      }
    }

    if ($restart == true) {
      $payload = "開始遊戲";
    }

    $payload_ary = explode("[|]", $payload);
    $is_know_msg = false;
    foreach ($payload_ary as $pkey => $pvalue) {
      $data = ['psid' => $sender_id];
      $cp_datas = getResponse($pvalue, $data);
      if ($cp_datas) {
        foreach ($cp_datas  as $key => $_cp_data) {
          $_cp_data['recipient'] = [
            'id' => $sender_id,
          ];
          print_r($_cp_data);
          $cp_data = json_encode($_cp_data);
          print_r(push($cp_data));
          $is_know_msg = true;
        }      # code.
      }
    }
  }
}
