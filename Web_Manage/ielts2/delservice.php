<?php
include_once('_config.php');
$errorhandle=new coderErrorHandle();
try{

	$success=false;
	$count=0;
	$msg="未知錯誤,請聯絡系統管理員";

	$id=request_ary('id',0);

	if(count($id)>0){
		$db = Database::DB();
		$idlist="'".implode("','",$id)."'";
		$count=$db->exec("delete from $table where `id` in($idlist)");
		
		if($count>0){
			$success=true;
			coderAdminLog::insert($adminuser['username'],$logkey,'del',$count.'筆資料('.$idlist.')');
		}
		else{
			throw new Exception('查無刪除資料');
		}

		$db->close();

	}
	else{
		$msg="未選取刪除資料";
	}

	$result['result']=$success;
	$result['count']=$count;
	$result['msg']=hc($errorhandle->getErrorMessage());
	echo json_encode($result);
}
catch(Exception $e){
	$errorhandle->setException($e); // 收集例外
}

if ($errorhandle->isException()) {
	$result['result']=false;
    $result['msg']=$errorhandle->getErrorMessage();
	echo json_encode($result);
}

?>