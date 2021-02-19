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
		$rows[$i]['ispublic']=$incary_yn_layout[$rows[$i]['ispublic']];
		//$rows[$i]['isauthor']=$incary_yn_layout[$rows[$i]['isauthor']];
		$rows[$i]['auth']=getAuthStr($rows[$i]['auth'],$rows[$i]['isadmin']);
		$rows[$i]['pic']='s'.$rows[$i]['pic'];
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

function getAuthStr($auth,$isadmin){
	if($isadmin==1){
		return  ' <span class="label label-important"><li class="icon-ok"> 最高權限 </li></span>';
	}

	$ary_hasauth=coderAdmin::getAuthListAryByInt($auth);
	$str='';
	foreach($ary_hasauth as $item){
		$str.= ' <span class="label label-info authbtn"><li class="icon-ok-sign"> '.$item['name'].' </li></span>';
	}

	//$ary_notauth=array_diff_assoc(coderAdmin::getAuthAry(),$ary_hasauth);
	$ary_notauth=coderHelp::array_diff_assoc_recursive(getNewKeyAry(coderAdmin::getAuthAry()),getNewKeyAry($ary_hasauth));
	if(is_array($ary_notauth)){
		foreach($ary_notauth as $item){
			$str.= ' <span class="label label-default authbtn"><li class="icon-remove-sign"> '.$item['name'].' </li></span>';
		}
	}
	return $str;
}
function getNewKeyAry($_ary){
	$ary=array();
	foreach ($_ary as $value) {
		$ary[$value["key"]]=$value;
	}
	return $ary;
}
?>