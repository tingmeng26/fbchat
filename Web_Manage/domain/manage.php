<?php
include_once('_config.php');
include_once('formconfig.php');
$errorhandle=new coderErrorHandle();
$id=get('id',1);
$manageinfo="";
/* ## coder [initData] --> ## */

/* ## coder [initData] <-- ## */
try{

	if($id!=""){
		
		
		$db = Database::DB();
		$row=$db->query_prepare_first("select * from $table  WHERE `id`=:id",array(':id'=>$id));
		if(empty($row)){throw new Exception("查無相關資料!");}
		/* ## coder [bindData] --> ## */
		$manageinfo='   建立時間 : '.$row["createtime"].' | 上次修改時間 : '.$row["updatetime"];
		/* ## coder [bindData] <-- ## */
		/* ## coder [beforeBind] --> ## */
		/* ## coder [beforeBind] <-- ## */	


		$fhelp->bindData($row);

		$method='edit';
		$active='編輯';
		
		$db->close();
	}else{
		
		$method='add';
		$active='新增';
	}
}catch(Exception $e){
	$db->close();
	$errorhandle->setException($e);
}
if ($errorhandle->isException()) {
	$errorhandle->showError();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include('../head.php');?>
		<link rel="stylesheet" type="text/css" href="../assets/dropzone/downloads/css/dropzone.css" />
		<link rel="stylesheet" type="text/css" href="../assets/jcrop/jquery.Jcrop.min.css" />
		<link href="../assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
		<!-- ## coder [phpScript] -> ## -->

		<!-- ## coder [phpScript] <- ## -->

	</head>
	<body>
		<!-- BEGIN Container -->
		<div class="container" id="main-container">
			<!-- BEGIN Content -->
			<div id="main-content">
				<!-- BEGIN Page Title -->
				<div class="page-title">
					<div>
						<h1><i class="<?php echo $mainicon?>"></i> <?php echo $page_title?>管理</h1>
						<h4><?php echo $page_desc?></h4>
					</div>
				</div>
				<!-- END Page Title -->
				<?php if ($manageinfo!='') {?>
				<div class="alert alert-info">
					<button class="close" data-dismiss="alert">&times;</button>
					<strong>系統資訊 : </strong> <?php echo $manageinfo?>
				</div>
				<?php }?>
				<!-- BEGIN Main Content -->
				<div class="row">
					<form  class="form-horizontal" action="save.php" id="myform" name="myform" method="post">
					<?php echo $fhelp->drawForm("id")?>
					<div class="col-md-12">
						<div class="box">
							<div class="box-title">
								<h3><i class="<?php echo getIconClass($method)?>"></i> <?php echo $page_title.$active?></h3>
								<div class="box-tool">
									<a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
									<a data-action="close" href="#"><i class="icon-remove"></i></a>
								</div>
							</div>
							<div class="box-content">
								<div class="row">
								  	<!--left start-->
									<div class="col-md-7">
									<!-- ## coder [formScript] -> ## -->
                                        <div class="form-group">
                                            <label class="col-sm-3 col-lg-3 control-label" >
                                            <?php echo $fhelp->drawLabel("domain")?> </label>
                                            <div class="col-sm-7 controls">
                                                 <?php echo $fhelp->drawForm("domain")?>
                                            </div>
                                        </div>  
									<!-- ## coder [formScript] <- ## -->
										<div class="form-group">
											<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-3">
												<button type="submit" class="btn btn-primary" ><i class="icon-ok"></i>完成<?php echo $active?></button>
												<button type="button" class="btn" onClick="if(confirm('確定要取消<?php echo $active?>?')){parent.closeBox();}"><i class="icon-remove"></i>取消<?php echo $active?></button>
											</div>
										</div>
									</div>
								  	<!--left end-->

								</div>
							</div>
						</div>
					</div>
					</form>
				</div>
				<!-- ## coder [SEOScript] -> ## -->
				<!-- ## coder [SEOScript] <- ## -->
				<!-- END Main Content -->
				<?php include('../footer.php');?>
				<a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="icon-chevron-up"></i></a>
			</div>
			<!-- END Content -->
		</div>
		<!-- END Container -->


		<?php include('../js.php');?>
		<script type="text/javascript" src="../assets/jquery-validation/dist/jquery.validate.js"></script>
		<script type="text/javascript" src="../assets/jquery-validation/dist/additional-methods.js"></script>
		<script type="text/javascript" src="../assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
		<script type="text/javascript" src="../assets/ckeditor/ckeditor.js"></script>
		<!-- 多圖上傳 -->
		<script type="text/javascript" src="../assets/dropzone/downloads/dropzone.min.js"></script>
		<!-- 裁圖&傳圖 -->
		<script type="text/javascript" src="../assets/jcrop/jquery.Jcrop.min.js"></script>
		<!-- ## coder [includeScript] -> ## -->
		<script type="text/javascript" src="../js/coderfileupload.js"></script>
					<script type="text/javascript" src="../js/coderpicupload.js"></script>
					
		<!-- ## coder [includeScript] <- ## -->
		<script type="text/javascript">
		$(document).ready(function(){
		/* ## coder [jsScript] --> ## */
		
		       
		/* ## coder [jsScript] <-- ## */
		<?php echo coderFormHelp::drawVaildScript();?>
		jQuery.validator.addMethod("morethen",
		   function (value, element, param) {
			   $("#"+param).parent().find("span").html("");
			   var thisvalue = value,
			       targetvalue  = $("#"+param).val();
			   return (thisvalue>targetvalue);
		}, $.validator.format("必須大於開始時間的値"));
		/* ## coder [jsVaildScript] --> ## */
		/* ## coder [jsVaildScript] <-- ## */
		})

		if(CKEDITOR){
			CKEDITOR.config.contentsCss = ['../../css/style.css'];//ckeditor內載入css
		}
		//CKEDITOR.scriptLoader.load( 'alert.js' );//ckeditor內載入js
		</script>
	</body>
</html>
