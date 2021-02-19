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
    )
);



$obj[] = array(
    'type' => 'select',
    'name' => '測驗結果',
    'column' => "result",
    'sql' => true,
    'ary' => coderHelp::makeAryKeyToAryElement($COUNTRY_NAME, 'value', 'name')
);

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
