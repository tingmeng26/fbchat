<?php
include_once "_config.php";
// include_once "_parameter.php"; //活動文案的內容變數
$case = get("case", 1);
$post_id_key = 0;
if ($case == "fossil") {
	include_once "fossil/_parameter.php";
} else if($case == "ielts") {
	include_once "ielts/_parameter.php";
} else {
	include_once "ielts/_parameter.php";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">
<!-- <script>open(location, '_self').close();</script> -->
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<script>
	window.close();
	location.href="<?php echo $fan_page_url ?>";
</script>
<title></title>


</head>

<body>

</body>
</html>