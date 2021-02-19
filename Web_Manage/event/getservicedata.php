<?php
$type = get("type");

$db = Database::DB();
$sHelp = new coderSelectHelp($db);
$sHelp->select = "*";
$sHelp->table = $table;
$sHelp->page_size = ($type == -1) ? -1 : $page_size;
$sHelp->page = get("page");
$sHelp->orderby = get("orderkey", 1);
$sHelp->orderdesc = get("orderdesc", 1);

$sqlstr = $filterhelp->getSQLStr();

$where = $sqlstr->SQL;
$sHelp->where = $where;

$rows = $sHelp->getList();

for ($i = 0; $i < count($rows); $i++) {
    //性別
    $rows[$i]["gender"] = coderHelp::getAryVal($incary_sex, $rows[$i]["gender"]);

    //結果
    $rows[$i]["result"] = coderHelp::getAryVal($incary_results, $rows[$i]["result"]);

    //建立時間
    // $rows[$i]["createtime"] = datetime("Y-m-d H:i", $rows[$i]["createtime"]);
}

?>