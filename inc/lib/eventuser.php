<?php

class eventuser{
    static $event_1_colname = array('id' => 'id', 'title' => 'title', 'count' => 'count', 'count2' => 'count2', 'descript' => 'descript','num' => 'num');

	static function isExist($udata){
		$db = self::_initDB();
        // $phone = $udata["phone"];
        // $email = $udata["email"];
        $event_id = $udata["event_id"];
        // $name = $udata["name"];
        // $address = $udata["address"];
        // $sql = "SELECT * FROM " . coderDBConf::$event . " WHERE times = 1 AND (phone = '$phone' AND name = '$name') || (email = '$email' AND name = '$name') ORDER BY id DESC";
        $sql = "SELECT * FROM " . coderDBConf::$event_201810_1 . " WHERE event_id = '$event_id' ORDER BY id DESC";
        $row=$db->query_prepare_first($sql);
        return $row;
	}

    // 第一波活動
    static function getStartCount(){
        global $db;
        $col = coderDBConf::$col_sharelist_201810_1;
        $count_ary = self::getCountCache();
        if(!is_array($count_ary) || !isset($count_ary["count"]) || !is_array($count_ary["count"])){
            $count_ary = array(0,0,0,0,0,0,0);
        }else{
            $count_ary = $count_ary["count"];
        }
        $sql = "SELECT `{$col["type"]}`, `{$col["eid"]}`, count(*) as c FROM " . coderDBConf::$sharelist_201810_1 . " WHERE `{$col["type"]}`<>7 GROUP BY `{$col["eid"]}`";
        $rows=$db->fetch_all_array($sql);
        foreach ($rows as $row) {
            if(array_key_exists($row[$col["type"]], $count_ary)){
                if((int)$row['c'] > 0){
                    $count_ary[(int)$row[$col["type"]]] = $count_ary[(int)$row[$col["type"]]] + 1;
                }
                // $count_ary[(int)$row[$col["type"]]] += (int)$row['c'];
            }
        }
        return $count_ary;
    }

    // 第二波活動
    static function get_StartCount(){
        global $db, $incary_type2;
        $col = coderDBConf::$col_event_sharecount;
        $count_ary = coderHelp::makeAryKeyValue2($incary_type2, 'num');
        $cache_ary = self::get_CountCache();
        if(is_array($cache_ary) && isset($cache_ary) && is_array($cache_ary)){
            foreach ($count_ary as $key => $value) {
                if(array_key_exists($key, $cache_ary)){
                    $count_ary[$key] = $cache_ary[$key];
                }
            }
        }
        $sql = "SELECT `{$col["count"]}` FROM " . coderDBConf::$event_sharecount . " WHERE `{$col["id"]}`= 1";
        $rowData = $db->query_first($sql);
        $rows = json_decode($rowData[$col["count"]], true);
        if(!empty($rows)){
            foreach ($rows as $key => $row) {
                if(array_key_exists($key, $count_ary)){
                    $count_ary[$key]["num"] = $count_ary[$key]["num"] + ($row["num"]??0);
                    $count_ary[$key]["videoID"] = $row["videoID"]??"";
                }
            }

            $count_ary = array_values($count_ary);
            $unlock = floor(array_sum(coderHelp::makeAryKeyValue2($count_ary, 'num')) / 300);
            for($i = $unlock; $i <= 11; $i++){
                if($i > 0 && $unlock != $i){
                    unset($count_ary[$i]["videoID"]);
                }
            }
        }
        return $count_ary;
    }

    // 第二波活動
    static function get_count_list(){
        $db = self::_initDB();
        $table = coderDBConf::$event_sharecount;
        $colname=coderdbconf::$col_event_sharecount;
        $row = $db->query_first("SELECT SUM(`base_count`+`share_count`) AS total_count FROM $table ");
        $total_count = $row["total_count"] ?? 0;
        $rows = $db->fetch_all_array("SELECT share_key, videoID, (`base_count`+`share_count`) as count  FROM $table 
            WHERE share_key = 0 OR FLOOR({$total_count}/(300*share_key)) >= 1 ORDER BY `share_key` ASC ");

        return $rows;
    }
    // 第二波活動 share +1
    static function share_add($share_key){
        $db = self::_initDB();
        $table = coderDBConf::$event_sharecount;
        $colname=coderdbconf::$col_event_sharecount;
        $db -> execute("UPDATE $table SET `share_count` = `share_count`+1 WHERE `share_key` = :share_key", [':share_key'=>$share_key]);
    }

    // 第一波活動
    public static function getCountCache(){
        global $event_cache_path;
        $str = "";
        $cacheFile = $event_cache_path . md5("count") . ".cache";
        if(file_exists($cacheFile)){
            $str=file_get_contents($cacheFile);
        }
        if($str && trim($str)!=""){
            $data_rows=unserialize($str);
            if(is_array($data_rows)){
                return $data_rows; //return cache
            }
        }

        $data_rows = array("count"=>array(0,0,0,0,0,0,0), "updatetime"=>time(), "ip"=>"");
        $str=serialize($data_rows); 
        self::saveCountCache($str);

        return  $data_rows;
    }

    // 第二波活動
    public static function get_CountCache(){
        global $event_cache_path, $incary_type2;
        $str = "";
        $cacheFile = $event_cache_path . md5("event_count2") . ".cache";
        if(file_exists($cacheFile)){
            $str=file_get_contents($cacheFile);
        }
        if($str && trim($str)!=""){
            $data_rows=unserialize($str);
            if(is_array($data_rows)){
                return $data_rows; //return cache
            }
        }

        $data_rows = array();

        foreach ($incary_type2 as $k => $v) {
            $data_rows[(string)$k]["num"] = $v["num"];
            $data_rows[(string)$k]["videoID"] = $v["videoID"];
            $data_rows[(string)$k]["id"] = $v["id"];
        }

        $data_rows["updatetime"] = time();
        $data_rows["ip"] = "";

        // $data_rows = array("count2" => coderHelp::makeAryKeyValue2($incary_type2, 'num')), "updatetime"=>time(), "ip"=>"");
        $str=serialize($data_rows); 
        self::saveCountCache2($str);

        return  $data_rows;
    }

    public static function saveCountCache($str){
        global $event_cache_path;
        $cacheFile = $event_cache_path . md5("count") . ".cache";
        if(file_exists($cacheFile)){
            @unlink($cacheFile);
        }
        $file = fopen($cacheFile, 'w');
        fwrite($file, $str); 
        fclose($file);
    }

    public static function saveCountCache2($str){
        //第二波活動
        global $event_cache_path;
        $cacheFile = $event_cache_path . md5("event_count2") . ".cache";
        if(file_exists($cacheFile)){
            @unlink($cacheFile);
        }
        $file = fopen($cacheFile, 'w');
        fwrite($file, $str); 
        fclose($file);
    }

	/**
     * 取得DB物件
     *
     * @return $db物件
     */
    private static function _initDB(){
        global $db;
        $db = Database::DB();
        return $db;
    }
}