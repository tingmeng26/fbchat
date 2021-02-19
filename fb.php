<?php
include_once "_config.php";

//edata=407102656714712_1_fossil_0
$edata=get("edata",1);
$eary = explode('_', $edata);
$fan_page_id = isset($eary[0]) ? $eary[0] : "407102656714712"; //粉絲團ID
$result = isset($eary[1]) ? $eary[1] : 1; //測驗結果
$case = isset($eary[2]) ? $eary[2] : 1; //案子
$post_id_key = isset($eary[3]) ? $eary[3] : 0;

include_once "_parameter.php"; //活動文案的內容變數

if ($case == "fossil") {
	include_once "fossil/_parameter.php";
} else {
	include_once "ielts2/_parameter.php";
}

$pic = $results[$result]["pic"];
$fb_post_url = $ary_fb_post_url[$post_id_key] ?? '';

$title="職場叢林 生存攻略";
$descript="我的職場個性分析神準，那你呢?";
// $pic=isset($ary_showslicp_pic[$showslicptype]) ? $ary_showslicp_pic[$showslicptype] : "images_new/fb_meta.png";
// $pic=$weburl.$pic.'?date='.date('Ymds');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />

<!--facebook meta-->
<meta property="og:type" content="website"/>
<meta property="og:title" content="<?php echo $title?>"/>
<meta property="og:description" content="<?php echo $descript?>"/>
<meta property="og:url" content="<?php echo $weburl.'fb.php?edata='.$edata; ?>"/>
<meta property="og:image" content="<?php echo $pic?>"/>
<meta property="og:image:width" content="1200"/>
<meta property="og:image:height" content="628"/>


</head>

<body>

</body>
<script>
	location.href="<?php echo $fb_post_url ?>";
</script>
</html>
