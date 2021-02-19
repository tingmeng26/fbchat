<?php
include_once "_config.php";
// include_once "_parameter.php"; //活動文案的內容變數

// if ($nowHost != "Production") {
//     die();
// }

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') { //Get呼叫是驗證伺服器
        include_once "check.php";
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') { //post呼叫則是Webhook
        //接收Webhook訊息
        $entityBody = file_get_contents('php://input');

        //$file = fopen("test_".time().".txt","w");
        //fwrite($file,$entityBody);
        //fclose($file);

        //寫log
        $data = [];
        $data['l_content'] = $entityBody;
        $data['l_createtime'] = datetime();
        $db->query_insert('message_log', $data);

        $data = json_decode($entityBody, true);
        $entry_data = $data['entry'];
        foreach ($entry_data as $e_data) {
            if (array_key_exists($e_data['id'], $ary_fanpage_settings)) {
                $fan_page_id = $e_data['id']; //粉專編號
                $case_folder = $ary_fanpage_settings[$fan_page_id]["case"]; //案子資料夾
                $inc_fb_token = $ary_fanpage_settings[$fan_page_id]['page_token']; //粉專token
                
                if (isset($e_data['changes'])) { //使用者留言
                    include_once "{$case_folder}/changes.php";
                } elseif (isset($e_data['messaging'])) { //使用者回應問題
                    include_once "{$case_folder}/messaging.php";
                }
            }
        }

        echo 'ok';
    }
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
