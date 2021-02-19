<?php include('_config.php');
$listHelp = new coderListHelp('table1', '帳號');
$listHelp->mutileSelect = true;
$listHelp->editLink = "manage.php";
$listHelp->addLink = "manage.php";
$listHelp->ajaxSrc = "service.php";
$listHelp->delSrc = "delservice.php";

$col = array();
$col[] = array('column' => 'id', 'name' => 'ID', 'order' => true, 'width' => '60');
$col[] = array('column' => 'username', 'name' => '登入帳號', 'order' => true, 'width' => '100');
$col[] = array('column' => 'ispublic', 'name' => '啟用', 'order' => true, 'width' => '60');
$col[] = array('column' => 'auth', 'name' => '操作權限');
$col[] = array('column' => 'ip', 'name' => '登入IP', 'width' => '100');
$col[] = array('column' => 'admin', 'name' => '管理員', 'order' => true, 'width' => '100');
$col[] = array('column' => 'updatetime', 'name' => '最後更新時間', 'order' => true, 'width' => '150');
$listHelp->Bind($col);

$listHelp->bindFilter($help);

$db = Database::DB();

coderAdminLog::insert($adminuser['username'], $logkey, 'view', '列表');

$db->close();
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('../head.php'); ?>

</head>
<body>
<?php include('../navbar.php'); ?>
<!-- BEGIN Container -->
<div class="container" id="main-container">
    <?php include('../left.php'); ?>
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
        $('#table1').coderlisthelp({
            debug: true, callback: function (obj, rows) {
                obj.html('');
                var count = rows.length;
                for (var i = 0; i < count; i++) {
                    var row = rows[i];
                    var $tr = $('<tr></tr>');
                    $tr.attr("editlink", "username=" + row["username"]);
                    $tr.attr("delkey", row["id"]);
                    $tr.attr("title", row["username"]);

                    $tr.append('<td>' + row["id"] + '</td>');
                    $tr.append('<td>' + row["username"] + '</td>');
                    $tr.append('<td>' + row["ispublic"] + '</td>');
                    $tr.append('<td>' + row["auth"] + '</td>');
                    $tr.append('<td>' + row["ip"] + '</td>');
                    $tr.append('<td>' + row["admin"] + '</td>');
                    $tr.append('<td>' + row["updatetime"] + '</td>');
                    obj.append($tr);
                }
            }
        });
    });


</script>

</body>
</html>
