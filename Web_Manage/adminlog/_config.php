<?php
$inc_path="../../inc/";
$manage_path="../";
$authkey='admin';
include('../_config.php');
coderAdmin::vaild($authkey);

$file_path=$admin_path_admin;

$auth=coderAdmin::Auth($authkey);

$table=coderDBConf::$admin_log;
$page=request_pag("page");
$page_title='操作歷程記錄';
$page_desc="後台使用者操作記錄列表,此區不能進行新增/修改/刪除的動作。";
$mtitle='<li class="active">'.$auth['name'].'<span class="divider"><i class="icon-angle-right"></i></span>操作記錄瀏覽</li>';
$mainicon=$auth['icon'];

$help=new coderFilterHelp();
$obj=array();

$ary=array();
$ary[]=array('column'=>'username','name'=>'登入帳號');
$ary[]=array('column'=>'ip','name'=>'ip');
$obj[]=array('type'=>'keyword','name'=>'關鍵字','sql'=>true,'ary'=>$ary);
$obj[]=array('type'=>'select','name'=>'功能','column'=>'type','sql'=>true,'ary'=>coderHelp::parseAryKeys(coderAdminLog::$type,array('key'=>'value')));
$obj[]=array('type'=>'select','name'=>'操作','column'=>'action','sql'=>true,'ary'=>coderHelp::parseAryKeys(coderAdminLog::$action,array('key'=>'value')));
$obj[]=array('type'=>'datearea','sql'=>true,'column'=>'createtime','name'=>'操作日期');
$obj[]=array('type'=>'hidden','sql'=>true,'column'=>'username','name'=>'');
$help->Bind($obj);







?>