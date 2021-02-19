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

$col[] = array('column' => 'q1', 'name' => 'Q1', 'order' => true, 'width' => '80');
$col[] = array('column' => 'q2', 'name' => 'Q2', 'order' => true, 'width' => '80');
$col[] = array('column' => 'q3', 'name' => 'Q3', 'order' => true, 'width' => '80');
$col[] = array('column' => 'q4', 'name' => 'Q4', 'order' => true, 'width' => '80');
$col[] = array('column' => 'result', 'name' => '測字結果', 'order' => true);
$col[] = array('column' => 'is_share', 'name' => '分享', 'order' => true, 'width' => '60');

$col[] = array('column' => 'createtime', 'name' => '建立時間', 'order' => true, 'width' => '120');
$col[] = array('column' => 'updatetime', 'name' => '最後更新時間', 'order' => true, 'width' => '120', 'def_desc' => 'desc');

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

                    $tr.append('<td>' + row["q1"] + '</td>');
                    $tr.append('<td>' + row["q2"] + '</td>');
                    $tr.append('<td>' + row["q3"] + '</td>');
                    $tr.append('<td>' + row["q4"] + '</td>');
                    $tr.append('<td>' + row["result"] + '</td>');
                    $tr.append('<td>' + row["is_share"] + '</td>');

                    $tr.append('<td>' + row["createtime"] + '</td>');
                    $tr.append('<td>' + row["updatetime"] + '</td>');

                    obj.append($tr);
                }
            }
        });
        /* ## coder [listRow] <-- ## */
    });
</script>
</body>
</html>
