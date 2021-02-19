<?php
include_once "_config.php";

//edata=407102656714712_1_0
$edata=get("edata",1);
$eary = explode('_', $edata);
$fan_page_id = isset($eary[0]) ? $eary[0] : "103313764977349"; //粉絲團ID
// 結果國家
$country = isset($eary[1]) ? $eary[1] : 'UK'; //天數
$post_id_key = isset($eary[2]) ? $eary[2] : 0;

include_once "_parameter.php"; //活動文案的內容變數

$pic = $source_url . 'share/' . $country . '.jpg?v=2';
$fb_post_url = $ary_fb_post_url[$post_id_key] ?? 'https://www.facebook.com/Mark-test-103313764977349';

$title="美加英澳 何處去";
$descript="「雅師」為你指點迷津，公開分享抽限量好禮";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />

<!--facebook meta-->
<meta property="fb:app_id" content="<?php echo $fb_app_id ?>" />
<meta property="og:type" content="website"/>
<meta property="og:title" content="<?php echo $title?>"/>
<meta property="og:description" content="<?php echo $descript?>"/>
<meta property="og:url" content="<?php echo $url.'fb.php?edata='.$edata; ?>"/>
<meta property="og:image" content="<?php echo $pic?>"/>
<meta property="og:image:width" content="1200"/>
<meta property="og:image:height" content="630"/>

</head>

<body>

</body>
<script>
	location.href="<?php echo $fb_post_url ?>";
</script>
</html>
