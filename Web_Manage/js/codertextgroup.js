/*需多掛載css/codertextgroup.css
Jane 新增select功能('ary':[{'value':'1','name':'1'},{'value':'2','name':'2'}]})
2014.9.25 Jane 新增驗證功能於text及select及checkbox('validate':[{'digits':'yes'},{'required':'yes'}])
2014.10.30 Jane 修改 每行加上id流水號(rowid) 配合sava.php 給id值
2014.10.31 Jane 修改 加入placeholder功能('placeholder':'placeholder文字')  只對text有用
2014.11.18 Jane 修改 圖片上傳修改，value為圖檔名，需多傳file_path:'路徑位址'。
20150119 Jane 新增radio功能(用法同select)
20150120 Jane 新增多語系(input=text，key值放共通名稱，'multi_language':[{'zh_hant':'繁中','zh_hans':'簡中','en':'英文'}])
              新增上下移動排序功能(呼叫textgroup時多傳入orderColumn參數)
20150216 Jane 新增上傳file檔案(取得欄位id)
20150317 Jane 新增type=selectBoxManipulation 可針對個別下驗證('validate_pre':[{'此欄位的thisid屬性值':[{'required':'yes'}]}])
20150427 Jane 新增參數 排序順序數字是否顯示 _showordernum false/true
*/

CODER.Util.TextGroup=function(_id,_title,_rowid,_option,readonly,_orderColumn,_showordernum) {
    var id = _id;
    var title = _title;
    var rowid = _rowid;
    var option=_option;
    //private
    var parent = $('#' + id);
    var readonly = readonly || false;
    var orderColumn = _orderColumn || '';
    var showordernum =  _showordernum || false;
    var max = option.max || -1;
    var table ;
	var click_num=1;//第幾列tr
    return {
        init: function () {
            parent.html('');
            table = $('<table class="table codertextgroup" style="width:100%"></table>');
            var str = '<thead>';
            if(showordernum == true){
                str += '<th style="min-width:90px" class="text-center">順序</th>';
            }
            for (var i = 0, c = option.length; i < c; i++) {
                if(option[i].type!='selectBoxManipulation'){//改
                    str += '<th style="width:'+option[i].width+'">'+option[i].name+'</th>';
                }else{
                    for(j=0,count = option[i].key.length;j<count;j++){
                        str += '<th style="width:'+option[i].width[j]+'">'+option[i].name[j]+'</th>';
                    }
                }
            }
            if (orderColumn != ""){
                str += '<th style="min-width:90px" class="text-center">排序</th>';
            }
            if (readonly == false) {
                str += '<th width="20"><button class="btn btn-primary" type="button"  id="insertBtn"><i class="icon-plus"></i></button></th>';
            }
            str+='</thead>';
            table.html(str);
            parent.append(table);
            var obj = this;
            table.find('#insertBtn').click(function () {
                obj.insert("",click_num);
				click_num++;
            });
			obj.eventagain();
        },
        initValue: function (def) {
            for (var i = 0, c = def.length; i < c; i++) {
                this.insert(def[i],click_num);
				click_num++;
            }
        }
        ,
        insert: function (obj,click_num) {

            $('#'+id+' button#insertBtn').show();
            if (max==-1 || (max > 0 && parent.find("tr.content").length < max)) {
                //var isselectManipulation = false;//改
                var $str = $('<tr class="content" '+(obj==""?"":(obj.hasOwnProperty(rowid)?'rowid="'+obj[rowid]+'"':''))+'></tr>');
                table.append($str);

                if(showordernum == true){
                    $str.append('<td class="text-center order_num">'+click_num+'</td>');
                }

				for (var i = 0, c = option.length; i < c; i++) {

                    var val = "";
                    if (obj) {
                        if(option[i].multi_language){
                            var val = new Array();
                            //console.log(option[i].multi_language);
                            //alert(option[i].multi_language)
                            for(var languagekey in option[i].multi_language){
                                for(var languagei in option[i].multi_language[languagekey]){
                                    val[languagei] = obj[option[i].key+'_'+languagei];
                                }
                            }

                        }else if(option[i].type=='selectBoxManipulation'){
                            val = new Array();
                            //console.log(obj);
                            for(var sbmkey in option[i].key){
                                for(var sbmkeyin in option[i].key[sbmkey]){
                                    val[option[i].key[sbmkey]] = obj[option[i].key[sbmkey]];
                                }
                            }
                        }else{
                            var val = "";
                            val = obj[option[i].key]==null?'':obj[option[i].key];
                        }
                    }

                    //改
                    for(oi=0,count = (option[i].type=='selectBoxManipulation'?option[i].key.length:1);oi<count;oi++){
                        var $td = $('<td width="' + option[i].width[oi] + '"></td>');
                        this.getInput($str.index(), $td, option[i], val,click_num,id,oi);
                        $str.append($td);
                    }
                }
                /*if(isselectManipulation){//改
                    this.selectBoxManipulation();
                }*/
                if (orderColumn != ""){
                    $str.append('<td class=" text-center"><button class="btn show-tooltip btn-info" type="button" title="上移" onclick="if($(this).parent().parent().prev().length>0){var ordernum = parseInt($(this).parent().parent().prev().find(\'.order_num\').text());$(this).parent().parent().prev().find(\'.order_num\').text(ordernum+1);$(this).parent().parent().find(\'.order_num\').text(ordernum);$(this).parent().parent().prev().before($(this).parent().parent());}"><i class="icon-angle-up" id=""></i></button>\
                        <button class="btn show-tooltip btn-info" type="button" title="下移" onclick="if($(this).parent().parent().next().length>0){var ordernum = parseInt($(this).parent().parent().find(\'.order_num\').text());$(this).parent().parent().find(\'.order_num\').text(ordernum+1);$(this).parent().parent().next().find(\'.order_num\').text(ordernum);$(this).parent().parent().next().after($(this).parent().parent())}"><i class="icon-angle-down" id=""></i></button></td>');
                }
                if (readonly == false) {
                    $str.append('<td><button class="btn btn-danger removeBtn" type="button" onclick="$(this).parent().parent().remove();$(\'#'+id+' button#insertBtn\').show();"><i class="icon-trash"></i></button></td>');
                }
            }
            if(max > 0 && parent.find("tr.content").length >= max){
                $('#'+id+' button#insertBtn').hide();
            }
        },
        getInput: function (ind, $td, obj, val,click_num,thisdivid,selectBoxManipulation_oi) {
			var validate="";
            var multi_language="";
			var placeholder="";
            var type = "";
			var attr = "";
			var ary_iconformat = new Array("","");

			if(obj.validate){validate = obj.validate;}
			if(obj.placeholder){placeholder = obj.placeholder;}
            if(obj.multi_language){multi_language = obj.multi_language;}
            if (obj.type)
            {
                type = obj.type;
            }else {
                type = "text";
            }
            if (type == "pic") {
                var file_path = "",
                    spic_size_w = 500,
                    spic_size_h = 500;
				if(obj.file_path){var file_path = obj.file_path;}
                if(obj.spic_size_w){var spic_size_w = obj.spic_size_w;}
                if(obj.spic_size_h){var spic_size_h = obj.spic_size_h;}
				var id = obj.key + '_' +click_num;
                var org_pic = null;


                if (val) {
                    org_pic = new Array();
                    //var index = val.lastIndexOf('/');
					//org_pic["filepath"] = val.substr(0, index + 1);
                    //org_pic["filename"] = val.substr(index + 1);
                    org_pic["filepath"] = file_path;
                    org_pic["filename"] = val;
                    org_pic["width"] = '';
                    org_pic["height"] = '';
                }
                if (obj.readonly == true) {
                    $td.append('<img src="' + file_path+val + '" width="50"><input type="hidden" name="' + obj.key + '" id="' + id + '" thisid="' + id + '" value="' + org_pic["filename"] + '" readonly>');
                }
                else {
					if(validate != ""){
						for(var key in validate){
							for(var i in validate[key]){
								if(i == "required" && (validate[key][i]=="yes" ||  validate[key][i]=="true")){
									var required_o = true;
								}else{var required_o = false};
							}
						}
					}

                    $td.append('<div name="' + obj.key + '" id="' + id + '" thisid="' + id + '" class="'+obj.key+'"></div>');
                    setTimeout(function () {
                        $('#' + id).coderpicupload({ id: obj.key, pics: [{name:'縮圖',type:6,tag:'s',width:spic_size_w,height:spic_size_h}], width: '100', height: '100',required: required_o , org_width: '50px', org_height: '50px', org_pic: org_pic, position: 'right', tag: obj.name });
                    }, 100);
                }
            }
            else if (type == "checkbox") {
                var readonly_attr = obj.readonly == true ? " disabled='disabled' " : "";
                var attr = val == 1 ? " checked " : "";
				if(validate != ""){
					for(var key in validate){
						for(var i in validate[key]){
						   attr += (i+"="+validate[key][i]+" ");
						}
					}
				}
                $td.append('<div class="form-group"><input type="checkbox" name="' +thisdivid+obj.key+click_num + '" id="' +thisdivid+obj.key+click_num +'" thisid="'+obj.key+'" tag="' + obj.name + '" ' + attr + ' ' + readonly_attr + '/></div>');

            }
            else if (type == "checkboxgroup") {
                var readonly_attr = obj.readonly == true ? " disabled='disabled' " : "";
                var checked = '';
                var str = "";
                if(obj.ary){var dataary = obj.ary;}
                if(validate != ""){
                    for(var key in validate){
                        for(var i in validate[key]){
                           attr += (i+"="+validate[key][i]+" ");
                        }
                    }
                }
                str += '<div class="form-group">';
                for (var i = 0,c = dataary.length; i < c; i++) {
                    if(val & dataary[i].value){
                        checked = " checked ";
                    }else{checked ='';}
                    str += '<input type="checkbox" thistype="checkboxgroup" name="' +thisdivid+obj.key+click_num + '" id="' +thisdivid+obj.key+click_num+i +'" value="'+dataary[i].value+'" thisid="'+obj.key+'" tag="' + obj.name + '_'+dataary[i].name+'" ' + checked + ' ' + readonly_attr + '/>'+dataary[i].name+'&nbsp;';
                }
                str += '</div>';
                $td.append(str);

            }
			else if (type == "select") {
                var readonly_attr = (obj.readonly == true ? "  disabled='disabled' " : "");
                var defval = val;
				var str = "";
				if(obj.ary){dataary = obj.ary;}
				var c = dataary.length;
				if(validate != ""){
					for(var key in validate){
						for(var i in validate[key]){
						   attr += (i+"="+validate[key][i]+" ");
						}
					}
				}
				str = '<div class="form-group"><select style="width: 100%;height:34px"  name="' +thisdivid+obj.key+click_num + '" id="' +thisdivid+obj.key+click_num + '" thisid="'+ obj.key + '" tag="' + obj.name + '" ' + ' ' + readonly_attr +' '+ attr +'>';
				str+= '<option value>請選擇</option>';
				for (var i = 0; i < c; i++) {
					var selected = "";
					if (defval != "" && dataary[i].value == defval) {
						var selected = "selected";
					}
					str+= '<option value="'+dataary[i].value+'" '+selected +'>' +dataary[i].name+ '</option>';
				}
				str += '</select></div>';
                $td.append(str);
            }
            else if (type == "selectBoxManipulation"){
                var readonly_attr = obj.readonly == true ? "  disabled='disabled' " : "";
                var defvalary = val,
                    defval='',
                    str = ""
                    validate_pre='';
                if(obj.ary){var dataary = obj.ary;}
                if(obj.validate_pre){validate_pre = obj.validate_pre;}
                if(validate != ""){
                    for(var key in validate){
                        for(var i in validate[key]){
                           attr += (i+"="+validate[key][i]+" ");
                        }
                    }
                }
                if(validate_pre != ""){
                    for(var key in validate_pre){
                        for(var i in validate_pre[key]){
                            if(i == obj.key[selectBoxManipulation_oi]){
                                for(var ikey in validate_pre[key][i]){
                                    for(var ii in validate_pre[key][i][ikey]){
                                       attr += (ii+"="+validate_pre[key][i][ikey][ii]+" ");
                                    }
                                }
                            }
                        }
                    }
                }

                str = '<div class="form-group"><select style="width: 100%;height:34px" class="form-control" name="' +thisdivid+obj.key[selectBoxManipulation_oi]+click_num + '" id="' +thisdivid+obj.key[selectBoxManipulation_oi]+click_num + '" thisid="'+ obj.key[selectBoxManipulation_oi] + '" tag="' + obj.name + '" ' + ' ' + readonly_attr +' '+ attr +'>';
                //str+= '<option value>請選擇</option>';
                str += '</select></div>';

                $td.append(str);

                var cid = [];
                for(var i=0,num=obj.key.length;i<num;i++){
                    cid[i]=thisdivid+obj.key[i]+click_num;
                }
                //console.log(defvalary);
                defval=defvalary[obj.key[selectBoxManipulation_oi]];
                //console.log(defval);

                setTimeout(function () {
                    $('#' + thisdivid+obj.key[selectBoxManipulation_oi]+click_num).coderselectBoxManipulation({lv:selectBoxManipulation_oi,cid:cid.slice(selectBoxManipulation_oi+1),dataary:dataary,valary:defval,preset:true});
                }, 100);
            }
            else if (type == "radio") {
                var readonly_attr = obj.readonly == true ? " disabled='disabled' " : "";
                var defval = val;
                var str = "";
                if(obj.ary){dataary = obj.ary;}
                var c = dataary.length;
                if(validate != ""){
                    for(var key in validate){
                        for(var i in validate[key]){
                            if(i == "required" && validate[key][i]=="yes"){
                                attr += (i+" aria-required='true'");
                            }
                        }
                    }
                }
                str = '<div class="form-group"><div>';
                for (var i = 0; i < c; i++) {
                    var checked = "";
                    if (defval != "" && dataary[i].value == defval) {
                        var checked = "checked";
                    }
                    str+= '<label><input type="radio" value="'+dataary[i].value+'" thisid="'+ obj.key+'" name="' +thisdivid+obj.key+click_num+ '" '+ checked +' '+ readonly_attr +' ' + attr +'>' +dataary[i].name+'</label>&nbsp;&nbsp;';
                }
                str += '</div></div>';
                $td.append(str);
            }
            else if(type == "textarea"){
                var readonly_attr =obj.readonly==true ?    " readonly='true' " : "" ;
                if(validate != ""){
                    for(var key in validate){
                        for(var i in validate[key]){
                           attr += (i+"="+validate[key][i]+" ");
                           var thisclass = "";
                               ary_iconformat = this.makeicon(i);
                           if(i=="date" && validate[key][i]=="yes"){thisclass += " date-picker ";}
                        }
                    }
                }
                if(multi_language != ""){
                    var input_text = "";
                    for(var key in multi_language){
                        for(var i in multi_language[key]){
                            input_text += '<div class="form-group">'+multi_language[key][i]+'<textarea class="form-control '+thisclass+'" rows="1" style="width:100%" name="' +thisdivid+obj.key+"_"+i+click_num + '" id="' +thisdivid+obj.key+"_"+i+click_num +'" thisid="'+ obj.key+"_"+i+ '" tag="' + obj.name + '" placeholder="'+ placeholder +'('+multi_language[key][i]+')" '+attr+' '+readonly_attr+'>'+(val.hasOwnProperty(i)?val[i]:"")+'</textarea></div>';
                        }
                    }
                    $td.append('<div class="form-group">'+input_text+'</div>');
                }else{
                    $td.append('<div class="form-group">'+'<textarea class="form-control '+thisclass+'" style="width:100%" name="' +thisdivid+obj.key+click_num + '" rows="3" id="' +thisdivid+obj.key+click_num +'" thisid="'+ obj.key + '" tag="' + obj.name + '" placeholder="'+ placeholder +'" '+attr+' '+readonly_attr+'>'+val+'</textarea></div>');
                }
            }
            // else if(type == "file"){
            //     if(validate != ""){
            //         for(var key in validate){
            //             for(var i in validate[key]){
            //                attr += (i+"="+validate[key][i]+" ");
            //                var thisclass = "";
            //             }
            //         }
            //     }
            //     if(val!=''){
            //         $td.append('<div class="form-group">'+'<input type="text" class="form-control '+thisclass+'" style="width:100%" name="' +thisdivid+obj.key+click_num + '" id="' +thisdivid+obj.key+click_num +'" thisid="'+ obj.key + '" tag="' + obj.name + '" value="' + val + '" '+attr+' readonly="true" thistype="file"/>'+'</div>');
            //     }else{
            //         $td.append('<div class="form-group">'+'<input type="file" class="'+thisclass+'" style="width:100%" name="' +thisdivid+obj.key+click_num + '" id="' +thisdivid+obj.key+click_num +'" thisid="'+ obj.key + '" tag="' + obj.name + '" value="' + val + '" placeholder="'+ placeholder +'" '+attr+' />'+'</div>');
            //     }
            // }
            else if(type == "file"){
                    var id = obj.key + '_' +click_num;
                    $td.append('<div name="' + obj.key + '" id="' + id + '" thisid="' + id + '" class="'+obj.key+'"></div>');
                    setTimeout(function () {

                        $('#' + id).coderfileupload({ id: obj.key,size_id:'',org_filename:val,org_filepath:obj.file_path,org_filesize:'',extname:'檔案只支援pdf,doc,docx,txt,jpg,jpeg',required:true });

                    }, 100);
            }
            else {
                var readonly_attr =obj.readonly==true ?    " readonly='true' " : "" ;
                if (type == "num") {
                    attr = " datatype='num' ";
                }
				if(validate != ""){
					for(var key in validate){
						for(var i in validate[key]){
						   attr += (i+"="+validate[key][i]+" ");
						   var thisclass = "";
						       ary_iconformat = this.makeicon(i);
						   if(i=="date" && validate[key][i]=="yes"){thisclass += " date-picker ";}
						}
					}
				}
                if(multi_language != ""){
                    var input_text = "";
                    for(var key in multi_language){
                        for(var i in multi_language[key]){
                            input_text += '<div class="form-group">'+multi_language[key][i]+'<input type="text" class="form-control '+thisclass+'" style="width:100%" name="' +thisdivid+obj.key+"_"+i+click_num + '" id="' +thisdivid+obj.key+"_"+i+click_num +'" thisid="'+ obj.key+"_"+i+ '" tag="' + obj.name + '" value="' + (val.hasOwnProperty(i)?val[i]:"") + '" placeholder="'+ placeholder +'('+multi_language[key][i]+')" '+attr+' '+readonly_attr+'/></div>';
                        }
                    }
                    $td.append('<div class="form-group">'+ary_iconformat[0]+input_text+ary_iconformat[1]+'</div>');
                }else{
                    $td.append('<div class="form-group">'+ary_iconformat[0]+'<input type="text" class="form-control '+thisclass+'" style="width:100%" name="' +thisdivid+obj.key+click_num + '" id="' +thisdivid+obj.key+click_num +'" thisid="'+ obj.key + '" tag="' + obj.name + '" value="' + val + '" placeholder="'+ placeholder +'" '+attr+' '+readonly_attr+'/>'+ary_iconformat[1]+'</div>');
                }
			}
        }
        ,
        /*chkValue: function () {
            var success=true;
            parent.find("tr.content").each(function () {
                var content = {};
                $(this).find("input[type=text],[type=hidden]").each(function () {
                    if ($(this).val() == "") {
                        alert(_title+"驗證錯誤! 請填寫[" + $(this).attr("tag") + "]的值");
                        $(this).focus();
                        success = false;
                    }
                    if ($(this).attr('datatype') == 'num' && isNaN($(this).val()) == true) {
                        alert(_title + "驗證錯誤! [" + $(this).attr("tag") + "]的值必須為數字");
                        $(this).focus();
                        success = false;
                    }
                    if (success == false) {
                        return false;
                    }
                });
            });
            return success;
        },*/
        getValue: function () {
            var obj = [];
            var tr_content_num = 1;
            parent.find("tr.content").each(function () {
                var content = {};
                var checkboxgroup_total = 0;
                $(this).find("input[type=text],input[type=hidden],input[type=checkbox],input[type=radio],input[type=file],select,textarea").each(function () {
                    if ($(this).attr("type") == "checkbox") {
                        if($(this).attr("thistype") != "checkboxgroup"){
                            content[$(this).attr("thisid")] = $(this).prop("checked") ? "1" : "0";
                        }else{
                            if($(this).prop("checked")){
                                checkboxgroup_total += parseInt($(this).val());
                                content[$(this).attr("thisid")] = checkboxgroup_total;
                            }
                        }
                    }else if($(this).attr("type") == "radio"){
                        if($(this).prop("checked")){
                            content[$(this).attr("thisid")] = $(this).val();
                        }else if(!content[$(this).attr("thisid")]){
                            content[$(this).attr("thisid")] = '';
                        }
                    }else if($(this).attr("type") == "file"){
                        content[$(this).attr("thisid")] = $(this).attr("name");
                    }
                    else {
                        if($(this).attr("thistype")=='file'){
                            content['value'] = $(this).val();
                        }else if ($(this).attr("thisid") && $(this).attr("thisid")!='undefined'){
                            content[$(this).attr("thisid")] = $(this).val();
                        }
                        else{
                            content[$(this).attr("id")] = $(this).val();
                        }
                    }
                });
				content[rowid] = $(this).attr("rowid");
                if(orderColumn!=''){content[orderColumn] = tr_content_num;}
                obj.push(content);
                tr_content_num++;
            });
            return JSON.stringify(obj);
        },
        setMax: function (val) {
            max = val;
        },
		makeicon: function(icontype){//繪製icon
			var ary_iconformat = new Array("","");
			switch(icontype){
				case "date":
				     ary_iconformat[0] = '<div class="input-group date">';
					 ary_iconformat[1] = '<div class="input-group-addon" style="height:20px"><i class="icon-calendar"></i></div></div>';
					 break;
			}
			return ary_iconformat;
		},
		eventagain: function(){//重新綁定事件(日歷)
		    $("#insertBtn").click(function(){
			//$(document).on("click", "#insertBtn", function(){
				if (jQuery().datepicker) {
					$('.date-picker').datepicker({ format: 'yyyy-mm-dd' });
				}
			})
		}
    }

}
