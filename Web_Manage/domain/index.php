<?php
include_once('_config.php');
include_once('filterconfig.php');

/* ## coder [listHelp] --> ## */
$listHelp=new coderListHelp('table1',$page_title);
$listHelp->editLink="manage.php";
$listHelp->addLink="manage.php";
$listHelp->ajaxSrc="service.php";
$listHelp->delSrc="delservice.php";
//$listHelp->excelLink="savetoexcel.php"; //匯出 excel

$col=array();
$col[]=array('column'=>'id','name'=>'ID','order'=>true,'width'=>'60','def_desc'=>'desc');
$col[]=array('column'=>'domain','name'=>'domain','order'=>true,);

$col[]=array('column'=>'createtime','name'=>'建立時間','order'=>true,'width'=>'150');
//$col[]=array('column'=>'is_survey','name'=>'問卷','order'=>true,'width'=>'100');

$listHelp->Bind($col);
$listHelp->bindFilter($filterhelp);

/* ## coder [listHelp] <-- ## */

$db = Database::DB();
coderAdminLog::insert($adminuser['username'],$logkey,'view');
$db->close();
?>
<!DOCTYPE html>
<html>
    <head>
		<?php include('../head.php');?>
        <link rel="stylesheet" type="text/css" href="../assets/jquery-ui/jquery-ui.min.css" />
        <style>
            .ui-sortable-helper{
                background-color: white!important;
                border:none!important;
            }
        </style>
    </head>
    <body >
		<?php include('../navbar.php');?>
        <!-- BEGIN Container -->
        <div class="container" id="main-container">
			<?php include('../left.php');?>
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

                <!-- BEGIN Breadcrumb -->
                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="../home/index.php">Home</a>
                            <span class="divider"><i class="icon-angle-right"></i></span>
                        </li>
                        <?php echo $mtitle?>

                    </ul>
                </div>
                <!-- END Breadcrumb -->

                <!-- BEGIN Main Content -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-title">
                                <h3 style="float:left"><i class="icon-table"></i> <?php echo $page_title?></h3>
                                <div class="box-tool">
                                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                                    <a data-action="close" href="#"><i class="icon-remove"></i></a>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                            <div class="box-content">
                                <?php echo $listHelp->drawTable()?>
                            </div>
                        </div>
                    </div>
                </div>


				<?php include('../footer.php');?>

                <a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="icon-chevron-up"></i></a>
            </div>
            <!-- END Content -->
        </div>
        <!-- END Container -->
		<?php include('../js.php');?>

        <script type="text/javascript" src="../js/coderlisthelp.js"></script>

		<script type="text/javascript">
			$( document ).ready(function() {
                /* ## coder [listRow] --> ## */
                $('#table1').coderlisthelp({debug:true,callback:function(obj,rows){
                	obj.html('');
                	var count=rows.length;
                	for(var i=0;i<count;i++){
                		var row=rows[i];
                		var $tr=$('<tr></tr>');
                        $tr.attr("editlink","id="+row["id"]);
                        $tr.attr("delkey",row["id"]);
                        $tr.attr("title",row["id"]+'. '+row["name"]);

                        $tr.append('<td>'+row["id"]+'</td>');
                        $tr.append('<td>'+row["domain"]+'</td>');
                        
                        $tr.append('<td>'+row["createtime"]+'</td>');
                        //$tr.append('<td><button class="show-popover btn btn-sm btn-'+(row["is_survey"]==1?'lime':'gray')+'"'+(row["is_survey"]==0?'':' onclick="openBox(\'../survey/index.php?get_id='+row["id"]+'\')" data-trigger="hover" data-placement="left" data-content="'+row["name"]+' 問卷內容" data-original-title="'+row["id"]+'. '+row["name"]+'"')+'><i class="icon-table"></i></button></td>');
                
                		obj.append($tr);
                	}
                },listComplete:function(){
                    $('#table1').find('img').click(function(){
                        $.colorbox({href:$(this).attr('src'),initialWidth:'50px',initialHeight:'50px',maxHeight:'80%'});
                    });
                    $('.show-popover').popover();
                    
                }});
                /* ## coder [listRow] <-- ## */
            });
		</script>
    </body>
</html>
