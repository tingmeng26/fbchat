<?php
include_once('_config.php');
include_once('formconfig.php');

$errorhandle=new coderErrorHandle();
try{
    $db = Database::DB();
    $id = post('id',1);
    if($id!=""){
        $method='edit';
        $active='編輯';
    }else{
        $method='add';
        $active='新增';
    }

    $data=$fhelp->getSendData();
    $error=$fhelp->vaild($data);
    if(count($error)>0){
        $msg=implode('<br/>',$error);
        throw new Exception($msg);
    }

    //$prize = new class_prize();
    //$prize->checkSETime($data["starttime"], $data["endtime"]); //檢查開始和結束時間

    /* ## coder [beforeModify] --> ## */
    /* ## coder [beforeModify] <-- ## */

    $nowtime = datetime();
    $data['updatetime']= $nowtime;
    //$data['ip']= coderWebHelp::getIP();
    //$quota = $data['quota'];
    //unset($data['quota']);

    if($method=='edit'){
        $db->query_update($table,$data," id='{$id}'");
        //$db->exec("delete from $table_lo where `pid`='{$id}'");
        //$prize->addLotteryList($data,$id,$quota);
	}else{
        /* ## coder [indInit] --> ## */

        /* ## coder [indInit] <-- ## */
        /* ## coder [insert] --> ## */
        /* ## coder [insert] <-- ## */  
        $data['createtime'] = $nowtime;
        $id = $db->query_insert($table,$data);   
	}
    class_domain::clearCache();
    /* ## coder [afterModify] --> ## */

    /* ## coder [afterModify] <-- ## */

    $admin_title=isset($data['id']) ? $data['id'] : '';
    coderAdminLog::insert($adminuser['username'],$logkey,$method,"{$admin_title} id:{$id}");


    $db->close();

    echo showParentSaveNote($page_title,$active,$admin_title,"manage.php?id=".$id);
}
catch(Exception $e){
	$errorhandle->setException($e); // 收集例外
}

if ($errorhandle->isException()) {
    $errorhandle->showError();
}
?>