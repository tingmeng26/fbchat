<?php
include('_config.php');
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('../head.php'); ?>
</head>
<body>
<?php include('../navbar.php'); ?>
<div class="container" id="main-container">
    <?php include('../left.php'); ?>
    <div id="main-content">
        <div class="page-title">
            <div>
                <h1><i class="icon-home"></i> 首頁資訊</h1>
                <h4><?php echo $page_desc ?></h4>
            </div>
        </div>
        <div id="breadcrumbs">
            <ul class="breadcrumb">
                <li class="active"><i class="icon-home"></i> Home</li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tile">
                                    <p class="title"><?php echo $adminuser['name'] ?> - 歡迎使用本系統</p>
                                    <p style="margin-top:10px">
                                        <img src="../upload/admin/user.png" style="float:left" width="60">
                                    <div style="float:left;margin:5px">
                                        您本次登入時間為:
                                        <?php echo $adminuser['time'] . '<br>登入IP:' . request_ip() . '<br><li class="icon-smile"> ' . coderAdmin::sayHello() . '</li>'; ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    </p>
                                    <div class="img img-bottom">
                                        <i class="icon-desktop"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
        </div>
        <?php include('../footer.php'); ?>
        <a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="icon-chevron-up"></i></a>
    </div>
</div>

<?php include('../js.php'); ?>
</body>
</html>
