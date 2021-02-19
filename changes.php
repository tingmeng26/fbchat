<?php
//檢查是否是回應指定文章
foreach ($e_data['changes'] as $e_changes_data){
    if(isset($e_changes_data['value']['post_id']) && $e_changes_data['value']['post_id'] == $post_id){
        $value = $e_changes_data['value'];
        if($value['verb'] != 'add') continue;//只有新增留言才處理
        
        //檢查是否有留言及圖
        if(!empty($value['message']) && (!$need_pic || !empty($value['photo']))){
            $message = $value['message'];
            
            //檢查是否有標註指定tag
            if(check_tag($message)){
                $cp_data = [];
                $cp_data['recipient'] = [
                    'comment_id'=>$value['comment_id'],
                ];
                //驗證是否重複留言
                if($db->query_first("SELECT * FROM message WHERE m_uid = '{$value['from']['id']}' AND m_post_id = '{$value['post_id']}'")){
                    $cp_data['message'] = [
                        "text" => '您已經有留言過了喔~',
                    ];
                }else{
                    //紀錄db
                    $nowtime = datetime();
                    $data = [];
                    $data['m_uid'] = $value['from']['id'];
                    $data['m_post_id'] = $value['post_id'];
                    $data['m_name'] = $value['from']['name'];
                    $data['m_msg'] = $value['message'];
                    $data['m_updatetime'] = $nowtime;
                    $data['m_createtime'] = $nowtime;
                    $id = $db->query_insert('message',$data);
    
                    //將db ID寫入按鈕payload
                    for ($i = 0,$e = count($btn_content);$i<$e;$i++){
                        $btn_content[$i]['payload'] = $btn_content[$i]['payload'].'.'.$id;
                    }
                    
                    $cp_data['message'] = [
                        'attachment' => [
                            "type" => "template",
                            "payload" => [
                                "template_type" => "button",
                                "text"=>str_replace("{{name}}",$value['from']['name'],$content),
                                "buttons"=>$btn_content
                            ]
                        ]
                    ];
                }
                
                //$cp_data = http_build_query($cp_data);
                $cp_data = json_encode($cp_data);
                $result = curl_post(
                    "https://graph.facebook.com/v6.0/me/messages?access_token={$inc_fb_token}",
                    $cp_data
                );
            }
        }
    }
}
?>