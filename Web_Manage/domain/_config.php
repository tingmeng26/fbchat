<?php
$inc_path="../../inc/";
$manage_path="../";
$authkey='domain';
$logkey='domain';
include('../_config.php');

coderAdmin::vaild($authkey);
$auth=coderAdmin::Auth($authkey);

$table=coderDBConf::$domain;

$page_title="信箱黑名單";
$page=request_pag("page");
$page_desc="{$page_title}-您可在此檢視信箱黑名單資料。";
$mtitle='<li class="active">'.$page_title.'</li>';
$mainicon=$auth["icon"];

