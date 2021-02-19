<?php
$inc_path = "../inc/";
include($inc_path . '_config.php');
//echo hash('sha512', '123456');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $webname ?>後台管理系統-Neptunus</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <!--base css styles-->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

    <!--page specific css styles-->

    <!--flaty css styles-->
    <link rel="stylesheet" href="css/flaty.css">
    <link rel="stylesheet" href="css/flaty-responsive.css">

    <link rel="shortcut icon" href="img/favicon.png">
</head>
<body class="login-page">

<!-- BEGIN Main Content -->
<div id="loginform" class="login-wrapper">

    <!-- BEGIN Login Form -->
    <form id="myform">
        <img src="images/logo.png">
        <hr/>
        <div id="alertdiv" class="alert alert-info" style="display:none">
            <strong>登入中...</strong>請稍候
        </div>
        <div id="formcontent">
            <div class="form-group">
                <div class="controls">
                    <input type="text" id="username" name="username" placeholder="請在此輸入您的帳號" class="form-control" autocomplete="off"/>
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    <input type="password" id="password" name="password" placeholder="請在此輸入您的密碼" class="form-control" autocomplete="off"/>
                </div>
            </div>
            <div class="form-group">

                <div style="float:left;width:180px;">
                    <input type="text" id="code" name="code" placeholder="右圖數字" class="form-control" autocomplete="off"/>
                </div>
                <a href="javascript:void(0)">
                    <img id="codeimg" src="showrandimg.php?time=<?php echo time() ?>" style="float:left"
                         onClick="$(this).attr('src','showrandimg.php?time='+getTimeStamp())" class="show-popover" data-trigger="hover"
                         data-placement="top" data-content="點我就可以重新取得一組新的驗證圖片!" data-original-title="看不清楚嗎?">
                </a>
                <div style="clear:both"></div>
            </div>
            <div class="form-group">
                <div class="controls">
                    <label class="checkbox"><input type="checkbox" value="1" name="remember_me" id="remember_me"> Remember me</label>
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    <button type="button" id="formbtn" class="btn btn-primary form-control">登入</button>
                </div>
            </div>
            <hr/>
            <p class="clearfix">
                <a href="#" class="goto-forgot pull-right">Forgot Password?</a>
            </p>
        </div>
    </form>
    <!-- END Login Form -->

    <!-- BEGIN Forgot Password Form -->
    <form id="forgot" style="display:none">
        <h3>Get back your password</h3>
        <hr/>
        <div id="alertdiv_email" class="alert alert-info" style="display:none">
            <strong>驗證中...</strong>請稍候
        </div>
        <div id="formforgot">
            <div class="form-group">
                <div class="controls">
                    <input type="text" id="forgotme_email" name="forgotme_email" placeholder="請在此輸入您的Email" class="form-control" autocomplete="off"/>
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    <button type="button" class="btn btn-primary form-control" id="sendauthemail">寄出驗證信</button>
                </div>
            </div>
            <hr/>
            <p class="clearfix">
                <a href="#" class="goto-login pull-left">← 回登入頁</a>
            </p>
        </div>
    </form>
    <!-- END Forgot Password Form -->


</div>
<!-- END Main Content -->

<!--basic scripts-->
<script type="text/javascript" src="assets/jquery/jquery-3.5.0.min.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/nicescroll/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="assets/jquery-cookie/jquery.cookie.js"></script>
<script type="text/javascript" src="assets/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="js/animatehelp.js"></script>
<!--page specific plugin scripts-->
<!--flaty scripts-->
<script src="js/flaty.js"></script>
<script src="js/public.js"></script>
<script language="javascript" type="text/javascript" src="js/login.js"></script>
</body>
</html>
