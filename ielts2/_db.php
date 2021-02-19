<?php
$ary_asset_data = null;
function DBSave($data)
{
    global $db;
    $data['updatetime'] = datetime();
    $db->query_update('ielts2', $data, ' psid=:psid');
}
function DBReset($data)
{
    global $db;
    $data['updatetime'] = datetime();
    $data['createtime'] = datetime();
    $data['notifytime'] = null;
    $data['a1'] = null;
    $data['a2'] = null;
    $data['a3'] = null;
    $data['a4'] = null;
    $data['a5'] = null;
    $data['result'] = null;
    $data['shared'] = 0;
    $data['email'] = null;
    $data['email'] = null;
    $data['notify'] = 0;
    $data['notify_log'] = null;
    $data['agree_campaign'] = 0;
    $datau = $data;
    unset($datau['createtime']);
    $db->query_insert_update('ielts2', $data, $datau);
}
function DBResult($psid)
{
    global $db;
    return $db->query_first("select * from ielts2 where psid=:psid", [':psid' => $psid]);
}

function GetAssetData($keyname)
{
    global $db,$ary_asset_data;
    if ($ary_asset_data == null) {
        $ary_asset_data = $db->fetch_all_array("select * from ielts2_data");
    }
    $key = array_search($keyname, array_column($ary_asset_data, 'keyname'));
    return $key !== false ? $ary_asset_data[$key] : false;
}

function saveTest($data = '1'){
  global $db;
  return $db->query_insert('test',['content'=>$data]);
}
