<?php

class coderFilterHelp {
    private $bindlist = null;
    /*
    繫結要顯示的欄位
    bind格式為array
    type   搜尋方式  keyword
    column 資料庫欄位
    name   顯示名稱
    sql    是否要自動產生SQL搜尋語法,若要自訂SQL設false
    ary =>('column'=>'','name'=>'')   繫結資料
    sqlequal 指定sql比對的方式hidden,radio可用的為(=,&),checkbox可用(&,in)
    default 若未指定時,預設的值
    */
    public function Bind($bindlist) {
        if (is_array($bindlist) && count($bindlist) > 0) {
            $this->bindlist = $bindlist;
        } else {
            $this->oops("繫結資料不符合格式");
        }
    }
    public function drawForm() {
        if ($this->bindlist) {
            echo '<i class="icon-search" style="margin-top:15px"> 搜尋條件</i><div style="margin-top:5px" ><form id="filterform"  name="filterform">';

            foreach ($this->bindlist as $item) {

                switch ($item["type"]) {
                    case "keyword":
                        echo self::getKeywordForm($item);
                        break;

                    case "select":
                        echo self::getSelectForm($item);
                        break;

                    case "checkbox":
                        echo self::getCheckBoxForm($item);
                        break;

                    case "datearea":
                        echo self::getDateareaForm($item);
                        break;

                    case "dategroup":
                        echo self::getDategroupForm($item);
                        break;

                    case "numarea":
                        echo self::getNumareaForm($item);
                        break;

                    case "numgroup":
                        echo self::getNumgroupForm($item);
                        break;

                    case "hidden":
                        echo self::getHiddenForm($item);
                        break;

                    case "br":
                        echo self::br();
                        break;
                }
            }
            echo $this->getSubmitButton();
            echo '<div style="clear:both"></div></form></div>';
        }
    }
    private function oops($msg) {
        throw new Exception('coderFilterHelp:' . $msg);
    }
    //***********表單產生語法開始************//
    //產生換行欄位
    private static function br() {

        return '<div style="clear:both"></div>';
    }
    //產生keyword搜尋欄位
    private static function getKeywordForm($item) {
        $obj = self::getFilterValue($item);
        $str = '<div class="myform-group">' . self::getSelectTag($item, 'keywordtype', '請選擇', $obj['ind']) . '<input type="text" id="keyword" name="keyword" class="myform-control input_size1" value="' . $obj['value'] . '"></div>';

        return $str;
    }
    //產生select搜尋欄位
    private static function getSelectForm($item) {
        $obj = self::getFilterValue($item);
        $str = '<div class="myform-group"><label class="myform-label">' . $item["name"] . '</label>' . self::getSelectTag($item, $item['column'], "不限", $obj['ind']) . '</div>';

        return $str;
    }
    //產生checkbox搜尋欄位
    private static function getCheckBoxForm($item) {
        $obj = self::getFilterValue($item);
        if (count($obj) < 1 && is_array($item['default'])) {
            $obj = $item['default'];
        }
        $str = '<div class="myform-group"><span> ' . $item['name'] . ' </span>';

        foreach ($item['ary'] as $element) {
            $equal = (isset($item['sqlequal']) && $item['sqlequal'] == '&') ? '&' : '=';
            $checked = self::isInGroupAry($element['value'], $obj, $equal) ? 'checked' : '';
            $str.= ' <input type="checkbox" id="' . $item['column'] . '" name="' . $item['column'] . '[]" value="' . $element['value'] . '"  ' . $checked . '> ' . $element['name'];
        }
        $str.= '</div>';

        return $str;
    }
    private static function getSelectTag($item, $id, $txt = "", $def = 0, $defval = "") {
        if (coderHelp::getStr($item['default']) != '') {
            $defval = $item['default'];
        }
        $str = '<select id="' . $id . '" name="' . $id . '" style="margin-right:5px">';
        $str.= $txt != "" ? '<option value="0" ' . (($def == 0) ? 'selected' : '') . ' >' . $txt . '</option>' : '';
        $c = count($item["ary"]);

        for ($i = 0; $i < $c; $i++) {
            $selected = "";
            if ($defval != "" && $item["ary"][$i]["name"] == $defval) {
                $selected = "selected";
            } else if ($def == ($i + 1)) {
                $selected = "selected";
            }
            $str.= '<option value="' . ($i + 1) . '" ' . $selected . '>' . $item["ary"][$i]["name"] . '</option>';
        }
        $str.= '</select>';

        return $str;
    }
    //日期區間
    private static function getDateareaForm($item) {
        $obj = self::getFilterValue($item);
        $str = '<div class="myform-group"><label class="myform-label">' . $item["name"] . '</label>

		<input type="text" name="' . $item['column'] . '_s" id="' . $item['column'] . '_s" value="' . $obj["value"] . '" class="myform-control input_size1 date-picker"  data-mask="9999-99-99">

		~<input type="text" name="' . $item['column'] . '_e" id="' . $item['column'] . '_e" value="' . $obj["value2"] . '" class="myform-control input_size1 date-picker" data-mask="9999-99-99"></div>';

        return $str;
    }
    //日期群組
    private static function getDategroupForm($item) {
        $obj = self::getFilterValue($item);
        $str = '<div class="myform-group">' . self::getSelectTag($item, $item['column'] . 'type', "", $obj['ind']) . '<input type="text" name="' . $item['column'] . '_s" id="' . $item['column'] . '_s" value="' . $obj["value"] . '" class="myform-control input_size1 date-picker" data-mask="9999-99-99">~<input type="text" name="' . $item['column'] . '_e" id="' . $item['column'] . '_e" value="' . $obj["value2"] . '" class="myform-control input_size1 date-picker" data-mask="9999-99-99"></div>';

        return $str;
    }
    //數字區間
    private static function getNumareaForm($item) {
        $obj = self::getFilterValue($item);
        $value = $obj["value"] > 0 ? $obj["value"] : '';
        $value2 = $obj["value2"] > 0 ? $obj["value2"] : '';
        $str = '<div class="myform-group"><label class="myform-label">' . $item["name"] . '</label><input type="text" name="' . $item['column'] . '_s" id="' . $item['column'] . '_s" value="' . $value . '" class="myform-control input_size0" format="numeric">~<input type="text" name="' . $item['column'] . '_e" id="' . $item['column'] . '_e" value="' . $value2 . '" class="myform-control input_size0" format="numeric"></div>';

        return $str;
    }
    //數字群組
    private static function getNumgroupForm($item) {
        $obj = self::getFilterValue($item);
        $value = $obj["value"] > 0 ? $obj["value"] : '';
        $value2 = $obj["value2"] > 0 ? $obj["value2"] : '';
        $str = '<div class="myform-group">' . self::getSelectTag($item, $item['column'] . 'type', "", $obj['ind']) . '<input type="text" name="' . $item['column'] . '_s" id="' . $item['column'] . '_s" value="' . $value . '" class="myform-control input_size0" format="numeric">~<input type="text" name="' . $item['column'] . '_e" id="' . $item['column'] . '_e" value="' . $value2 . '" class="myform-control input_size0" format="numeric"></div>';

        return $str;
    }
    //隱藏欄位
    private static function getHiddenForm($item) {
        $obj = self::getFilterValue($item);
        $str = '<input type="hidden" id="' . $item['column'] . '" name="' . $obj['column'] . '" value="' . $obj['value'] . '"/>';

        return $str;
    }
    //送出鈕
    private static function getSubmitButton() {

        return '<div style="float:left"><a href="#" id="submit" class="btn btn-inverse show-tooltip" title="" data-original-title="搜尋"><i class="icon-search"></i></a></div>';
    }
    //**********表單產生語法結束************//
    private static function isInGroupAry($key, $ary, $equal = '=') {

        foreach ($ary as $item) {
            if ($equal == '=' && $item == $key) {

                return true;
            }
            if ($equal == '&' && $item & $key) {

                return true;
            }
        }

        return false;
    }
    public function getSQLStr() {
        if ($this->bindlist) {
            $sqlhelp = new coderSQLStr();

            foreach ($this->bindlist as $item) {
                if ($item["sql"] == true) {
                    $sqlhelp->andSQL(self::getFilterSQL($item));
                }
            }
        }

        return $sqlhelp;
    }
    public static function getFilterColumn($column, $type = 0) {
        return get($column, $type);
    }
    public static function getFilterValue($item) {
        switch ($item["type"]) {
            case "keyword":
                $col = $item["ary"];
                $ind = self::getFilterColumn('keywordtype');
                $value = self::getFilterColumn('keyword', 1);
                if ($ind > 0 && $ind <= count($col) + 1 && $value != '') {
                    return array(
                        'ind' => $ind,
                        'column' => $col[$ind - 1]["column"],
                        'value' => $value
                    );
                }
                break;

            case "select":
                $ind = self::getFilterColumn($item['column']);
                $col = $item["ary"];
                if ($ind > 0 && $ind <= count($col) + 1) {
                    return array(
                        'ind' => $ind,
                        'column' => $item['column'],
                        'value' => isset($col[$ind - 1]["value"])?$col[$ind - 1]["value"]:''
                    );
                }
                break;

            case "checkbox":

                return request_ary($item['column']);
                break;

            case "datearea":
                $column = $item['column'];

                return array(
                    'ind' => 0,
                    'column' => $column,
                    'value' => self::getFilterColumn($column . '_s', 1) ,
                    'value2' => self::getFilterColumn($column . '_e', 1)
                );
                break;

            case "dategroup":
                $column = "";
                $ind = self::getFilterColumn($item['column'] . 'type');
                $value = self::getFilterColumn($item['column'] . '_s', 1);
                $value2 = self::getFilterColumn($item['column'] . '_e', 1);
                $col = $item["ary"];
                if ($ind <= count($col) && $ind > 0) {
                    $column = $col[$ind - 1]["column"];
                }

                return array(
                    'ind' => $ind,
                    'column' => $column,
                    'value' => $value,
                    'value2' => $value2
                );
                break;

            case "numarea":
                $column = $item['column'];

                return array(
                    'ind' => 0,
                    'column' => $column,
                    'value' => self::getFilterColumn($column . '_s') ,
                    'value2' => self::getFilterColumn($column . '_e')
                );
                break;

            case "numgroup":
                $column = "";
                $ind = self::getFilterColumn($item['column'] . 'type');
                $value = self::getFilterColumn($item['column'] . '_s');
                $value2 = self::getFilterColumn($item['column'] . '_e');
                $col = $item["ary"];
                if ($ind <= count($col) && $ind > 0) {
                    $column = $col[$ind - 1]["column"];
                }

                return array(
                    'ind' => $ind,
                    'column' => $column,
                    'value' => $value,
                    'value2' => $value2
                );
                break;

            case "hidden":
                $value = self::getFilterColumn($item["column"], 1);
                if ($value != "") {

                    return array(
                        'ind' => 0,
                        'column' => $item["column"],
                        'value' => $value
                    );
                }
                break;
        }
    }
    public static function getFilterSQL($item) {
        $_table=isset($item["table"])?$item["table"]:'';
        switch ($item["type"]) {
            case "keyword":
                $obj = self::getFilterValue($item);
                if ($obj) {
                    $_column=explode(',',$obj["column"]);
                    $str='';
                    for($i=0,$c=count($_column);$i<$c;$i++){
                        $str.='or '.coderSQLStr::equal($_column[$i], '%' . $obj["value"] . '%',$_table, 'like');
                    }
                    return $str!='' ? '('.substr($str,2).')' : '' ;
                }
                break;

            case "select":
                $obj = self::getFilterValue($item);
                if ($obj) {
                    return coderSQLStr::equal($obj["column"], $obj["value"],$_table);
                }
                break;

            case "checkbox":
                $obj = request_ary($item['column']);
                if (count($obj) > 0) {
                    if (coderHelp::getStr($item['sqlequal']) == '&') {
                        $sum = array_sum($obj);

                        return coderSQLStr::equal($item["column"] . '&' . $sum, 0,$_table, '>');
                    } else {

                        return coderSQLStr::in($item['column'], $obj,$_table);
                    }
                }
                break;

            case "datearea":
                $obj = self::getFilterValue($item);
                if ($obj) {

                    return coderSQLStr::getDateRangeSQL($obj["column"], $obj["value"], $obj["value2"],$_table);
                }
                break;

            case "dategroup":
                $obj = self::getFilterValue($item);
                if ($obj) {

                    return coderSQLStr::getDateRangeSQL($obj["column"], $obj["value"], $obj["value2"],$_table);
                }
                break;

            case "numarea":
                $obj = self::getFilterValue($item);
                if ($obj) {

                    return coderSQLStr::getNumRangeSQL($obj["column"], $obj["value"], $obj["value2"],$_table);
                }
                break;

            case "numgroup":
                $obj = self::getFilterValue($item);
                if ($obj) {

                    return coderSQLStr::getNumRangeSQL($obj["column"], $obj["value"], $obj["value2"],$_table);
                }
                break;

            case "hidden":
                $obj = self::getFilterValue($item);
                if ($obj) {
                    if (coderHelp::getStr($item['sqlequal']) == '&') {

                        return coderSQLStr::equal($item["column"] . '&' . $obj["value"], 0,$_table, '>');
                    } else {

                        return coderSQLStr::equal($obj["column"], $obj["value"],$_table);
                    }
                }
                break;
        }
    }
}
/* End of this file */