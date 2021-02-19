<?php
include('_config.php');
$errorhandle=new coderErrorHandle();
try{  
	$db = Database::DB();
	$sHelp=new coderSelectHelp($db);
	$sHelp->select="*";
	$sHelp->table=$table;
	$sHelp->orderby="id";
	$sHelp->page_size=get("pagenum");
	$sHelp->page=get("page");
	$sHelp->orderby=get("orderkey",1);
	$sHelp->orderdesc=get("orderdesc",1);
	
	$sqlstr=$help->getSQLStr();
	$sHelp->where=$sqlstr->SQL;
	
	$rows=$sHelp->getList();
	
	for($i=0;$i<count($rows);$i++){
		$rows[$i]['type']= coderAdminLog::getTypeNameByKey($rows[$i]['type']);  
		$rows[$i]['action']=coderAdminLog::getActionNameByKey($rows[$i]['action']);  
	}
	$result['result']=true;
	$result['data']=$rows;
	$result['page']=$sHelp->page_info;
	echo json_encode($result);
}
catch(Exception $e){
	$errorhandle->setException($e); // 收集例外
}

if ($errorhandle->isException()) {
	$result['result']=false;
    $result['data']=$errorhandle->getErrorMessage();
	echo json_encode($result);
}

?>