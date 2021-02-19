<?php
class coderNesTableHelp {
    public $id="nestable";
    public $name="分類管理";
    public $ajaxSrc="";
    public $maxDepth=2;
    public $table;
    public $id_column;
    public $title_column;
    public $ind_column;
    public $pid_column;
    public $ind_desc;
    public function __construct($id="nestable",$name="分類管理",$maxDepth=2)
    {
        if(trim($id)==""){
            $this->oops("必須設定物件ID");
        }
        $this->id=$id;
        $this->name=$name;
        $this->maxDepth=$maxDepth;
    }

    public function setDB($table,$id_column,$title_column,$ind_column,$pid_column,$ind_desc='asc'){
        $this->table=$table;
        $this->id_column=$id_column;
        $this->title_column=$title_column;
        $this->ind_column=$ind_column;
        $this->ind_desc=$ind_desc;
        $this->pid_column=$pid_column;
    }

    public function drawList(){
        $list=$this->getNestList();
       // print_r($list);
        echo '<div class="dd" id="nestable"><div class="functions">請指定操作</div>';

            $this->drawItem($list);
        echo ' </div>';
    }

    private function drawItem($list,$ck=0){ //[1]第二階 [0]第一階
        $colname=coderDBConf::$col_product;
        $colname_pt=coderDBConf::$col_prodtype;

        echo '<ol class="dd-list">';
        foreach ($list as $key => $row) {
            $num = self::getList_count($row['id'],$ck);
            $link =' <a class="badge badge-info" href="'.($num>0?"../product/index.php?pt1=".($ck>0?$row['pid']:$row['id']).($ck>0?'&'.$colname["pt_id"].'='.$row['id']:''):'javascript:void(0)').'"> 商品數:'.$num.'</a>';
            echo '<li class="dd-item" data-id="'.$row['id'].'" data-pid="'.$row['pid'].'" ><div class="dd-handle">'.$row['name'].$link.'</div>';
            if(isset($row['child']) && count($row['child'])>0){
                $this->drawItem($row['child'],1);
            }
            echo '</li>';
        }
        echo '</ol>';
    }

    public function getList_count($id,$ck){
        $db=Database::DB();
        $lang=coderLang::get();
        $table_tp=coderDBConf::$prodtype;
        $colname_tp=coderDBConf::$col_prodtype;

        $table=coderDBConf::$product;
        $colname=coderDBConf::$col_product;
        $where = "";
        if($ck > 0){ //二階
            $where .= "`{$colname_tp['id']}` = $id";
        }
        else{ //一階
            $where .= "`{$colname_tp['pid']}` = $id";
        }

        $sql = "SELECT count(`{$colname['id']}`) as all_count
                FROM $table
                LEFT JOIN $table_tp ON `{$colname_tp['id']}` = `{$colname['pt_id']}`
                where $where
                order by ".$this->ind_column." ".$this->ind_desc;
        $row = $db->query_prepare_first($sql);
        return $row['all_count'];
    }

    public function getList(){
        $db=Database::DB();
        $lang=coderLang::get();
        $table=coderDBConf::$prodtype;
        $colname=coderDBConf::$col_prodtype;
        $sql = "SELECT `{$colname['id']}` as `id`,`{$colname['is_public']}` as `is_public`,`{$colname['name']}` as `name`,`{$colname['ind']}` as `ind`,`{$colname['pid']}` as `pid`
                FROM $table
                order by ".$this->ind_column." ".$this->ind_desc;
        $rows = $db->fetch_all_array($sql);
        return $rows ;
    }
    public function getNestList(){
        $rows=$this->getList();
        $ary_sub=array();
        $ary_main=array();
        foreach ($rows as $key => $row) {
            $ary_sub[$row['pid']][]=$row;
        }
        $this->confAry(0,$ary_sub,$ary_main);
        return $ary_main;
    }
    private function confAry($pid,&$ary_sub,&$ary_main){
        if(!isset($ary_sub[$pid]) || count($ary_sub[$pid])==0){
            return ;
        }
        foreach ($ary_sub[$pid] as $key => $row) {
            $ary_main[$row['id']]=$row;
            if(isset($ary_sub[$row['id']])){
                $this->confAry($row['id'],$ary_sub,$ary_main[$row['id']]['child']);
            }

        }
    }
}