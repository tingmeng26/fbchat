<?php
include_once('_config.php');
include_once('filterconfig.php');

/* ## coder [listHelp] --> ## */
$listHelp = new coderListHelp('table1', $page_title);
$listHelp->mutileSelect = true;
$listHelp->ajaxSrc = "service.php";
$listHelp->delSrc = "delservice.php";
$listHelp->excelLink = "savetoexcel.php?type=-1"; //匯出 excel

$col = array();
$col[] = array('column' => 'id', 'name' => 'ID', 'order' => true, 'width' => '30');
$col[] = array('column' => 'psid', 'name' => 'PSID', 'order' => true, 'width' => '120');
$col[] = array('column' => 'name', 'name' => '姓名', 'order' => true, 'width' => '80');
$col[] = array('column' => 'email', 'name' => 'Day5 Email', 'order' => true, 'width' => '200');
$col[] = array('column' => 'email2', 'name' => 'Day10 Email', 'order' => true, 'width' => '200');

$col[] = array('column' => 'd1', 'name' => 'Day1', 'order' => true, 'width' => '60');
$col[] = array('column' => 'd2', 'name' => 'Day2', 'order' => true, 'width' => '60');
$col[] = array('column' => 'd3', 'name' => 'Day3', 'order' => true, 'width' => '60');
$col[] = array('column' => 'd4', 'name' => 'Day4', 'order' => true, 'width' => '60');
$col[] = array('column' => 'd5', 'name' => 'Day5', 'order' => true, 'width' => '60');
$col[] = array('column' => 'd6', 'name' => 'Day6', 'order' => true, 'width' => '60');
$col[] = array('column' => 'd7', 'name' => 'Day7', 'order' => true, 'width' => '60');
$col[] = array('column' => 'd8', 'name' => 'Day8', 'order' => true, 'width' => '60');
$col[] = array('column' => 'd9', 'name' => 'Day9', 'order' => true, 'width' => '60');
$col[] = array('column' => 'd10', 'name' => 'Day10', 'order' => true, 'width' => '60');
$col[] = array('column' => 'result', 'name' => '進度', 'order' => true, 'width' => '100');
$col[] = array('column' => 'notify', 'name' => '通知', 'order' => true, 'width' => '100');
$col[] = array('column' => 'notify', 'name' => '通知結果', 'order' => false, 'width' => '120');
$col[] = array('column' => 'notify', 'name' => '個別通知', 'order' => false, 'width' => '120');

$col[] = array('column' => 'createtime', 'name' => '建立時間', 'order' => true, 'width' => '120');
$col[] = array('column' => 'updatetime', 'name' => '最後更新時間', 'order' => true, 'width' => '120', 'def_desc' => 'desc');
$col[] = array('column' => 'notifytime', 'name' => '最後通知時間', 'order' => true, 'width' => '120');

$listHelp->Bind($col);
$listHelp->bindFilter($filterhelp);

/* ## coder [listHelp] <-- ## */

$db = Database::DB();
coderAdminLog::insert($adminuser['username'], $logkey, 'view');
$db->close();
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('../head.php'); ?>
    <link rel="stylesheet" type="text/css" href="../assets/jquery-ui/jquery-ui.min.css"/>
    <style>
        .ui-sortable-helper {
            background-color: white !important;
            border: none !important;
        }
    </style>
</head>
<body>
<?php $get_id <= 0 && include('../navbar.php'); ?>
<!-- BEGIN Container -->
<div class="container" id="main-container">
    <?php $get_id <= 0 && include('../left.php'); ?>
    <!-- BEGIN Content -->
    <div id="main-content">
        <!-- BEGIN Page Title -->
        <div class="page-title">
            <div>
                <h1><i class="<?php echo $mainicon ?>"></i> <?php echo $page_title ?>管理</h1>
                <h4><?php echo $page_desc ?></h4>
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
                <?php echo $mtitle ?>

            </ul>
        </div>
        <!-- END Breadcrumb -->

        <!-- BEGIN Main Content -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-title">
                        <h3 style="float:left"><i class="icon-table"></i> <?php echo $page_title ?></h3>
                        <div class="box-tool">
                            <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                            <a data-action="close" href="#"><i class="icon-remove"></i></a>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                    <div class="box-content">
                        <?php echo $listHelp->drawTable() ?>
                    </div>
                </div>
            </div>
        </div>


        <?php include('../footer.php'); ?>

        <a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="icon-chevron-up"></i></a>
    </div>
    <!-- END Content -->
</div>
<!-- END Container -->
<?php include('../js.php'); ?>

<script type="text/javascript" src="../js/coderlisthelp.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        /* ## coder [listRow] --> ## */
        $('#table1').coderlisthelp({
            debug: true, callback: function (obj, rows) {
                obj.html('');
                var count = rows.length;
                for (var i = 0; i < count; i++) {
                    var row = rows[i];
                    var $tr = $('<tr></tr>');
                    $tr.attr("editlink", "id=" + row["id"]);
                    $tr.attr("delkey", row["id"]);
                    $tr.attr("title", row["psid"] + ': ' + row["name"]);

                    $tr.append('<td>' + row["id"] + '</td>');
                    $tr.append('<td>' + row["psid"] + '</td>');
                    $tr.append('<td>' + row["name"] + '</td>');
                    $tr.append('<td>' + row["email"] + '</td>');
                    $tr.append('<td>' + row["email2"] + '</td>');

                    $tr.append('<td>' + row["d1"] + '</td>');
                    $tr.append('<td>' + row["d2"] + '</td>');
                    $tr.append('<td>' + row["d3"] + '</td>');
                    $tr.append('<td>' + row["d4"] + '</td>');
                    $tr.append('<td>' + row["d5"] + '</td>');
                    $tr.append('<td>' + row["d6"] + '</td>');
                    $tr.append('<td>' + row["d7"] + '</td>');
                    $tr.append('<td>' + row["d8"] + '</td>');
                    $tr.append('<td>' + row["d9"] + '</td>');
                    $tr.append('<td>' + row["d10"] + '</td>');

                    $tr.append('<td>' + row["result"] + '</td>');
                    $tr.append('<td>' + row["notify"] + '</td>');
                    $tr.append('<td>' + row["notify_fail_layout"] + '</td>');
                    $tr.append('<td><a href="javascript:;" class="badge badge-large badge-lime notify_btn" data-psid="'+row["psid"]+'"><i class="icon-external-link"></i>個別通知</a></td>');

                    $tr.append('<td>' + row["createtime"] + '</td>');
                    $tr.append('<td>' + row["updatetime"] + '</td>');
                    $tr.append('<td>' + row["notifytime"] + '</td>');

                    obj.append($tr);
                }
            }
        });

        $("#submit").after('<span>&nbsp;&nbsp;<button type="button" class="btn btn-danger notifyDay"><i class=" icon-cog"></i> 活動每日通知</button></span>');

        $("#filterform").on("click",".notifyDay", function(){
            if(confirm("確定要通知每日活動開始訊息？")){
                //alert("hahaha");
                $.ajax({
                    url: 'dayNotify.php',
                    data: {},
                    type:"POST",
                    dataType:'json',
                    success: function(r){
                        console.log(r);
                        if(r.result){
                            showNotice("ok","成功",'通知完成。<br>');
                            //if(r.data.content){
                                // var scores = JSON.stringify(r.data.content);
                                // var content = r.data.content;
                                // alert("刪除圖檔\n"+content);
                           // }
                            
                            $('#table1').find('#refreshBtn').click();
                            
                        }else{
                            // alert(r.msg);
                            showNotice("alert","失敗",'通知失敗。<br>');
                        }
                    }
                });
            }
        });

        $('#table1').on('click', '.notify_btn', function(){
            var psid = $(this).data('psid');
            if (psid) {
                if(confirm("確定要通知使用者: "+psid+" 每日活動開始訊息？")){
                    $.ajax({
                    url: 'dayNotify.php',
                    data: {psid: psid},
                    type:"POST",
                    dataType:'json',
                    success: function(r){
                        console.log(r);
                        if(r.result){
                            showNotice("ok","成功",'通知完成。<br>');                            
                            $('#table1').find('#refreshBtn').click();
                            
                        }else{
                            // alert(r.msg);
                            showNotice("alert","失敗",'通知失敗。<br>');
                        }
                    }
                });
                }
            }
        });
        /* ## coder [listRow] <-- ## */
    });
</script>
</body>
</html>
