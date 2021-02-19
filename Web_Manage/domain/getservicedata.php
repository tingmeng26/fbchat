<?php
$db = Database::DB();
$sHelp=new coderSelectHelp($db);
$sHelp->select="*";
$sHelp->table=$table;
$sHelp->page_size=$page_size;
$sHelp->page=get("page");
$sHelp->orderby=get("orderkey",1);
$sHelp->orderdesc=get("orderdesc",1);

$where = $sqlstr->SQL;
$sHelp->where=$where;

$rows=$sHelp->getList();
for($i=0;$i<count($rows);$i++){
	/* ## coder [modify] --> ## */

	$rows[$i]["createtime"]=datetime("Y-m-d H:i",$rows[$i]["createtime"]);
	/* ## coder [modify] <-- ## */
}

?>