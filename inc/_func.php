<?php

//=============================================//
//輸入

//request GET及POST值

function request_pag($name = "page") {
    $page = request_num($name);
    if ($page == "") {
        return 1;
    }
    else if ($page < 1) {
        return 1;
    }
    else {
        return $page;
    }
}

function request_str($name) {
    $value = request($name);

    //如果magie_qutes_gpc 為ON ，則恢復
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }
    return $value;
}

function request_num($name) {
    $value = request($name);

    //如果magie_qutes_gpc 為ON ，則恢復
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }

    if (is_numeric($value)) {
        return $value;
    }
    else {
        return "0";
    }
}

function request_ary($name, $_key = 1) {
    $data = request($name);

    if (gettype($data) == "array") {
        $d = array();
        foreach ($data as $key => $value) {

            $v = $value;
            
            if (get_magic_quotes_gpc()) {
                 $v = stripslashes($value);
            }

            if ($_key == 1) {
                $v = hc($v);
            }
            else if ($_key == 0) {
                $v = intval($v);
            }
            else if ($_key == 3){
                $v = floatval($v);
            }
            $d[$key] = $v;
        }

        return $d;
    }
    else {
        return array();
    }
}

function request_ip() {
    return $_SERVER["REMOTE_ADDR"];
}

function request_cd() {
    return datetime();
}

function request_basename() {
    $path = basename($_SERVER['REQUEST_URI']);
    $last_index = strpos($path, '?');
    return $last_index > 0 ? substr($path, 0, $last_index) : $path;
}

function request_url() {

    return "http://" . dirname($_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"]) . "/";
}

function request_weburl() {

    return "http://" . $_SERVER["HTTP_HOST"] . "/";
}

function getCurrentUrl(){
    global $_SERVER;
    $php_request_uri = htmlentities(substr($_SERVER['REQUEST_URI'], 0, strcspn($_SERVER['REQUEST_URI'], "\n\r")), ENT_QUOTES);
    if(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on'){
        $protocol = 'https://';
    }else{
        $protocol = 'http://';
    }
    $host = $_SERVER['HTTP_HOST'];
    if($_SERVER['SERVER_PORT'] != '' && (($protocol == 'http://' && $_SERVER['SERVER_PORT'] != '80') ||($protocol == 'https://' && $_SERVER['SERVER_PORT'] != '443'))) {
        $port = ':' . $_SERVER['SERVER_PORT'];
    }else{
        $port = '';
    }
    return $protocol . $host . $port . $php_request_uri;
}

function request_ref() {
    return $_SERVER["http_referer"];
}

function request_date($name, $default = "") {
    $value = request($name);

    //如果magie_qutes_gpc 為ON ，則恢復
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }

    if (strlen($value) >= 8) {
        $dat = strtotime($value);
        if ($dat) {
            return $value;
        }
        else {
            return $default;
        }
    }
    else {
        return $default;
    }
}

function request($name) {
    $value = "";
    if (isset($_GET[$name])) {
        $value = $_GET[$name];
    }
    else if (isset($_POST[$name])) {
        $value = $_POST[$name];
    }
    else {
        $value = "";
    }
    return $value;
}
function get($str, $type = 0,$onlyrenulls = false) {
    if (!isset($_GET[$str])) return "";
    $gstr = trim($_GET[$str]);
    switch ($type) {
        case 0:
            if($onlyrenulls && $gstr=='')return "";
            return intval($gstr);
            break;

        case 1:
            if (!get_magic_quotes_gpc()) {
                $gstr = addslashes($gstr);
            }
            $gstr = htmlspecialchars($gstr);
            return $gstr;
            break;

        case 3:
             //float
            return floatval($gstr);
            break;
    }
}
function post($str, $type = 0) {
    if (!isset($_POST[$str])) return "";
    $gstr = trim($_POST[$str]);
    switch ($type) {
        case 0:
            return intval($gstr);
            break;

        case 1:
            $gstr = htmlspecialchars($gstr);
            if (!get_magic_quotes_gpc()) {
                $gstr = addslashes($gstr);
            }
            return trim($gstr);
            break;

        case 2:
             //admin

            if (get_magic_quotes_gpc()) {
                $gstr = stripslashes($gstr);
            }
            return trim($gstr);
            break;

        case 3:
             //float
            return floatval($gstr);
            break;
        case 4:
            //轉化特定符號，取消反斜線
            $gstr = htmlspecialchars($gstr,ENT_QUOTES);
            if (get_magic_quotes_gpc()) {
                $gstr = stripslashes($gstr);
            }
            return trim($gstr);
            break;
    }
}

//=============================================//
//輸出
function hc($str) {

    //輸出字串並將html字符編碼
    return htmlentities($str, ENT_QUOTES, "UTF-8");
}

function uc($str) {

    //url字符編碼
    return urlencode($str);
}

function sc($str) {
    $str = str_replace("\r", "\\r", $str);
    $str = str_replace("\n", "\\n", $str);
    $str = addslashes(str_replace("\"", "''", $str));
    return $str;
}
function br($str) {
    return preg_replace("/(\015\012)|(\015)|(\012)/", "<br/>", $str);
}
function removebr($str) {
    return preg_replace("/<br[[:space:]]*\/?[[:space:]]*>/", "\015\012", $str);
}
function addLink($str,$class='') {//將文字內網址加上超連結
    $str = preg_replace('#(http|https|ftp|telnet)://([0-9a-z\.\-]+)(:?[0-9]*)([0-9a-z\_\/\?\&\=\%\.\;\#\-\~\+]*)#i','<a href="\1://\2\3\4" class="'.$class.'" target="_blank">\1://\2\3\4</a>', $str);
    return $str;
}
function echoln($str) {
    echo $str;
    echo "<br>";
}

function bugshow($str) {
    echo $str;
    echo "<br>";
}

function bugout($str) {
    die($str);
}

function tc_left($s, $c) {
    if (mb_strlen($s) > $c) {
        return left($s, $c) . "…";
    }
    else {
        return $s;
    }
}
function GBsubstr($string, $start, $length) {
    $beginIndex = $start;
    if (strlen($string) < $start) {
        return "";
    }
    if (strlen($string) < $length) {

        return substr($string, $beginIndex);
    }

    $char = ord($string[$beginIndex + $length - 1]);
    if ($char >= 224 && $char <= 239) {
        $str = substr($string, $beginIndex, $length - 1) . "...";
        return $str;
    }

    $char = ord($string[$beginIndex + $length - 2]);
    if ($char >= 224 && $char <= 239) {
        $str = substr($string, $beginIndex, $length - 2) . "...";
        return $str;
    }

    return substr($string, $beginIndex, $length) . "...";
}

//輸出table
//傳入陣列,TABLE STYLE,一列幾欄,輸出格式化後的table
function fillTable($ary, $style, $c) {
    $iaryCount = count($ary);
    if ($iaryCount > 0) {
        $stemp = "<table style='$style'>";
        for ($i = 0; $i < $iaryCount; $i++) {
            if ($i % $c == 0) {
                $stemp.= ($i > 0) ? "</tr><tr>" : "<tr>";
            }
            $stemp.= '<td >' . $ary[$i] . '</td>';
        }
        if ($i % $c > 0) {
            for ($j = 0; $j < ($i % $c); $j++) {
                $stemp.= '<td>&nbsp;</td>';
            }
            $stemp.= '</tr>';
        }

        $stemp.= '</table>';
        return $stemp;
    }
    else {
        return "";
    }
}

//做unescape的處理
function phpUnescape($escstr) {
    preg_match_all("/%u[0-9A-Za-z]{4}|%.{2}|[0-9a-zA-Z.+-_]+/", $escstr, $matches);
    $ar = & $matches[0];
    $c = "";
    foreach ($ar as $val) {
        if (substr($val, 0, 1) != "%") {
            $c.= $val;
        }
        elseif (substr($val, 1, 1) != "u") {
            $x = hexdec(substr($val, 1, 2));
            $c.= chr($x);
        }
        else {
            $val = intval(substr($val, 2), 16);
            if ($val < 0x7F)
             // 0000-007F
            {
                $c.= chr($val);
            }
            elseif ($val < 0x800)
             // 0080-0800
            {
                $c.= chr(0xC0 | ($val / 64));
                $c.= chr(0x80 | ($val % 64));
            }
            else

            // 0800-FFFF
            {
                $c.= chr(0xE0 | (($val / 64) / 64));
                $c.= chr(0x80 | (($val / 64) % 64));
                $c.= chr(0x80 | ($val % 64));
            }
        }
    }

    return $c;
}

//=============================================//
//格式檢查

function chkUrl($str) {
    if (substr($str, 0, 7) != 'http://') {
        $str = 'http://' . $str;
    }
    return $str;
}

//=============================================//
//字串
function right($value, $count) {
    return mb_substr($value, ($count * -1));
}

function left($string, $count) {
    return mb_substr($string, 0, $count);
}

//=============================================//
//SQL

//=============================================//
//Session

//取得session
function session($name) {
    if (isset($_SESSION[$name]) || !empty($_SESSION[$name])) {
        return $_SESSION[$name];
    }
    else {
        return "";
    }
}
//取得session
function getSession($name) {
    return session($name);
}
//設定session
function setSession($name, $value) {
    $_SESSION[$name] = $value;
}
//清除session
function unSession($name) {
    unset($_SESSION["$name"]);
}

//=============================================//
//cookie

//取得cookie
function cookie($name) {
    if (isset($_COOKIE[$name]) || !empty($_COOKIE[$name])) {
        return phpUnescape($_COOKIE[$name]);
    }
    else {
        return "";
    }
}
//取得cookie
function getCookie($name) {
    return cookie($name);
}
//清除cookie
function unCookie($name, $path = "") {
    setcookie($name, "", time() - 60*60*24*365,$path);
}
function saveCookieHour($name, $val, $h, $path = "") {
    $expire = time() + $h * 60 * 60;
    unCookie($name);
    setcookie($name, urlencode($val), $expire, $path);//exit;
}

function saveCookie($name, $val, $path = "") {
    global $iCookMainExpireDay;
    $expire = time() + $iCookMainExpireDay * 24 * 60 * 60;
    unCookie($name);
    setcookie($name, urlencode($val), $expire, $path);
}

//=============================================//
//日期時間
function DateDiff($d1, $d2 = "now") {
    if (is_string($d1)) $d1 = strtotime($d1);
    if (is_string($d2)) $d2 = strtotime($d2);
    return ($d2 - $d1) / 86400;
}

function datetime($form = "Y/m/d H:i:s", $value = "now") {

    //Y/m/d H:i:s
    return date($form, strtotime($value));
}

function datetime_addMin($form = "Y/m/d H:i:s", $value = "now", $second = 0) {

    return datetime($form, $value . " +{$second} minutes");
}
function datetime_addDay($form = "Y/m/d H:i:s", $value = "now", $second = 0) {

    return datetime($form, $value . " +{$second} days");
}
function datetime_addMonth($form = "Y/m/d H:i:s", $value = "now", $second = 0) {

    return datetime($form, $value . " +{$second} month");
}

function dateTo_ad($in_date, $in_type = "")
 //民國年月日(1030503)轉西元年月日(20140503) $in_type為分隔符號
{
    $cyear = substr($in_date, 0, -4);
    $year = ((int)$cyear) + 1911;
    $mon = substr($in_date, -4, 2);
    $day = substr($in_date, -2);
    $date = date("Y" . $in_type . "m" . $in_type . "d", mktime(0, 0, 0, $mon, $day, date($year)));
    return $date;
}

//=============================================//
//分頁

function flip_page($page, $totalrows, $show_num = 10, $num_page = 10) {
    if ((int)$totalrows > 0) {
        $pagecount = ceil($totalrows / $show_num);
    }
    else {
        $pagecount = 1;
        $totalrows = 0;
    }

    if ((int)$page < 1) {
        $page = 1;
    }
    else if ($page > $pagecount) {
        $page = $pagecount;
    }

    $sno = (int)($num_page / 2) - 1;
    $eno = $sno * 2 + 1;
    $sec_start = $page - $sno;
    if ($sec_start < 1) {
        $sec_start = 1;
    }

    $sec_end = $sec_start + $eno;
    if ($sec_end > $pagecount) {
        $sec_end = $pagecount;
    }

    $fpage = array();

    $fpage["page"] = $page;
     //頁碼
    $fpage["pagecount"] = $pagecount;
     //總頁數
    $fpage["sec_start"] = $sec_start;
     //分頁起點
    $fpage["sec_end"] = $sec_end;
     //分頁終點
    $fpage["rs_begin"] = ($page - 1) * $show_num;
     //mysql limit 分頁起點
    $fpage["show_num"] = $show_num;
     //每頁筆數

    return $fpage;
}

//=============================================//
//檔案
function filesize_check($file, $size = 1000) {

    //檔案大小測試
    if (isset($file)) {
        if ($file["size"] <= 1024 * $size) {
            return true;
        }
    }
    return false;
}

function filename_check($filename, $ext) {
    if ($filename > '') {
        if (in_array(end(explode(".", strtolower($filename))), $ext)) {
            return true;
        }
    }
    return false;
}

function file_ext($file) {
    //傳回副檔名
    $ext = explode('.', $file["name"]);
    $size = count($ext);
    return $ext[$size - 1];
}

function file_open($file) {
    //讀取檔案
    $handle = fopen($file, "r");
    $contents = fread($handle, filesize($file));
    fclose($handle);
    return $contents;
}

function del_file($file){
    if(is_file($file)){
        unlink($file);
    }
}

function getMimeType( $filename ) { // 檢查檔案類型
    $realpath = realpath( $filename );
    if ( $realpath
            && function_exists( 'finfo_file' )
            && function_exists( 'finfo_open' )
            && defined( 'FILEINFO_MIME_TYPE' )
    ) {
            // Use the Fileinfo PECL extension (PHP 5.3+)
            return finfo_file( finfo_open( FILEINFO_MIME_TYPE ), $realpath );
    }
    if ( function_exists( 'mime_content_type' ) ) {
            // Deprecated in PHP 5.3
            return mime_content_type( $realpath );
    }
    return false;
}

//JS輔助
function script($key, $url = "") {
    if(!empty($key)){
        echo "<script>alert('$key')</script>";
    }
    if ($url != "") {
        echo "<script>window.location='$url'</script>";
        exit;
    }
    else {
        echo "<script>window.history.go(-1)</script>";
        exit;
    }
}
function redirect($url) {
    echo "<script>window.location='$url'</script>";
    exit;
}

//資料驗證
$str_message = "";
function isNull($str, $name, $min, $max='') {
    global $str_message;
    if ($max=='' && mb_strlen($str) >= $min) {
        return true;
    }elseif($max!='' && mb_strlen($str) >= $min && mb_strlen($str) <= $max){
        return true;
    }else {
        $str_message = getErrorMsg('rangelength',array('name'=>$name,'maxlength'=>$max,'minlenth'=>$min));//$name ."(".($max!=''?"$max字以内":'').($min>1?"$min字以上":"").")";
        return false;
    }
}

function isRequire($str, $name) {
    global $str_message;
    if (!empty($str)) {
        return true;
    }else {
        $str_message = getErrorMsg('require',array('name'=>$name));
        return false;
    }
}

function isNum($str, $name, $min, $max) {
    global $str_message;
    if (!is_numeric($str)) {
        $str_message = $name . '必須是整數型態';
        return false;
    }
    else {
        if (intval($str) >= $min && intval($str) <= $max) {
            return true;
        }
        else {
            $str_message = $name . '必須大於' . $min . '和小於' . $max;
            return false;
        }
    }
}

function isEmail2($str, $name) {
    global $str_message;
    $result = preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $str);
    if (!$result) {
        $str_message = getErrorMsg('format',array('name'=>"E-mail"));// $name . '不是合法的Email格式';
    }
    return $result;
}
function isDate($str, $name = "") {
    global $str_message;
    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $str)) {
        return true;
    }
    else {

        $str_message = $name . '不是合法的日期格式';
        return false;
    }
}
function isphone($str, $name = "") {
    global $str_message;
    if ($str!=='' && preg_match("/^[0][1-9]{1,3}[-]?[0-9]{6,8}$/", $str)) {
        return true;
    }
    else {
        $str_message = '請輸入正確的電話格式';
        return false;
    }
}

function post_CURL($url, $data, $headers = "", $debug = false, $CA = false, $CApem = "", $timeout = 30) {
     //網址,資料,header,返回錯誤訊息,https時驗證CA憑證,CA檔名,超時(秒)
    global $path_cacert;
    $result = "";
    $cacert = $path_cacert . $CApem;
     //CA根证书
    $SSL = substr($url, 0, 8) == "https://" ? true : false;
    if ($SSL && $CA && $CApem == "") {
        return "請指定CA檔名";
    }

    $ch = curl_init();
    $options = array(
      CURLOPT_URL=>$url,
      //CURLOPT_TIMEOUT=>$timeout,//允許執行的最長秒數
      //CURLOPT_CONNECTTIMEOUT=>$timeout - 2,//連接前等待時間(0為無限)
      CURLOPT_HEADER=>0,
      //CURLOPT_VERBOSE=>0,
      CURLOPT_RETURNTRANSFER=>true,// false 時只回傳成功與否
      //CURLOPT_USERAGENT=>"Mozilla/4.0 (compatible;)",
      CURLOPT_POST=>true,
      CURLOPT_POSTFIELDS=>(is_array($data)?http_build_query($data):$data),
    );
    if($headers != ''){
        $options[CURLOPT_HTTPHEADER] = $headers;
    }
    if ($SSL && $CA) {
        $options[CURLOPT_SSL_VERIFYPEER] = true;// 驗證CA憑證
        $options[CURLOPT_CAINFO] = $cacert;// CA憑證檔案位置
        $options[CURLOPT_SSL_VERIFYHOST] = 2;
    }else if ($SSL && !$CA) {
        $options[CURLOPT_SSL_VERIFYPEER] = false;// 信任任何憑證
        $options[CURLOPT_SSL_VERIFYHOST] = 2;
    }
    curl_setopt_array($ch, $options);
    
    $result = curl_exec($ch);
    if ($debug === true && curl_errno($ch)) {
        echo 'GCM error: ' . curl_error($ch);
    }
    curl_close($ch);
    return $result;
}

function get_CURL($URL) {
    $result = "";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $URL);

    //curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     //關閉SSL協議
    $result = curl_exec($ch);
    var_dump($result);
    var_dump(curl_error($ch));
    curl_close($ch);
    return $result;
}

function xml2array($contents, $get_attributes=1, $priority = 'tag') {  //xml轉陣列
    if(!$contents) return array(); 

    if(!function_exists('xml_parser_create')) { 
        //print "'xml_parser_create()' function not found!"; 
        return array(); 
    } 

    //Get the XML parser of PHP - PHP must have this module for the parser to work 
    $parser = xml_parser_create(''); 
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss 
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
    xml_parse_into_struct($parser, trim($contents), $xml_values); 
    xml_parser_free($parser); 

    if(!$xml_values) return;//Hmm... 

    //Initializations 
    $xml_array = array(); 
    $parents = array(); 
    $opened_tags = array(); 
    $arr = array(); 

    $current = &$xml_array; //Refference 

    //Go through the tags. 
    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array 
    foreach($xml_values as $data) { 
        unset($attributes,$value);//Remove existing values, or there will be trouble 

        //This command will extract these variables into the foreach scope 
        // tag(string), type(string), level(int), attributes(array). 
        extract($data);//We could use the array by itself, but this cooler. 

        $result = array(); 
        $attributes_data = array(); 
         
        if(isset($value)) { 
            if($priority == 'tag') $result = $value; 
            else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode 
        } 

        //Set the attributes too. 
        if(isset($attributes) and $get_attributes) { 
            foreach($attributes as $attr => $val) { 
                if($priority == 'tag') $attributes_data[$attr] = $val; 
                else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr' 
            } 
        } 

        //See tag status and do the needed. 
        if($type == "open") {//The starting of the tag '<tag>' 
            $parent[$level-1] = &$current; 
            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag 
                $current[$tag] = $result; 
                if($attributes_data) $current[$tag. '_attr'] = $attributes_data; 
                $repeated_tag_index[$tag.'_'.$level] = 1; 

                $current = &$current[$tag]; 

            } else { //There was another element with the same tag name 

                if(isset($current[$tag][0])) {//If there is a 0th element it is already an array 
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result; 
                    $repeated_tag_index[$tag.'_'.$level]++; 
                } else {//This section will make the value an array if multiple tags with the same name appear together 
                    $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array 
                    $repeated_tag_index[$tag.'_'.$level] = 2; 
                     
                    if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well 
                        $current[$tag]['0_attr'] = $current[$tag.'_attr']; 
                        unset($current[$tag.'_attr']); 
                    } 

                } 
                $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1; 
                $current = &$current[$tag][$last_item_index]; 
            } 

        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />' 
            //See if the key is already taken. 
            if(!isset($current[$tag])) { //New Key 
                $current[$tag] = $result; 
                $repeated_tag_index[$tag.'_'.$level] = 1; 
                if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data; 

            } else { //If taken, put all things inside a list(array) 
                if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array... 

                    // ...push the new element into that array. 
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result; 
                     
                    if($priority == 'tag' and $get_attributes and $attributes_data) { 
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data; 
                    } 
                    $repeated_tag_index[$tag.'_'.$level]++; 

                } else { //If it is not an array... 
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value 
                    $repeated_tag_index[$tag.'_'.$level] = 1; 
                    if($priority == 'tag' and $get_attributes) { 
                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well 
                             
                            $current[$tag]['0_attr'] = $current[$tag.'_attr']; 
                            unset($current[$tag.'_attr']); 
                        } 
                         
                        if($attributes_data) { 
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data; 
                        } 
                    } 
                    $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken 
                } 
            } 

        } elseif($type == 'close') { //End of tag '</tag>' 
            $current = &$parent[$level-1]; 
        } 
    } 
     
    return($xml_array); 
}  

function getWebCache($sql, $cache_name) {
    global $db;
    $str = getCache($cache_name);
    if ($str && trim($str) != "") {
        $data_rows = unserialize($str);
        if (is_array($data_rows)) {
            return $data_rows;
             //return cache

        }
    }
    $closedb = false;

    if (empty($db) || $db->link_id == null) {
        $_db = Database::initDB();
        $closedb = true;
    }
    else {

        $_db = $db;
    }
    $data_rows = $_db->fetch_all_array($sql);
    $str = serialize($data_rows);

    saveCache($cache_name, $str);

    if ($closedb) {
        $_db->close();
    }
    return $data_rows;
}
function getWebCache_order($sql, $target, $cache_name) {
     //以target重新編排過的陣列(sql語法,target目標欄位名稱,cache名)
    global $db;
    $str = getCache($cache_name);
    if ($str && trim($str) != "") {
        $data_rows = unserialize($str);
        if (is_array($data_rows)) {
            return $data_rows;
             //return cache

        }
    }
    $closedb = false;
    if (empty($db) || $db->link_id == null) {
        $_db = Database::initDB();
        $closedb = true;
    }
    else {
        $_db = $db;
    }
    $thisrows = $_db->fetch_all_array($sql);
    $data_rows = array();
    foreach ($thisrows as $thisrow) {
        $data_rows[$thisrow[$target]][] = $thisrow;
    }
    $str = serialize($data_rows);
    saveCache($cache_name, $str);

    if ($closedb) {
        $_db->close();
    }
    return $data_rows;
}

function getWebstr_Cache($str, $cache_name) {
     //直接將xml存成cache
    $cache_str = getCache($cache_name);
    if ($cache_str && trim($cache_str) != "") return $cache_str;
     //return cache

    if (trim($str) != "") saveCache($cache_name, $str);
    return $str;
}

function generatorPassword($password_len = 5) {
    $password = '';
    $word = 'abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ23456789';
    $len = strlen($word);

    for ($i = 0; $i < $password_len; $i++) {
        $password.= $word[rand() % $len];
    }
    return $password;
}

function isTimestamp( $string ) {
    return ( 1 === preg_match( '~^[1-9][0-9]*$~', $string ) );
}

?>