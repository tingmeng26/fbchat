<?php
include(dirname(__FILE__) . $slash . '_parameter.php');

// $e_data['changes'] = [];

//檢查是否是回應指定文章

foreach ($e_data['changes'] as $e_changes_data) {

  if (isset($e_changes_data['value']['post_id']) && in_array($e_changes_data['value']['post_id'], $ary_post_id)) {

    $post_id_key = array_search($e_changes_data['value']['post_id'], $ary_post_id);
    $value = $e_changes_data['value'];
    if ($value['verb'] != 'add') continue; //只有新增留言才處理

    //檢查是否有留言及圖
    if (!empty($value['message']) && (!$need_pic || !empty($value['photo']))) {

      $allow_tags = ['留學', '雅師解惑', '#雅師解惑'];
      $allow_tags2 = ['挑戰英文', '#挑戰英文'];
      $message = trim($value['message']);
      $sender_id = $value['comment_id'];
      $payload_ary = [];

      if (in_array($message, $allow_tags)) {
        $message = '雅師解惑';
      } elseif (in_array($message, $allow_tags2)) {
        $message = '挑戰英文';
      }
      //檢查是否有標註指定tag
      if (check_tag($message, $post_id_key)) {
        $data = [
          'psid' => $e_changes_data['value']['from']['id'],
          'name' => $e_changes_data['value']['from']['name']
        ];

        $sender_id = $value['comment_id'];
        $cp_datas = getResponse('開始遊戲', $data);

        foreach ($cp_datas  as $key => $_cp_data) {

          $_cp_data['recipient'] = [
            'comment_id' => $sender_id,
          ];
          $_cp_data;
          $cp_data = json_encode($_cp_data);
          print_r(push($cp_data));
        }
      } elseif (isset($tag[$post_id_key])) { //文章對，留言錯
        $_cp_data = [];
        $_cp_data['recipient'] = [
          'comment_id' => $sender_id,
        ];
        $_cp_data['message'] = textTemplate("你打錯囉！是 #" . $tag[$post_id_key] . "，請回貼文處重新留言，我們等你來挑戰！");
        $response = json_encode($_cp_data);
        print_r(push($response));
      }
    }
  } else {
    $db->query_insert('test', ['content' => 'here']);
  }
}
