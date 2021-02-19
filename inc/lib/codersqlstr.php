<?php

class coderSQLStr {
    public $SQL = '';
    public $nullDate = '1900-01-01';
    public function __construct() {
        $this->SQL = '';
    }
    public function andSQL($sql) {
        if ($sql != "") {
            $this->SQL.= ($this->SQL == "") ? '' . $sql : ' AND ' . $sql;
        }
    }
    public function orSQL($sql) {
        if ($sql != "") {
            $this->SQL.= ($this->SQL == "") ? '' . $sql : ' OR ' . $sql;
        }
    }
    public function Add($sql) {
        if ($sql != "") {
            $this->SQL.= $sql;
        }
    }
    public static function in($column, $ary,$table='') {
        if (count($ary) > 0) {
            $c = count($ary);
            $str = implode("','", $ary);
            return "`$table`.`$column` in ('$str')";
        }

        return '';
    }
    public static function equal($column, $value,$table='', $equal = '=') {
        return "`$table`.`$column` $equal '$value'";
    }
    public static function getNumRangeSQL($column, $start, $end,$table='') {
        $str = "";
        $start = (int)$start;
        $end = (int)$end;
        if ($start > 0 && $end > 0) {
            $str = "`$table`.`$column` BETWEEN $start AND $end";
        } else if ($start > 0) {
            $str = "`$table`.`$column` >= $start";
        } else if ($end > 0) {
            $str = "`$table`.`$column` <= $end";
        }

        return $str;
    }
    public static function getStrRangeSQL($column, $start, $end) {
        $str = "";
        if ($start != "" && $end != "") {
            $str = $column . ' BETWEEN \'' . $start . '\' AND \'' . $end . '\'';
        } else if ($start != "") {
            $str = $column . ' > \'' . $start . '\'';
        } else if ($end != "") {
            $str = $column . ' < \'' . $end . '\'';
        }

        return $str;
    }
    public static function getDateRangeSQL($column, $start, $end,$table='') {
        $str = "";
        $start = isDate($start) ? $start : '';
        $end = isDate($end) ? $end : '';
        if ($start != "") {
            $sdate = date("Y-m-d", strtotime($start));
            $str.= " `$table`.`$column`>='$sdate' ";
        }
        if ($end != "") {
            $edate = date("Y-m-d", strtotime($end . " +1 days"));
            $str.= ($str == '' ? '' : ' AND ') . " `$table`.`$column`<'$edate' ";
        }

        return $str == '' ? '' : '(' . $str . ')';
    }
    public static function getOnOffSQL($sdate, $edate) {
        global $null_date;
        return "({$sdate} <> '0000-00-00' OR {$edate} <> '0000-00-00') AND ({$sdate}<curdate() AND ({$edate}>curdate() or {$edate}='0000-00-00'  ))";
    }
}
?>