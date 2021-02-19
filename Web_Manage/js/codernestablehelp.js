
(function($) {
$.fn.codernestablehelp = function(settings) {
    var _defaultSettings = {
    	id:'nestable',
		delsrc:'delservice.php',
		maxdepth:2,
		debug:false
    };
    
    var _settings = $.extend(_defaultSettings, settings);
    var $obj=$('#'+_settings.id);
    $obj.nestable({maxDepth :_settings.maxdepth});
        $obj.on('dragEnd', function(event, item, source, destination, position) {
            alert('此功能尚未開放,請勿使用');
        });

    init=function(){
    	$obj.find('.dd-item').each(function(){
            bindEvent($(this));
    	});
        bindEvent($obj.children('.functions'));

    }

    bindEvent=function($item){
            var parent_len=($item.parents("ol.dd-list").length);


            var data_id=$item.attr('data-id');
            if(parent_len<_settings.maxdepth){
                $btn_add=$('<a class="btn btn-xs show-tooltip btn-info pull-right" title="新增子項目" href="javascript:void(0)"><i class="icon-plus"></i></a>');
                $btn_add.click(function(){
                    var parent_len=($item.parents("ol.dd-list").length);
                    if(parent_len==_settings.maxdepth){
                        alert('達到階層上限,無法層加子項目');
                        return ;
                    }
                openBox('manage.php?pid='+data_id,'70%','80%');
                }
                );
                $item.prepend($btn_add);
            }
            $btn_edit=$('<a class="btn btn-xs show-tooltip btn-success pull-right" title="修改" href="javascript:void(0)"><i class="icon-edit"></i></a>');
            $btn_del=$('<a id="delbtn" class="btn btn-xs btn-danger show-tooltip pull-right" title="刪除" href="javascript:void(0)"><i class="icon-trash"></i></a>');

            $btn_edit.click(function(){
                openBox('manage.php?id='+data_id,'70%','80%');
            });
            $btn_del.click(function(){
                if(confirm('您確定要刪除這個分類?(此分類底下的商品會成為未分類商品)')){
                    deleteItem(data_id);
                }
            });

            $item.prepend($btn_edit);
            $item.prepend($btn_del);

        if($item.find("[data-action='collapse']").length==0){
            $item.prepend('<button data-action="collapse" type="button" style="display:none" >Collapse</button>');
        }
        if($item.find("[data-action='expand']").length==0){
            $item.prepend('<button data-action="expand" type="button" style="display:none">Expand</button>');
        }
    }
    deleteItem=function(id){
        var parent=this;
        var list=new Array();
        list[0]=id;
        $.ajax({
        url:_settings.delsrc,
        cache: false,
        type:"POST",
        data:{ id : list ,action:'delete'} ,
        dataType:"json",
        success:function(data){
            if(data.result==true){
                removeItem(id);
                showNotice('ok','刪除作業完成','您己成功刪除此分類');
            }
            else{
                showNotice('alert','刪除作業失敗',data.msg);
            }
        }
        ,error:function(xhr, ajaxOptions, thrownError){
            oops("讀取資料時發生錯誤,請梢候再試"+thrownError,xhr);
            stopload();
        }
        });
    }
    removeItem=function(id){
        $item=$obj.find("li.dd-item[data-id=\""+id+"\"]");
        if($item.siblings().length==0){
            $parent=$item.parent().parent();
            $parent.find("[data-action='collapse']").hide();
            $parent.find("[data-action='expand']").hide();
        }

        $item.remove();
    }
    init();
    return {
    	insert:function(id,title,pid){
    		var $parent= pid>0 ? $obj.find("li.dd-item[data-id=\""+pid+"\"]") : $obj;
            if($parent){
                $list=$parent.children('.dd-list');
                if($list.length<1){
                    $list=$('<ol class="dd-list"></ol>');
                    $parent.append($list);
                }
                $item=$('<li class="dd-item" data-id="'+id+'" ><div class="dd-handle">'+title+'</div>');
                bindEvent($item);
                $list.append($item);
                $parent.children("[data-action='collapse']").show();
                $parent.children("[data-action='expand']").hide();
            }
    	},
        edit:function(id,title,pid){
            var $item=$obj.find("li.dd-item[data-id=\""+id+"\"]").find(".dd-handle");
            $item.html(title);
        }
    }

};
})(jQuery);