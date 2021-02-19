<?php
include_once "_config.php";
include_once "_parameter.php"; //活動文案的內容變數


try {

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


    $sender_id = '3882966511717942';

    $_cp_data = [];
    $_cp_data['recipient'] = [
        'id' => $sender_id,
    ];
    $_cp_data['message'] = textTemplate('Hi, this is the test message you requested from the application.Thank you for considering accepting our request for permission');
    $cp_data = json_encode($_cp_data);
    print_r(push($cp_data));
    echo 'ok';
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
function push($cp_data)
{
    global $inc_fb_token;
    return curl_post("https://graph.facebook.com/v6.0/me/messages?access_token={$inc_fb_token}", $cp_data);
}
function curl_post($url, $data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //http_build_query
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}
function textTemplate($text)
{
    return [
        'text' => $text
    ];
}
