<?php
function send_smtp2($fr_em,$fr_na,$to_ary,$subject,$msg,$attachment=array(),$showerror=true){
	require_once('PHPMailer-master/PHPMailerAutoload.php');
	mb_internal_encoding('UTF-8');

	$mail = new PHPMailer($showerror);
	//$mail->SMTPDebug = 3;
	if($GLOBALS["smtp_isSMTP"]){
		$mail->IsSMTP();
	}
	$mail->Host     = $GLOBALS["smtp_host"];  // SMTP servers
	$mail->Port     = $GLOBALS["smtp_port"];  //default is 25, gmail is 465 or 587
	$mail->SMTPAuth = $GLOBALS["smtp_auth"]; // turn on SMTP authentication
	if($GLOBALS["smtp_auth"]){
	  $mail->Username = $GLOBALS["smtp_id"];    // SMTP username
	  $mail->Password = $GLOBALS["smtp_pw"];    // SMTP password
	}
	if($GLOBALS["smtp_secure"]!=''){
		$mail->SMTPSecure = $GLOBALS["smtp_secure"];
	}
	$mail->Sender = $GLOBALS["sys_email"];

	foreach ($to_ary as $row) {
		if(!empty($row['name']) && !empty($row['email'])){
			$mail->AddAddress($row['email'],$row['name']);
		}
	}
	$mail->SetFrom($fr_em, $fr_na);
	//$mail->AddReplyTo("jyu@aemtechnology.com","AEM");
	//$mail->WordWrap = 50; // set word wrap

	// 電郵內容，以下為發送 HTML 格式的郵件
	$mail->setLanguage('zh');
	$mail->CharSet = "utf-8";
	$mail->Encoding = "base64";
	$mail->IsHTML(true); // send as HTML
	$mail->Subject = $subject;
	$mail->Body = $msg;

	foreach($attachment as $row){
        $filename=$row['path'].$row['file'];
        if($filename!='' && is_file($filename)){$mail->AddAttachment($filename);}
    }
	//$mail->AltBody = "This is the text-only body";

    $result = $mail->Send();
	if(!$result && $showerror){//失敗
		throw new Exception('寄件失敗!'.$mail->ErrorInfo);
	}
	$mail->ClearAddresses();
	$mail->ClearAttachments();
}

function send_smtp($fr_em,$fr_na,$to_em,$to_na,$subject,$msg)
{
  if($to_em != '' && IsEmail($to_em))
  {

	// 建立 PHPMailer 物件及設定 SMTP 登入資訊
	require_once("class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->IsSMTP();                          // send via SMTP

	$mail->Host     = $GLOBALS["smtp_host"];  // SMTP servers
	$mail->Port     = $GLOBALS["smtp_port"];  //default is 25, gmail is 465 or 587
	$mail->SMTPAuth = $GLOBALS["smtp_auth"]; // turn on SMTP authentication
	if($GLOBALS["smtp_auth"]){
	  $mail->Username = $GLOBALS["smtp_id"];    // SMTP username
	  $mail->Password = $GLOBALS["smtp_pw"];    // SMTP password
	}

	$mail->From     = $fr_em;
	$mail->FromName = $fr_na;
	$mail->Sender   = $GLOBALS["smtp_id"];

	//$mail->SMTPSecure = "tls";

	// 執行 $mail->AddAddress() 加入收件者，可以多個收件者
	$mail->AddAddress($to_em,$to_na);
	//$mail->AddAddress("a8709073@hotmail.com","RAY1");
	//$mail->AddReplyTo("jyu@aemtechnology.com","AEM");
	//$mail->WordWrap = 50; // set word wrap

	// 執行 $mail->AddAttachment() 加入附件，可以多個附件
	//$mail->AddAttachment("path_to/file"); // attachment
	//$mail->AddAttachment("path_to_file2", "INF");

	// 電郵內容，以下為發送 HTML 格式的郵件
	$mail->CharSet = "utf-8";
	//$mail->Encoding = "base64";
	$mail->IsHTML(true); // send as HTML
	$mail->Subject = $subject;
	$mail->Body = $msg;
	//$mail->AltBody = "This is the text-only body";

	if(!$mail->Send())
	{
		echo "Message was not sent <p>";
		echo "Mailer Error: " . $mail->ErrorInfo;
		exit;
	}
  }
}


function sendmail($fr_em,$fr_na,$to_em,$to_na,$subject,$msg)
{
  if($to_em != '' && IsEmail($to_em))
  {
	$recipient = $to_em;
	$subject = "=?UTF-8?B?".base64_encode($subject)."?=\n";
	$mailheaders  = "MIME-Version: 1.0\n";
	$mailheaders .= "Content-type: text/html; charset=utf-8\n";
	  $from_name="=?UTF-8?B?".base64_encode($fr_na)."?=";
	$mailheaders .= "From: ".$from_name."<".$fr_em.">\n";
	if(!mail($recipient, $subject, $msg, $mailheaders)){
	  print_r(error_get_last());
	  die ("無法送出mail!");
	}
  }else{
	echo "Email錯誤";
  }
}

function isValidEmail($address)
{
  // check an email address is possibly valid
  return preg_match('/^[a-z0-9.+_-]+@([a-z0-9-]+.)+[a-z]+$/i', $address);
}

 function IsEmail($email){
  if (preg_match("/^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,6}$/i", $email))
	return true;
  else
	return false;
}
?>