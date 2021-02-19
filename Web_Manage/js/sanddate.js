$("#sanddate_btn").addClass("btn-warning").append('<i class="icon-truck"></i>').attr("data-original-title","寄出");
$("#sanddate_btn").click(function(){sanddateChooseItem(this);})
function sanddateChooseItem(_this){
	var parent = $(_this).parent().parent().parent();
	var list=new Array();
	var listname="";
	parent.find('tbody tr').each(function(){
		var tr=$(this);
		if(tr.find('td:eq(0) input[type="checkbox"]').prop("checked")){
			list[list.length]=tr.attr('sandkey');
			listname+='\r\n'+tr.attr('title');
		}
	})
	if(list.length>0){
		if(confirm('您確定要寄出這些項目嗎?'+listname)){
			sanddateList(list);
		}
	}
	else{
		alert('請先選擇要被寄出的項目');
	}
}
function sanddateList(list){
	var parent=this;
	$.ajax({
	url:"sanddate.php",
	cache: false,
	type:"POST",
	data:{ id : list } ,
	dataType:"json",
	success:function(data){
		if(data.result==true){
			showNotice('ok','更新作業完成','您己成功標示寄出'+data.num+'筆資料');
			$("#refreshBtn").click();
		}
		else{
			showNotice('alert','更新作業失敗',data.msg);
		}
	}
	,error:function(xhr, ajaxOptions, thrownError){
		showNotice('alert','讀取資料時發生錯誤,請梢候再試',thrownError);
	}
	});			
}