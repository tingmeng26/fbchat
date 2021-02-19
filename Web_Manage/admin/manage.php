<?php
include('_config.php');
$username = get('username', 1);
$manageinfo = "";
if ($username != "") {
    $db = Database::DB();
    $row = $db->query_prepare_first("select * from $table where username=:username", array(':username' => $username));
    $row['auth'] = coderAdmin::getAuthListAryByInt($row['auth']);
    //編輯時,password預設為空白
    unset($row['password']);
    $fhelp->bindData($row);

    $fhelp->setAttr('username', 'readonly', true);

    $method = 'edit';
    $active = '編輯';
    $manageinfo = '  管理者 : ' . $row['admin'] . ' | 建立時間 : ' . $row['createtime'] . ' | 上次修改時間 : ' . $row['updatetime'] . ' | 最後登入時間 : ' . $row['logintime'] . ' | 最後登入IP : ' . $row['ip'];

    $row_history = coderAdminLog::getLogByUser($row['username'], 5);
    $db->close();
} else {
    $method = 'add';
    $active = '新增';
    $fhelp->setAttr('username', 'validate', array('required' => 'yes', 'maxlength' => '20', 'minlength' => 3));
    $fhelp->setAttr('password', 'validate', array('required' => 'yes', 'maxlength' => '20', 'minlength' => 6));
    $fhelp->setAttr('repassword', 'validate', array('required' => 'yes', 'maxlength' => '20', 'minlength' => 6, 'equalto' => '#password', 'data-msg-equalto' => '請重新輸入管理員密碼'));
}

?>
<!DOCTYPE html>
<html>
<head>
    <?php include('../head.php'); ?>
</head>
<body>
<!-- BEGIN Container -->
<div class="container" id="main-container">
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
        <?php if ($manageinfo != '') { ?>
            <div class="alert alert-info">
                <button class="close" data-dismiss="alert">&times;</button>
                <strong>系統資訊 : </strong> <?php echo $manageinfo ?>
            </div>
        <?php } ?>
        <!-- BEGIN Main Content -->
        <div class="row">
            <div class="col-md-9">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="<?php echo getIconClass($method) ?>"></i> <?php echo $page_title . $active ?></h3>
                        <div class="box-tool">
                            <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                            <a data-action="close" href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>
                    <div class="box-content">
                        <form class="form-horizontal" action="save.php" id="myform" name="myform" method="post">
                            <?php echo $fhelp->drawForm('id') ?>
                            <div class="row">
                                <!--left start-->
                                <div class="col-md-12 ">
                                    <?php
                                    if (coderAdmin::isAuth('admin')) {
                                        ?>
                                        <div class="form-group">
                                            <label class="col-sm-3 col-lg-2 control-label"><?php echo $fhelp->drawLabel('ispublic') ?></label>
                                            <div class="col-sm-8 controls">
                                                <?php echo $fhelp->drawForm('ispublic') ?>
                                            </div>
                                        </div>
                                        <div id="isadmingroup" class="form-group">
                                            <label class="col-sm-3 col-lg-2 control-label"><?php echo $fhelp->drawLabel('isadmin') ?></label>
                                            <div class="col-sm-8 controls">
                                                <?php echo $fhelp->drawForm('isadmin') ?>
                                            </div>
                                        </div>
                                        <div id="authgroup" class="form-group">
                                            <label class="col-sm-3 col-lg-2 control-label"><?php echo $fhelp->drawLabel('auth') ?></label>
                                            <div class="col-sm-8  controls">
                                                <?php echo $fhelp->drawForm('auth') ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label class="col-sm-3 col-lg-2 control-label"><?php echo $fhelp->drawLabel('username') ?></label>
                                        <div class="col-sm-8  controls">
                                            <?php echo $fhelp->drawForm('username') ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 col-lg-2 control-label"><?php echo $fhelp->drawLabel('password') ?></label>
                                        <div class="col-sm-8 controls">
                                            <?php echo $fhelp->drawForm('password') ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 col-lg-2 control-label"><?php echo $fhelp->drawLabel('repassword') ?></label>
                                        <div class="col-sm-8 controls">
                                            <?php echo $fhelp->drawForm('repassword') ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 col-lg-2 control-label"><?php echo $fhelp->drawLabel('name') ?></label>
                                        <div class="col-sm-8  controls">
                                            <?php echo $fhelp->drawForm('name') ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 col-lg-2 control-label"><?php echo $fhelp->drawLabel('email') ?></label>
                                        <div class="col-sm-8  controls">
                                            <?php echo $fhelp->drawForm('email') ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 col-lg-2 control-label"><?php echo $fhelp->drawLabel('introduction') ?></label>
                                        <div class="col-sm-8  controls">
                                            <?php echo $fhelp->drawForm('introduction') ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                                            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i>完成<?php echo $active ?></button>
                                            <button type="button" class="btn" onclick="if(confirm('確定要取消<?php echo $active ?>?')){parent.closeBox();}"><i
                                                        class="icon-remove"></i>取消<?php echo $active ?></button>
                                        </div>
                                    </div>
                                </div>
                                <!--right end-->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php if (isset($row_history)) { ?>
                <div class="col-md-3">
                    <div class="box">
                        <div class="box-title">
                            <h3><i class="<?php echo getIconClass('info') ?>"></i> 操作記錄</h3>
                        </div>
                        <div class="box-content">
                            <?php
                            $len = count($row_history);
                            $note = $len < 1 ? "{$row['username']}目前沒有操作記錄。" : '以下為最近5筆操作記錄';
                            echo ' <p> ' . $note . ' <button type="button" class="btn btn-primary pull-right" onclick="openBox(\'../adminlog/index.php?username=' . $row['username'] . '\')">more</button></p><hr>';
                            for ($i = 0; $i < count($row_history); $i++) {
                                echo '<p>[' . $row_history[$i]['createtime'] . ']<br>' . $row_history[$i]['type'] . $row_history[$i]['action'] . '-' . $row_history[$i]['descript'] . '</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- END Main Content -->
        <?php include('../footer.php'); ?>
        <a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="icon-chevron-up"></i></a>
    </div>
    <!-- END Content -->
</div>
<!-- END Container -->
<?php include('../js.php'); ?>
<script type="text/javascript" src="../assets/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="../assets/jquery-validation/dist/additional-methods.js"></script>
<script type="text/javascript">
    <?php coderFormHelp::drawVaildScript();?>

    <?php if($method == 'add'){?>
    $("#username").rules("add", {
        messages: {
            remote: "此帳號己被使用,請重新輸入!",
        },
        remote: {
            url: "checkisexisit.php",
            type: "post",
            data: {
                data: function () {
                    return $('#username').val()
                },
                type: 'username',
            }
        }
    });

    $("#email").rules("add", {
        messages: {
            remote: "此E-mail己被使用,請重新輸入!",
        },
        remote: {
            url: "checkisexisit.php",
            type: "post",
            data: {
                data: function () {
                    return $('#email').val()
                },
                type: 'email',
            }
        }
    });
    <?php }?>

    var isAdmin = $('#isadmin');

    isAdmin.click(function () {
        disableAuth();
    });

    function disableAuth() {
        $('#authgroup').css('display', isAdmin.prop('checked') ? 'none' : 'block');
        $('#branch_authgroup').css('display', isAdmin.prop('checked') ? 'none' : 'block');

    }

    disableAuth();

</script>
</body>
</html>
