<?php
class coderSelectHelp{
	public $sql_type="mysql";
	public $select="";
	public $table="";
	public $orderby="";
	public $orderdesc="desc";
	public $where="";
	public $groupby="";
	public $having="";
	public $page="1";
	public $page_size=10; //-1為不分頁
	public $count=0;
	public $db;
	public $page_info=null;
	private $sql;
	public function __construct($db){
		$this->db=$db;
	}
	public  function getList(){
		if($this->page_size==0){
			$this->page_size=10;
		}
		$sql=$this->getPageSQL();
		//echo $sql;
		$row=$this->db->fetch_all_array($sql);

		return $row;

	}

	private function getPageSQL(){
		$sql='SELECT '.$this->select.' FROM '.$this->table.$this->getWhere();

		$this->count=$this->db->queryCount($sql);
		$mypage=$this->getPageInfo($this->page, $this->count, $this->page_size);
		$this->page_info=$mypage;
		if($this->page_size > 0){
			switch($this->sql_type){
				case "mssql" :
					$sql='SELECT * FROM ( SELECT  ROW_NUMBER() OVER ('.$this->getOrder().') AS RowNum,
					'.$this->select.' FROM '.$this->table.' '.$this->getWhere().' '.'
					) as temp1 WHERE RowNum > '.$mypage['begin'].' AND RowNum<='.($mypage['begin']+$this->page_size).'
					';
				break;
				case "mysql" :
					$sql.=$this->getOrder().' limit '.$mypage['begin'].','.$this->page_size;
				break;
			}
		}
		else{
			$sql.=$this->getOrder();
		}

		return $sql;
	}

	private function getWhere(){
		return (($this->where != "") ? ' WHERE '.$this->where : '').'
		'.(($this->groupby != "") ? ' GROUP BY '.$this->groupby : '').'
		'.(($this->having != "") ? ' HAVING '.$this->having : '');
	}

	private function getOrder(){
		if ($this->orderby != ""){
			return ' order by '.$this->orderby.' '.$this->orderdesc;
		}
	}

	private function getPageInfo($page, $totalrows, $show_num = 10, $num_page = 10){
		if ((int)$totalrows > 0) {
			$pagecount = ceil($totalrows / $show_num);
		} else {
			$pagecount = 1;
			$totalrows = 0;
		}

		if ((int)$page < 1) {
			$page = 1;
		} else if ($page > $pagecount) {
			$page = $pagecount;
		}

		$sno = (int)($num_page / 2) - 1;
		$eno = $sno * 2 + 1;
		$s_start = $page - $sno;
		if ($s_start < 1) {
			$s_start = 1;
		}

		$s_end = $s_start + $eno;
		if ($s_end > $pagecount) {
			$s_end = $pagecount;
		}

		$mypage = array();
		$mypage["count"] = $totalrows;       //資料筆數
		$mypage["page"] = $page;            //目前頁數
		$mypage["pagecount"] = $pagecount;  //總頁數
		$mypage["s_start"] = $s_start;      //分頁起點
		$mypage["s_end"] = $s_end;          //分頁終點
		$mypage["begin"] = ($page - 1) * $show_num; //limit 分頁起點
		$mypage["show_num"] = $show_num;   //每頁筆數

		return $mypage;
	}
}

?>