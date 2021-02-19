<?php
//20150205 新增 同name表單接值繪製功能('name'=>'XXX[],'repeat'=>重複數量,'separate_mark'=>'切割字串')
//20150206 新增 type=colorpicker
//              selectBoxManipulation_ajax()
//              selectBoxManipulation()
//20151230 Jane修正 ckeditor圖片路徑於後台顯示時先替換成後台路徑
class coderFormHelp {
    public $bindlist = null;
    private $tabindex=0;
    /*
    繫結要顯示的欄位
    bind格式為array,ary key值為欄位名稱(ID)
    type   欄位格式(text,checkbox,select,radio,file,password)
    column 資料庫欄位
    name   顯示名稱
    default 預設值
    placeholder 預設文字
    help 欄位說明
    htmlencode=true;
    validate =>()   驗證資料,與jquery validate同
    ary    需繫結的資料,ex ,select,checkbox,radio,ary型弌為array('key'=>值,'name'=>標籤名稱)
    mode no_default  radio不出現預設選項(無)'mode'=>'no_default'
    */
    public function Bind($bindlist) {
        if (is_array($bindlist) && count($bindlist) > 0) {
            $ary = array();
            $tabindex=0;
            foreach ($bindlist as $key => $item) {
                if (!isset($item['sql'])) {
                    $item['sql'] = true;
                }

                $ary[$key] = $item;
            }
            $this->bindlist = $ary;
        } else {
            $this->oops("繫結資料不符合格式");
        }
    }
    public function addAttr($key, $value) {
        $this->bindlist[$key] = $value;
    }
    public function setAttr($key, $index, $value) {
        $bindlist = $this->bindlist;
        if (array_key_exists($key, $bindlist)) {
            $this->bindlist[$key][$index] = $value;
        }
    }
    public function BindData($data) {
        $bindlist = $this->bindlist;
        $ary = array();
        if (is_array($data) && is_array($bindlist) && count($bindlist) > 0) {

            foreach ($bindlist as $key => $item) {
                if (array_key_exists($item['column'], $data)) {
                    $item['default'] = $data[$item['column']];
                }
                $ary[$key] = $item;
            }
        }
        $this->bindlist = $ary;
    }
    public function drawForm($key, $attr = array()) {
        $items = $this->bindlist;
        if ($items[$key]) {
            $separate_mark = isset($item["separate_mark"])?$item["separate_mark"]:',';
            $attr['class'] = '';

            $item = $items[$key];
            $attr["icon"] = coderHelp::getStr($item["icon"]);
            if (isset($item["placeholder"]) && $item["placeholder"] != "") {
                $attr["placeholder"] = $item["placeholder"];
            }
            if (isset($item["readonly"]) && $item["readonly"] == true) {
                $attr["readonly"] = "readonly";
            }
            if (isset($item["autocomplete"])) {
                $attr["autocomplete"] = "autocomplete";
            }
            if (isset($item["validate"]) && is_array($item["validate"])) {
                $attr = array_merge($attr, $item["validate"]);
            }
            if($item['type']!='hidden' && $item['type']!='pic' && $item['type']!='picgroup'){
                $attr['tabindex']=++$this->tabindex;
            }
            $str = '';
            for($i=1,$num=((!empty($item["repeat"]) && substr($key,-2,2)=='[]')?$item["repeat"]:1);$i<=$num;$i++){
                if (isset($item["default"]) && $item["default"] !== "") {
                    //其它的在drawfunction各自處理
                    //檢查是否要切................
                    if(!empty($item["repeat"])&& substr($key,-2,2)=='[]'){
                        $thisdefault_ary = explode($separate_mark,$item["default"]);
                        $thisdefault = (is_array($thisdefault_ary)?(isset($thisdefault_ary[$i-1])?$thisdefault_ary[$i-1]:''):$thisdefault_ary);
                    }else{
                        $thisdefault = $item["default"];
                    }

                    if ($item["type"] == 'checkbox' || $item["type"] == 'checkgroup' || $item["type"] == 'select' || $item["type"] == 'selectgroup' || $item["type"] == 'colorpicker') {
                        $attr["default"] = $thisdefault;
                    } else
                    //文字類型的欄位直接指定default為value
                    {
                        $attr["value"] = $thisdefault;
                    }
                } else {
                    $item['default'] = '';
                }
                if($i!=1){$str .= '<br/>';}
                switch ($item["type"]) {
                    case "text": //文字欄位
                        $attr["class"].= ' form-control';
                        $str .= self::drawForm_Text($key, $attr,$i);
                        break;
                    case "colorpicker":
                        $str .= self::drawForm_colorpicker($key, $item, $attr,$i);
                        break;
                    case "file": //上傳檔案
                        $attr["class"].= ' form-control';
                        $str .= self::drawForm_file($key, $attr,$i);
                        break;

                    case "hidden": //隱藏欄位
                        $str .= self::drawForm_Hidden($key, $attr,$i);
                        break;

                    case "password": //密碼
                        $attr["class"].= ' form-control';
                        $str .= self::drawForm_Password($key, $attr,$i);
                        break;

                    case "checkbox": //核取方塊
                        $attr["value"] = $item['value'];
                        if ($item['default'] == $item['value']) {
                            $attr['checked'] = 'checked';
                        }
                        if(isset($attr["readonly"]) && $attr["readonly"] = "readonly"){
                            $attr['disabled'] = 'true';
                        }
                        $str .= self::drawForm_Checkbox($key, $attr,$i);
                        break;

                    case "checkgroup": //核取方塊群組
                        $str .= self::drawForm_CheckGroup($key, $item,$i);
                        break;

                    case "radio": //radio
                        $str .= self::drawForm_Radio($key, $item,$i);
                        break;

                    case 'textarea': //textarea
                        $attr['class'].= ' form-control';
                        $attr['rows']=3;
                        $str .= self::drawForm_Textarea($key, $attr,$i);
                        break;

                    case "html": //ckeditor
                        $attr['class'].= ' form-control ckeditor';
                        $str .= self::drawForm_Textarea($key, $attr,$i);
                        break;
                    case "select": //select下拉選單
                    //case "select_samename":
                        $attr['class'].= ' form-control ';
                        $str .= self::drawForm_Select($key, $item, $attr,$i);
                        break;
                    case "selectgroup": //select下拉選單群組
                        $attr['class'].= ' form-control ';
                        $str .= self::drawForm_SelectGroup($key, $item, $attr,$i);
                        break;
                    case "picgroup":
                        $str .= self::drawForm_picgroup($key, $attr,$i);
                        break;
                }
            }
            return $str;
        }
    }
    private function getHelpInfo(&$item) {

        return coderHelp::getStr($item) != '' ? ' <a href="javascript:void(0)"><i class="icon-question-sign show-tooltip" data-placement="top" data-original-title="' . $item . '"></i></a> ' : '';
    }
    public function getSendData() {
        $bindlist = $this->bindlist;
        if (is_array($bindlist) && count($bindlist) > 0) {
            $data = array();

            foreach ($bindlist as $key => $item) {
                if ($item['sql'] != false) {
                    $data[$item['column']] = self::getSendDataValue($key, $item);
                }
            }

            return $data;
        } else {
            $this->oops("繫結資料不符合格式");
        }
    }
    public static function getSendDataValue($key, $item) {
        global $db_path_ckeditor,$path_ckeditor;
        if ($item['type'] == 'checkgroup' || $item['type'] == 'selectgroup') {
            return implode(',', request_ary($key, 1));
        }
        if ((isset($item['htmlencode']) && $item['htmlencode']==false) || $item['type'] == 'html'){
            if ($item['type'] == 'html') {
                return str_replace('src="'.$path_ckeditor,'src="'.$db_path_ckeditor,post($key,2));
            }else{
                return post($key,2);
            }
        }

        if($item['type'] == 'picgroup'){
            return request_ary($key, 1);
        }

        if (substr($key,-2,2)=='[]'){
            $separate_mark = isset($item["separate_mark"])?$item["separate_mark"]:',';
            $more_requestary=request_ary($item['column'], 1);
            if(isset($item["nonull"]) && $item["nonull"]==true){$more_requestary=array_diff($more_requestary,array(null,'null','',' '));}
            return implode($separate_mark, $more_requestary);
        }

        return post($key, 4);
        //return post($key, 1);

    }
    public static function getAttrStr($attr = array()) {
        $str = "";
        if ($attr && is_array($attr) && count($attr) > 0) {

            foreach ($attr as $key => $value) {
                if($value!=''){
                    $str.= $key . '="' . $value . '" ';
                }
            }
        }

        return $str;
    }
    public function drawLabel($key) {
        $items = $this->bindlist;
        if ($items[$key]) {
            $item=$items[$key];
            $require='';
            if(isset($item['validate']) && coderHelp::getStr($item['validate']['required'])){
                $require='<span class="red">*</span>';
            }
            return self::getHelpInfo($items[$key]['help']) .$require. $items[$key]['name'];
        } else {
            self::oops('echo Label失敗:查無此物件' . $key);
        }
    }
    public static function drawForm_Text($id, $attr = array(),$num) {
        $ary_format = self::getTextFormat($attr); //取得text特殊樣式的範本
        $str = '<input type="text" id="' . ($num!==1?$id.$num:$id) . '" name="' . $id . '" ' . self::getAttrStr($attr) . '>';

        return $ary_format[0] . $str . $ary_format[1];
    }
    public static function drawForm_colorpicker($id, $item, $attr,$num) {
        $defval = isset($attr["default"])?$attr["default"]:'';
        $str = '<input type="text" id="' . ($num!==1?$id.$num:$id) . '" name="' . $id . '" class="form-control colorpicker-default" value="'.$defval.'" autocomplete="off">';
        return $str;
    }
    public static function drawForm_file($id, $attr = array(),$num) {
        $str='<div class="fileupload '.(empty($attr['value'])?'fileupload-new':'fileupload-exists').'" data-provides="fileupload">
            <div class="input-group">
               <div class="form-control uneditable-input">
                  <i class="icon-file fileupload-exists"></i>
                  <span class="fileupload-preview">'.(!empty($attr['value'])?$attr['value']:'').'</span>
               </div>
               <div class="input-group-btn">
                   <a class="btn bun-default btn-file">
                       <span class="fileupload-new">Select file</span>
                       <span class="fileupload-exists">Change</span>
                       <input type="file" class="file-input" id="'.($num!==1?$id.$num:$id) .'"  name="' . $id . '" ' . self::getAttrStr($attr) .'/>
                       '.(!empty($attr['value'])?'<input type="hidden" value="'.$attr['value'].'" name="'.$id.'">':'').(!empty($attr['value'])?'<input type="hidden" value="'.$attr['value'].'" name="'.$id.'_def'.'">':'').'
                   </a>
                    <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
               </div>
            </div>
         </div>';
        /*$str = '<input type="file" id="' . ($num!==1?$id.$num:$id) . '" name="' . $id . '" ' . self::getAttrStr($attr) . '>';
        if(!empty($attr['value'])){$str .= '<p>'.$attr['value'].'</p>';}*/
        return $str;
    }
    public static function drawForm_Hidden($id, $attr = array(),$num) {

        return '<input type="hidden" id="' . ($num!==1?$id.$num:$id) . '" name="' . $id . '" ' . self::getAttrStr($attr) . '>';
    }
    public static function drawForm_Password($id, $attr = array(),$num) {
        $ary_format = self::getTextFormat($attr); //取得text特殊樣式的範本
        $str = '<input type="password" id="' . ($num!==1?$id.$num:$id) . '" name="' . $id . '" ' . self::getAttrStr($attr) . '>';

        return $ary_format[0] . $str . $ary_format[1];
    }
    public static function drawForm_Checkbox($id, $attr = array(),$num) {

        return '<input type="checkbox" id="' . ($num!==1?$id.$num:$id) . '" name="' . $id . '" ' . self::getAttrStr($attr) . '>';
    }
    public static function drawForm_CheckGroup($id, $item,$num) {
        $attr=coderHelp::getStr($item['readonly'])=='true' ? ' disabled="true" ' : '' ;
        $str = '<label class="checkbox-inline"><input id="'.($num!==1?$id.$num:$id).'_all" type="checkbox" onclick="selectAll(\'' . $id . '\',$(this).prop(\'checked\'))"  '.$attr.' >全選 | </label>';
        foreach ($item['ary'] as $obj) {
            $str.= '<label class="checkbox-inline"><input type="checkbox" id="' . ($num!==1?$id.$num:$id) . '" name="' . $id . '[]" value="' . $obj['key'] . '" ' . ((is_array($item['default']) && self::isInGroupAry($obj['key'], $item['default']) ? 'checked' : '')) . '  '.$attr.' >' . $obj['name'] . '</label>';
        }

        return $str;
    }

    public static function drawForm_Radio($id, $item,$num) {
        $str='';
        $attr=coderHelp::getStr($item['readonly'])=='true' ? ' disabled="true" ' : '' ;
        if(!isset($item['mode']) || $item['mode']==''){
            $str= '<label class="radio-inline"><input type="radio" id="' . ($num!==1?$id.$num:$id) . '" name="' . $id . '" value="0" ' . ($item['default']==0 ? 'checked' : '') . ' '.$attr.' >無</label>';
        }
        foreach ($item['ary'] as $obj) {
            $str.= '<label class="radio-inline"><input type="radio" id="' . ($num!==1?$id.$num:$id) . '" name="' . $id . '" value="' . $obj['key'] . '" ' . ($item['default']==(string)$obj['key'] ? 'checked' : '') . ' '.$attr.' >' . $obj['name'] . '</label>';
        }

        return $str;
    }

    public static function drawForm_TextArea($id, $attr,$num) {
        global $db_path_ckeditor,$path_ckeditor;
        $attr['style'] = "height:100%";
        $value=coderHelp::getStr($attr['value']);
        unset($attr['value']);
        return '<textarea type="text" id="' . ($num!==1?$id.$num:$id) . '" name="' . $id . '" ' . self::getAttrStr($attr) . '>' . str_replace($db_path_ckeditor,$path_ckeditor,$value). '</textarea>';
    }
    private static function drawForm_Select($id, $item, $attr,$num) {
        $txt = '請選擇';
        $id=(substr($id,-2,2)=='[]')?substr($id,0,-2):$id;
        $defval = isset($attr["default"])?$attr["default"]:'';
        $attr_readonly = coderHelp::getStr($item['readonly'])=='true' ? ' disabled="disabled" ' : '' ;
        $require_str = '';
        if (isset($item['validate']) && coderHelp::getStr($item['validate']['required']) == 'yes') {
            $require_str = ' required="yes" ';
        }
        $str = '<select id="' . ($num!==1?$id.$num:$id) . '" name="' . $id.(!empty($item["repeat"])?'[]':'') . '" ' . $require_str . ' class="form-control" ' . self::getAttrStr($attr) .$attr_readonly.'>';
        $str.= $txt != "" ? '<option value="" ' . (($defval === '') ? 'selected' : '') . ' >' . $txt . '</option>' : '';
        if(!empty($item["ary"])){
            $ary = $item["ary"];
            $c = count($ary);
            for ($i = 0; $i < $c; $i++) {
                $selected = "";
                if ($defval !== "" && $ary[$i]["value"] == $defval) {
                    $selected = "selected";
                }
                $str.= '<option value="' . $ary[$i]["value"] . '" ' . $selected . '>' . $ary[$i]["name"] . '</option>';
            }
        }else{
            $str.= '<option>請選擇</option>';
        }
        $str.= '</select>';
        return $str;
    }
	private static function drawForm_SelectGroup($id, $item, $attr,$num) {
		$ary = $item["ary"];
        $c = count($ary);
		if($item['default']!=""){
		$txt = '&nbsp;';
		}else{
        $txt = '請選擇：';
		}
        $defval = explode(",",$item['default']);
        $require_str = '';
        if (isset($item['validate']) && coderHelp::getStr($item['validate']['required']) == 'yes') {
            $require_str = ' required="yes" ';
        }
		$str = $txt != "" ? '<label style="display:none" for="'. $id . '">' . $txt . '</label> ' : '';
        $str .= '<select id="' . ($num!==1?$id.$num:$id) . '" name="' . $id . '[]" ' . $require_str . ' class="form-control" ' . self::getAttrStr($attr) . ' multiple="multiple" size="5">';
        //$str.= $txt != "" ? '<option value="" ' . (($defval === '') ? 'selected' : '') . ' >' . $txt . '</option>' : '';


        for ($i = 0; $i < $c; $i++) {
            $selected = "";
            if ($item['default'] != "" && in_array($ary[$i]["value"],$defval)) {
                $selected = "selected";
            }
            $str.= '<option value="' . $ary[$i]["value"] . '" ' . $selected . '>' . $ary[$i]["name"] . '</option>';
        }

        $str.= '</select>';

        return $str;
    }

    public static function drawForm_picgroup($id, $attr = array(),$num) {
        $str = '<div id="dZUpload" class="dropzone">
                         <div class="dz-default dz-message"></div>
                    </div>';
        return $str;
    }


    private static function isInGroupAry($key, $ary,$equal='=') {
        if(count($ary)>0 && $ary[0]!=''){
            foreach ($ary as $item) {
                if ($equal=='=' && $item['key'] == $key) {
                    return true;
                }
                if ($equal=='&' && $item['key'] & $key) {
                    return true;
                }
            }
        }
        return false;
    }
    //$attr['date'],$attr['email'],$attr['url'],$attr['icon']
    private static function getTextFormat(&$attr) {
        $ary_format = array(
            '',
            ''
        );
        if (coderHelp::getStr($attr['date']) == 'yes') { //加入日期的icon
            $attr['class'].= ' date-picker ';
            $ary_format[0] = '<div class="input-group date date-picker" data-date="'.datetime('Y-m-d').'" data-date-format="dd-mm-yyyy" >';
            $ary_format[1] = ' <div class="input-group-addon" style="height:20px"><i class="icon-calendar"></i></div></div>';
        }else if(coderHelp::getStr($attr['datetime']) == 'yes'){
            $ary_format[0] = '<div class="input-group date datetimepicker">';
            $ary_format[1] = '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        } else if (coderHelp::getStr($attr['email']) == 'yes') { //加入URL的icon
            $ary_format[0] = '<div class="input-group"><span class="input-group-addon">@</span>';
            $ary_format[1] = '</div>';
        } else if (coderHelp::getStr($attr['url']) == 'yes') { //加入URL的icon
            $ary_format[0] = '<div class="input-group"><span class="input-group-addon"><li class=\'icon-link\'></li></span>';
            $ary_format[1] = '</div>';
        } else if(coderHelp::getStr($attr['phone']) == 'yes'){
            $ary_format[0] = '<div class="input-group"><span class="input-group-addon"><li class=\'icon-phone\'></li></span>';
            $ary_format[1] = '</div>';
        } else if (coderHelp::getStr($attr['icon']) != '') {
            $icon = str_replace('"', '', $attr['icon']);
            $ary_format[0] = '<div class="input-group"><span class="input-group-addon" >' . $icon . '</span>';
            $ary_format[1] = '</div>';
            unset($attr['icon']);
        }

        return $ary_format;
    }
    public static function oops($msg) {
        echo 'coderFormHelp:' . $msg;
    }
    public static function drawVaildScript($fname = "myform",$items=null) {
        echo '
		    $("#' . $fname . '").submit(function(){
        	$("textarea.ckeditor").each(function () {
           		var $textarea = $(this);
           		$textarea.val(CKEDITOR.instances[$textarea.attr("name")].getData());
        	});
    		});
    if (jQuery().validate) {
        var removeSuccessClass = function(e) {
            $(e).closest(\'.form-group\').removeClass(\'has-success\');
        }
			$("#' . $fname . '").validate({
			  errorElement: \'span\',
			  errorClass: \'help-block\',
			  focusInvalid: true,
			  ignore: ".ignore,:hidden:not(.hasvalidate)",
			  invalidHandler: function (event, validator) {
			  },

			  highlight: function (element) {
				  $(element).closest(\'.form-group\').removeClass(\'has-success\').addClass(\'has-error\');
				  resizeNicescroll();
			  },
              ignore: ".ignore,:hidden:not(input[type=hidden])",

			  unhighlight: function (element) {
				  $(element).closest(\'.form-group\').removeClass(\'has-error\');
				  setTimeout(function(){removeSuccessClass(element);}, 3000);
			  },

			  success: function (label) {
				  label.closest(\'.form-group\').removeClass(\'has-error\').addClass(\'has-success\');
				  label.remove(\'.help-block\');
			  },
              invalidHandler:function(){
                 showNotice("alert","表單驗證失敗","有些欄位驗證未通過,請檢查所有欄位是否都有依規格填寫。");
              },
              errorPlacement: function(error, element) {
                if (element.is(\':radio\') || element.is(\':checkbox\')) {
                   var eid = element.attr(\'name\');
                error.appendTo(element.parent().parent());
                }else {
                   error.insertAfter(element);
                }
              },
        	});
        jQuery.validator.addMethod("isMobile", function (phone_number, element) {
                phone_number = phone_number.replace(/\s+/g, "");
                return this.optional(element) || phone_number.length >= 8 &&
                      phone_number.match(/^\(?[0][\d]{1,3}[\d]{6,8}$/);
            }, "請輸入正確的手機格式(ex.0911789456)");
        jQuery.validator.addMethod("numberAndLetterOneL", function (acc_data, element) {
                acc_data = acc_data.replace(/\s+/g, "");
                return this.optional(element) || acc_data.match(/^(?=.*\D)^[0-9A-Za-z]+$/);
            }, "請輸入英文字母和數字，且須含至少一個英文字母");

	}';
        if($items!=null){
            foreach ($items as $key=>$item){
                if($item['type']=='html' && isset($item['validate']) && coderHelp::getStr($item['validate']['required'])=='yes'){
                    echo "$('#".$key."').rules('add', {required: true}); ";
                }
            }
        }
    }
    //表單驗證相關function
    public function vaild($data) {
        $bindlist = $this->bindlist;
        if (is_array($bindlist) && count($bindlist) > 0) {
            $err = array();

            foreach ($bindlist as $key => $item) {
                if (isset($item['validate']) && $item['sql'] != false) {
                    $this->chkValid($err, $data[$item['column']], $item,$data);
                }
            }

            return $err;
        } else {
            $this->oops("繫結資料不符合格式");
        }
    }
    public function chkValid(&$err, $value, $item ,$data) {
        $isnum = false;
		$isrequired=isset($item['validate']['required']) && $item['validate']['required'] == 'yes' ? true :false ;

        if ($isrequired && trim($value) == "") {
            $err[] = '請輸入' . $item['name'];
            return;
        }
		if($isrequired==true || trim($value) != ""){ // 必填或值不為空時才檢查格式,非必填且沒值時不用檢查
			if (isset($item['validate']['email']) && $item['validate']['email'] == 'yes' && !self::isEmail(trim($value))) {
				$err[] = $item['name'] . '必須為email格式';
			}
            if (isset($item['validate']['isMobile']) && $item['validate']['isMobile'] == 'yes' && !self::isMobile(trim($value))) {
                $err[] = $item['name'] . '必須為電話格式';
            }
			if (isset($item['validate']['number']) && $item['validate']['number'] == 'yes' && !is_numeric(trim($value))) {
				$err[] = $item['name'] . '必須為數值格式';
				$isnum = true;
			}
			if (isset($item['validate']['digits']) && $item['validate']['digits'] == 'yes' && !is_int(intval($value))) {
				$err[] = $item['name'] . '必須為整數格式';
				$isnum = true;
			}
			if (isset($item['validate']['url']) && $item['validate']['url'] == 'yes' && !filter_var(trim($value) , FILTER_VALIDATE_URL)) {
				$err[] = $item['name'] . '必須為URL格式';
			}
			if (isset($item['validate']['date']) && $item['validate']['date'] == 'yes' && !self::isDate(trim($value))) {
				$err[] = $item['name'] . '必須為日期格式';
			}
            if (isset($item['validate']['datetime']) && $item['validate']['datetime'] == 'yes' && !self::isdatetime(trim($value))) {
                $err[] = $item['name'] . '必須為日期與時間格式';
            }

			if ($isnum && isset($item['validate']['min']) && inval(trim($value)) < intval($item['validate']['min'])) {
				$err[] = $item['name'] . '不能小於' . $item['validate']['min'];
			}
			if ($isnum && isset($item['validate']['max']) && inval(trim($value)) > intval($item['validate']['max'])) {
				$err[] = $item['name'] . '不能大於' . $item['validate']['max'];
			}
			if (!$isnum && isset($item['validate']['minlength']) && mb_strlen(trim($value)) < intval($item['validate']['minlength'])) {
				$err[] = $item['name'] . '的長度不能小於' . $item['validate']['minlength'];
			}
			if (!$isnum && isset($item['validate']['max']) && mb_strlen(trim($value)) > intval($item['validate']['max'])) {
				$err[] = $item['name'] . '的長度不能大於' . $item['validate']['maxlength'];
			}
			if (!$isnum && isset($item['validate']['morethen']) && !self::ismorethen(trim($value),$data[$item['validate']['morethen']])) {
				$err[] = $item['name'] . '必須大於'.$item['validate']['morethen'].'欄位值';
			}
			if (!$isnum && isset($item['validate']['under']) && !self::isunder(trim($value),$data[$item['validate']['under']])) {
				$err[] = $item['name'] . '必須大於'.$item['validate']['under'].'欄位值';
			}
            if (isset($item['validate']['numberAndLetterOneL']) && $item['validate']['numberAndLetterOneL'] == 'yes' && !preg_match("/^(?=.*\D)^[0-9A-Za-z]+$/", trim($value))) {
                $err[] = $item['name'] . '必須為英文字母和數字，且須含有至少一個英文字母';
            }
		}


    }
    public static function isEmail($email) {

        return preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $email);
    }

    public static function isMobile($phone) {

        return preg_match("/^[0][1-9]{1,3}[0-9]{6,8}$/", $phone);
    }
    public static function isDate($str) {

        return preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $str);
    }
    public static function isdatetime($str) {
        return preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) ([01][0-9]|[2][0-4]):([0-5][0-9])(:[0-6][0-9])?$/", $str);
    }
	public static function ismorethen($num,$targetnum) {
        if($targetnum!="" && $num>$targetnum){
			return true;
		}return false;
    }
	public static function isunder($num,$targetnum) {
        if($targetnum!="" && $num<$targetnum){
			return true;
		}return false;
    }

    //表單驗證相關function結束
    public static function moveCopyPic($file, $temp, $path, $resize='') {
        if (!file_exists($path . $file)) {
            @copy($temp . $file, $path . $file);
            if($resize!=''){
                $arysize = explode(',', $resize);

                for ($i = 0; $i < count($arysize); $i++) {
                    @copy($temp . $arysize[$i] . $file, $path . $arysize[$i] . $file);
                }
            }
        }
    }

    public static function drawPicScript($method, $file_path, $pic, $varname) {
        if ($method == 'edit' && trim($pic) != '') {
            $size = @getimagesize($file_path . $pic);
            echo 'var ' . $varname . '=new Array();'.$varname.'["filepath"]="' . $file_path . '";'.$varname.'["filename"]="' . $pic . '";'.$varname.'["width"]="' . $size[0] . '";'.$varname.'["height"]="' . $size[1] . '";';
        } else {
            echo 'var ' . $varname . ' = null;';
        }
    }

    /*$picgroup為圖片json ex.["123.jpg","235.jpg"]*/
    public static function drawPicGroupScript($method, $column,$file_path, $picgroup, $varname,$picsize=array(),$previewname="preview",$maxfile=3) {
        if ($method == 'edit' && count(json_decode($picgroup,true))>0) {
            $picgroup_ary = array();
            $pg_temp = json_decode($picgroup,true);
            foreach ($pg_temp as $value) {
                $picgroup_ary[] = array('name'=>$value,'size'=>@filesize($file_path . $value));
            }

            echo 'var ' . $varname . '=[];'.$varname.'.filepath="' . $file_path . '";'.$varname.'.filegroup=' . json_encode($picgroup_ary) . ';';
        } else {
            echo 'var ' . $varname . ' = null;';
        }

        echo '$(document).ready(function () {
            Dropzone.autoDiscover = false;
            $("#dZUpload").dropzone({
                url: "../comm/upload.php",
                paramName:"pic",
                maxFilesize: '.$maxfile.',
                addRemoveLinks: true,
                init:function(){
                    if('.$varname.' != null){
                        var picgrouplist = '.$varname.'.filegroup;
                        if(picgrouplist.length>0){
                            $("div.dz-default.dz-message").hide();
                            for(var i = 0 , num = picgrouplist.length; i<num ; i++){
                                var mockFile = { name: picgrouplist[i]["name"] ,size: picgrouplist[i]["size"]};
                                this.emit("addedfile", mockFile);
                                this.emit("thumbnail", mockFile, '.$varname.'.filepath+"'.$previewname.'"+picgrouplist[i]["name"]);
                                mockFile.previewElement.classList.add("dz-success");
                                mockFile.previewElement.classList.add("dz-complete");
                                $(mockFile.previewElement).prepend("<input type=\'hidden\' name=\''.$column.'[]\' value=\'"+picgrouplist[i]["name"]+"\'>");
                            }
                        }
                    }
                },
                sending:function(file, xhr, formData){
                    formData.append("arys[]", "'.$previewname.',6,100,100");
                    ';
                    foreach ($picsize as $value) {
                        echo 'formData.append("arys[]", "'.$value[0].','.$value[1].','.$value[2].','.$value[3].'");';
                    }
        echo '
                },
                success: function (file, response) {
                    response = JSON.parse(response);
                    if(response.result == true){
                        file.previewElement.classList.add("dz-success");
                        $(file.previewElement).prepend("<input type=\'hidden\' name=\''.$column.'[]\' value=\'"+response.filename+"\'>");
                    }else{
                        file.previewElement.classList.add("dz-error");
                    }
                },
                error: function (file, response) {
                    file.previewElement.classList.add("dz-error");
                }
            });
        });';

    }

    /*
    $selectbox 陣列格式，傳入select的id (array(0=>'#pt_id_l1',1=>'#pt_id','層級key'=>'欄位id'))
    $val_input = 預設值的欄位id(input type=text，val格式'1,2,3')
    $phpfile = 後端php檔案
     */
    public static function selectBoxManipulation_ajax($selectbox,$val_input = '',$phpfile) {
        if(count($selectbox)>1){
            $str = '';
            $str .= "
            <script type='text/javascript'>
            var defaultValue = false;";

            if($val_input!=''){
                $str .= "
                if (0 < $.trim($('$val_input').val()).length) {
                    var fullIdPath = $('$val_input').val().split(',');
                    defaultValue = true;
                }";
            }
            for($i=1,$num=count($selectbox)-1;$i<=$num;$i++){
                $i1=$i-1;
                $str .= "
                $('$selectbox[$i1]').change(function () {
                    $('$selectbox[$i]').removeOption(/.?/).ajaxAddOption(
                        '$phpfile',
                        { 'id': $(this).val(),'lv':$i1},
                        false,
                        function () {
                            // 設定預設選項
                            if (defaultValue) {
                                $(this).selectOptions(fullIdPath[1]).trigger('change');
                            } else {
                                $(this).selectOptions().trigger('change');
                            }
                        }
                    );
                })";
            }

            $str .= "
            if (defaultValue) {
                $('$selectbox[0]').selectOptions(fullIdPath[0]);
                $('$selectbox[0]').trigger('change');
            }else{";
              for($i=1,$num=count($selectbox)-1;$i<=$num;$i++){
                $str .= "$('$selectbox[$i] option').remove();
                $('$selectbox[$i]').append($('<option>請選擇</option>'));";
              }
            $str .= "}
            </script>";
            return $str;
        }
    }
    public static function selectBoxManipulation($selectbox,$dataary,$val=array(),$preset=false,$presettext='請選擇') {
        if(count($selectbox)>1){
            $dataary=json_encode($dataary);
            $str = '';
            $str .= "
            <script type='text/javascript'>";
            for($i=0,$num=count($selectbox);$i<$num;$i++){
                $cid = json_encode(array_slice($selectbox,$i+1));
                $str .= "
                     setTimeout(function () {
                      $('#{$selectbox[$i]}').coderselectBoxManipulation({lv:".$i.",cid:".$cid.",dataary:".$dataary.",valary:'".(isset($val[$i])?$val[$i]:'')."',preset:'".$preset."',presettext:'".$presettext."'});
                     }, 100);";
            }
            $str .="
            </script>
            ";
            return $str;
        }
    }
}
?>