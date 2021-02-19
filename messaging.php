<?php
$cp_data = [];

foreach ($e_data['messaging'] as $messaging) {
    $cp_data['recipient'] = [
        'id' => $messaging['sender']['id'],
    ];

    $payload = $messaging['postback']['payload'];
    $payload_ary = explode(".", $payload);

    if (count($payload_ary) != 2) continue;

    if (isset($btn_return_content[$payload_ary[0]])) {
        $cp_data['message'] = [
            "text" => $btn_return_content[$payload_ary[0]]['text'],
        ];

        $db->query_update('message', [
            'm_select' => $btn_return_content[$payload_ary[0]]['value'],
            'm_updatetime' => datetime()
        ], " `m_id`=" . (int)$payload_ary[1]);

        //$cp_data = http_build_query($cp_data);
        $cp_data = json_encode($cp_data);
        push($cp_data);
    }
}
