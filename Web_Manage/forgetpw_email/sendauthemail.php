<?php
//寄送忘記密碼確認信
include('_config.php');
include_once($inc_path.'_web_func.php');
$errorhandle=new coderErrorHandle();
$forgotme_email=trim(post('forgotme_email',1));
try
{
	if($forgotme_email==''){
		throw new Exception('請輸入E-mail!');
	}
	$db = Database::DB();
	$row=$db->query_prepare_first("select username,email,id from $table where email='$forgotme_email'");
	if(!$row){
		throw new Exception('找不到與該電子郵件地址相關聯的帳戶');
	}else{
		$randcode = md5(uniqid(rand()));
		$db->query_update($table,array("forgetcode"=>$randcode,"forgetcode_time"=>datetime())," email='{$forgotme_email}'");
		$fr_em = $sys_email;//寄件email
		$fr_na = $sys_name;//寄件者
		$to_na = $row["username"];//收件人
		$to_em = $row["email"];//收件email
		//$to_em = $sys_email;
		$subject = "[{$webname}管理後台] Reset your Admin password";//主旨
		$body = '';
		$body .= "<p>先生/小姐您好：<br/><br/>";
		$body .= "您已於【{$webname}管理後台】網站後台管理系統申請 \"忘記密碼\"，請透過以下連結重設您的新密碼：<br/>";
        $body .= $weburl."Web_Manage/confirm_pwemail.php?coder=".$randcode."&uid=".$row['id']."<br/>";
        $body .= "若有任何問題請與我們連繫，謝謝!!</p>";
		$body = set_emailsample($body);

		$to_ary = array();
		$to_ary[] = array('email'=>$to_em,'name'=>$to_na);
		send_smtp($fr_em,$fr_na,$to_ary,$subject,$body);
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