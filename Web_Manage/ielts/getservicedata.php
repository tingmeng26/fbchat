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

$notify_fail = get('notify_fail');

$sqlstr = $filterhelp->getSQLStr();

if ($notify_fail == 1) { //成功
    $sqlstr->andSQL(" `notify_log` NOT LIKE '%error%'");
} elseif ($notify_fail == 2) { //失敗
    $sqlstr->andSQL(" `notify_log` LIKE '%error%'");
}

$where = $sqlstr->SQL;
$sHelp->where = $where;

$rows = $sHelp->getList();

for ($i = 0; $i < count($rows); $i++) {

    //結果
    //$rows[$i]["result"] = coderHelp::getAryVal($incary_results, $rows[$i]["result"]);

    //建立時間
    // $rows[$i]["createtime"] = datetime("Y-m-d H:i", $rows[$i]["createtime"]);

    $log = json_decode($rows[$i]["notify_log"], true);
    $rows[$i]["notify_fail"] = 0;
    $rows[$i]["err_msg"] = "";
    $_log_string = $log[0] ?? "";
    if (is_array($log) && is_array(json_decode($_log_string, true))) {
        $_log = json_decode($log[0], true);
        if (isset($_log['error'])) {
            $rows[$i]["notify_fail"] = 1;
            $rows[$i]["err_msg"] = $_log['error']['message'] ?? '';
        }
        
    }
    $rows[$i]["notify_fail_layout"] = $rows[$i]["notify_fail"] == 1 ? '<span class="label label-important">失敗</span>' : '<span class="label">成功</span>';

    $rows[$i]["d10"] = is_null($rows[$i]["d10"]) ? "" : ($rows[$i]["d10"] == 1 ? "(○)" : "(X)");
    $rows[$i]["email"] = $rows[$i]["email"] ?? "";
    $rows[$i]["email2"] = $rows[$i]["email2"] ?? "";
    $rows[$i]["notify"] = $rows[$i]["notify"] > 1 ? "第{$rows[$i]["notify"]}天" : "";
    $rows[$i]["notifytime"] = $rows[$i]["notifytime"] ?? "";

    if ($rows[$i]["result"] == 10) {
        $rows[$i]["result"] = "完成彩蛋解密";
    } elseif ($rows[$i]["result"] == 11) {
        $rows[$i]["result"] = "完成Email填寫";
    } elseif ($rows[$i]["result"] > 0) {
        $rows[$i]["result"] = "第".$rows[$i]["result"]."天";
    } else {
        $rows[$i]["result"] = "";
    }
    
    for ($j = 1; $j <= 9; $j++) {
        $key = "d".$j;
        $answer_key = "ANSQ{$j}A".$rows[$i][$key];
        $is_correct = $incary_ielts_answers[$answer_key] ?? null;
        $rows[$i][$key] = coderHelp::getAryVal($incary_alphabet, $rows[$i][$key]);
        if ($is_correct !== null) {
            $rows[$i][$key] .= $is_correct ? "(○)" : "(X)";
        }
    }
}

?>