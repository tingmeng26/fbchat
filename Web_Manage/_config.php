<?php
include $inc_path."_config.php";
include $inc_path."_web_func.php";
$cache_path=$cache_path_admin;

include($inc_path.'_cache.php');
$webmanagename="後台管理系統-Neptunus V1.0";

/* if(!in_array(request_ip(),  $incary_admin_ip)){
  header("location: ../../");
  exit;  
} */

//取得登入USER順便檢查是否登入
$db = Database::DB();
$adminuser=coderAdmin::getUser();

function showParentSaveNote($authname,$active,$title,$link="",$callback=''){
	$str= '<script>parent.closeBox('.$callback.');parent.showNotice("ok","'.$authname.$active.'完成。",\''.$title.'己'.$active.'完成。';
	if($link!=""){
		$str.='<br><a href="javascript:void(0)" onclick="openBox(\\\''.$link.'\\\')"><i class="icon-check"></i>您可以按這裡檢視'.$active.'資料</a>';
	}
	$str.='<br>\');';

	$str.='</script>';
	return $str;
}

function showCompleteIcon(){
	$numargs  = func_num_args();
	if($numargs<1){
		return '';
	}
	$arg_array  = func_get_args();
	$has_value=0;
	for ($i=0; $i<$numargs; $i++)
	{
		if(isset($arg_array[$i]) && trim($arg_array[$i])!=''){
			$has_value++;
		}
	}	
	return $numargs==$has_value ? '' : ' <i class="red icon-exclamation-sign" title="該語系資料輸入不完全"></i> ';
}

function getIconClass($type){
	switch($type){
		case 'add':
			return 'icon-plus-sign-alt';
		break;
		case 'edit':
			return 'icon-edit-sign';
		break;	
		case 'import':
			return 'icon-signin';
		break;
		case 'pic':
			return 'icon-picture';
		break;		
		case 'q':
			return 'icon-question-sign';
		break;	
		default :
			return 'icon-info-sign';
		break;
	}
}


?>