<?php
$inc_path="../../inc/";
$manage_path="../";
$authkey='admin';
$logkey='admin';
include('../_config.php');

$pagename=request_basename();

//自己要能編輯自己的資料
if(($pagename!='manage.php' && $pagename!='save.php') || request_str('username')!=$adminuser['username']){
	coderAdmin::vaild($authkey);
}

$file_path=$admin_path_admin;


$auth=coderAdmin::Auth($authkey);

$table=coderDBConf::$admin;
$page=request_pag("page");
$page_title=$auth['name'];
$page_desc="後台管理者帳號管理區,您可以在這裡檢視所有帳號,或對帳號進行新增、修改、刪除等操作。";
$mtitle='<li class="active">'.$auth['name'].'管理</li>';
$mainicon=$auth['icon'];


$help=new coderFilterHelp();
$obj=array();
$obj[]=array('type'=>'select','name'=>'啟用','column'=>'ispublic','sql'=>true,
'ary'=>array(array('name'=>'是','value'=>'1'),array('name'=>'否','value'=>'0'))
);
$help->Bind($obj);

$fhelp=new coderFormHelp();
$fobj=array();
if(coderAdmin::isAuth('admin')){
    $fobj['ispublic']=array('type'=>'checkbox','name'=>'啟用','column'=>'ispublic','value'=>'1','default'=>'1');
    $fobj['isadmin']=array('type'=>'checkbox','name'=>'最高權限','column'=>'isadmin','value'=>'1','default'=>'0','help'=>'最高權限,可以使用所有功能');
    $fobj['auth']=array('type'=>'checkgroup','name'=>'使用權限','column'=>'auth','ary'=>coderAdmin::getAuthAry());
}
$fobj['username']=array('type'=>'text','name'=>'帳號','column'=>'username','autocomplete'=>'off','placeholder'=>'請輸入管理員帳號','help'=>'此帳密為登入系統之帳號,不能重覆。','validate'=>array('maxlength'=>'20','minlength'=>'3'),'icon'=>'<i class="icon-user"></i>');
$fobj['password']=array('type'=>'password','name'=>'密碼','column'=>'password','autocomplete'=>'off','placeholder'=>'請輸入管理員密碼','help'=>'登入系統之密碼。','icon'=>'<i class="icon-key"></i>');
$fobj['repassword']=array('type'=>'password','name'=>'密碼確認','column'=>'password','autocomplete'=>'off','placeholder'=>'請重新輸入管理員密碼','help'=>'為了確認密碼是否確,麻煩您再輸入一次','sql'=>false,'icon'=>'<i class="icon-check-sign"></i>');
$fobj['name']=array('type'=>'text','name'=>'名字','column'=>'name','placeholder'=>'請輸入名字','validate'=>array('required'=>'yes'));
$fobj['email']=array('type'=>'text','name'=>'Email','column'=>'email','placeholder'=>'請輸入Email','validate'=>array('required'=>'yes','email'=>'yes'));
$fobj['introduction']=array('type'=>'textarea','name'=>'自我介紹','column'=>'introduction','placeholder'=>'請填寫自我介紹',
    'validate' => array(
        'required' => 'yes',
        'maxlength' => '255',
        'minlength' => '1'
    ));
$fobj['pic']=array('type'=>'pic','name'=>'圖片','column'=>'pic');
$fobj['id']=array('type'=>'hidden','name'=>'ID','column'=>'id','sql'=>false);
$fhelp->Bind($fobj);


function isNotExisit($data,$type){
	global $db,$table;
	if (strlen($data)>2 && !$db->query_first('select id from '.$table.' where '.$type.'=\''.hc($data).'\'')){
		return true;
	}else{
		return false;
	}
}
?>