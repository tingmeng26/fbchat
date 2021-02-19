<?php
//修改密碼
include('_config.php');
$errorhandle=new coderErrorHandle();
$uid=trim(post('uid',1));
$coder=trim(post('coder',1));
$password=trim(post('password',1));
$password_repeat=trim(post('password_repeat',1));
try
{
	if($password==''){throw new Exception('請輸入密碼');}
	if($password!=$password_repeat){
		throw new Exception('密碼不相同');
	}
	$db = Database::DB();
	$row = $db->query_prepare_first("select email from ".coderDBConf::$admin." where id='$uid' AND forgetcode='$coder' AND DATE_ADD(`forgetcode_time`,INTERVAL 24 HOUR )>=NOW()");
	if($row){
		$randcode = md5(uniqid(rand()));
		$db->query_update(coderDBConf::$admin,array('password'=>coderAdmin::pwHash($password),'forgetcode'=>$randcode)," email=:email ",array(':email'=>$row["email"]));
	}else{
		throw new Exception('此連結已過期，請重新取得連結');
	}
	$db->close();
}
catch(Exception $e)
{
	$errorhandle->setException($e);
}
if ($errorhandle->isException())
{
	$result['result']=false;
    $result['msg']=$errorhandle->getErrorMessage(false);
}
else
{
	$result['result']=true;
}
echo json_encode($result);
?>