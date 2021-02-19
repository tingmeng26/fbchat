<?php
require('_config.php');
require('_db.php');
$date = get('date', 1);
// psid
$string = substr($date, 8);

// 因某些裝置接收不到ref轉址 故改以主動發訊息方式
// 先判斷該會員是否已完成填寫email 
global $db;
shared($string);

$cp_data = [];
$cp_data['message'] = textTemplate("感謝分享。現在留下你的Email就送🤩31天IELTS Study Planner，給你滿滿的備考資源。活動結束後再加碼抽出5名獲得英國文化會獨家好禮🤩旅行大禮包！讓你讀好玩滿！");

$cp_data['recipient']['id'] = $string;
push(json_encode($cp_data));
$cp_data = [];
// 取得結果圖片
$attachId = getResultImageAttachId('reward');
// 若查無 attach id 則自主機 source/result/ 取得圖片
if (empty($attachId)) {
  $cp_data = [];
  $cp_data['message'] = imageTemplate($source_url . "reward/0.jpg");
} else {
  $cp_data['message'] = imageAttachmentTemplate($attachId);
}
$cp_data['recipient']['id'] = $string;
push(json_encode($cp_data));
// 帶回聊天室但不做任何動作
// header('Location:https://m.me/chengzhicoder?ref=I_have_shared2');
header('Location:https://m.me/BritishCouncilTaiwanIELTS?ref=I_have_shared2');
function getResultImageAttachId($key)
{
  global $db;
  $sql = "select attachment_id from ielts2_data where keyname=:key";
  $data = $db->query_first($sql, [':key' => $key]);
  return $data['attachment_id'] ?? '';
}
function shared($id)
{
  global $db;
  $result = $db->query_update('ielts2', [
    'shared' => 1,
    'updatetime' => date('Y-m-d H:i:s')
  ], "psid=$id and result != ''");
  return $result;
}
