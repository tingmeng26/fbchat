<?php
class coderAdminLog
{
	public static $type=array
	(
		'admin'=>array('key'=>1,'name'=>'登入帳號'),
		'event'=>array('key'=>2,'name'=>'Fossil玩家資料列表'),
		'ielts'=>array('key'=>3,'name'=>'IELTS玩家資料列表'),
		'ielts2'=>array('key'=>4,'name'=>'IELTS2玩家資料列表'),
		'ha3'=>array('key'=>5,'name'=>'HA3玩家資料列表'),
	);
	public static $action=array
	(
		'login'=>array('key'=>0,'name'=>'登入'),
		'view'=>array('key'=>2,'name'=>'瀏覽'),
		'add'=>array('key'=>3,'name'=>'新增'),
		'edit'=>array('key'=>4,'name'=>'編輯'),
		'del'=>array('key'=>5,'name'=>'刪除'),
		'copy'=>array('key'=>6,'name'=>'複製')

	);
	private static $_type=NULL;
	private static $_action=NULL;
	public static function clearSession(){
		unset($_SESSION['loginfo']);
	}
	public static function insert($username,$type,$act,$descript="")
	{
		global $db;
		if(!isset(self::$type[$type])){
			self::oops('記錄類型錯誤!');
		}
		if(!isset(self::$action[$act])){
			self::oops('記錄動作錯誤!');
		}
		if(!isset($_SESSION['loginfo']) || $_SESSION['loginfo']!=$type.$descript)
		{

			$data=array();
			$data['username']=$username;
			$data['type']=self::$type[$type]['key'];
			$data['action']=self::$action[$act]['key'];
			$data['createtime']=request_cd();
			$data['ip']=request_ip();
			$data['descript']=$descript;
			if($db->query_insert(coderDBConf::$admin_log,$data)){
				 $_SESSION['loginfo']=$type.$descript;
			}
		}
	}

	public static function getLogByUser($username,$limit=10){
		global $db;
		$rows=$db->fetch_all_array('select  type,action,descript,createtime from '.coderDBConf::$admin_log.' where username=:username  order by createtime desc limit '.$limit,array(':username'=>$username));
		$len=count($rows);
		for ($i=0;$i<$len ;$i++)
		{
			$rows[$i]['type']=self::getTypeNameByKey($rows[$i]['type']);
			$rows[$i]['action']=self::getActionNameByKey($rows[$i]['action']);
		}
		return $rows;
	}

	public static function getTypeIndex($value)
	{
		if(self::$_type==NULL){
			self::$_type=coderHelp::makeAryKeyValue(self::$type,'key');
		}
		return self::$_type[$value];
	}
	public static function getActionIndex($value)
	{

		if(self::$_action==NULL){
			self::$_action=coderHelp::makeAryKeyValue(self::$action,'key');
		}
		return self::$_action[$value];
	}
	public static function getTypeNameByKey($key)
	{
		return self::$type[self::getTypeIndex($key)]['name'];
	}
	public static function getActionNameByKey($key)
	{

		return self::$action[self::getActionIndex($key)]['name'];
	}
	public static function getTypeName($type)
	{
		return (isset(self::$type[$type])) ? self::$type[$type]['name'] : '' ;
	}
	public static function getActionName($act)
	{
		return (isset(self::$action[$act])) ? self::$action[$act]['name'] : '' ;
	}
	private static function getItem($type)
	{
		foreach(self::$type as $key=>$item)
		{
			if($key==$type)
			{
				return $item;
			}
		}
		return false;
	}

	private static function oops($msg){
		echo('coderAdminLog:'.$msg);
	}
}
