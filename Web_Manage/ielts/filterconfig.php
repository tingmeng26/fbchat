<?php
$filterhelp = new coderFilterHelp();
$obj[] = array('type' => 'hidden', 'column' => 'get_id', 'sql' => false);
$qobj = array();

$obj[] = array(
    'type' => 'keyword',
    'name' => '關鍵字',
    'sql' => true,
    'ary' => array(
        array('column' => "name", 'name' => '姓名'),
        array('column' => "psid", 'name' => 'PSID'),
        array('column' => "email", 'name' => 'Day5 Email'),
        array('column' => "email2", 'name' => 'Day10 Email'),
    )
);

$obj[] = array(
    'type' => 'select',
    'name' => '通知失敗',
    'column' => "notify_fail",
    'sql' => false,
    'ary' => coderHelp::makeAryKeyToAryElement($incary_yn, 'value', 'name')
);

// $obj[] = array(
//     'type' => 'select',
//     'name' => '測驗結果',
//     'column' => "result",
//     'sql' => true,
//     'ary' => coderHelp::makeAryKeyToAryElement($incary_results, 'value', 'name')
// );

$obj[] = array(
    'type' => 'dategroup',
    'sql' => true,
    'column' => 'dategroup',
    'ary' => array(
        array('name' => '建立時間', 'column' => 'createtime'),
        array('name' => '最後更新時間', 'column' => 'updatetime'),
    )
);

$filterhelp->Bind($obj);
?>