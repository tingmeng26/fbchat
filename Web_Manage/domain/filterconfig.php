<?php
$filterhelp=new coderFilterHelp();
$obj[]=array('type'=>'keyword','name'=>'關鍵字','sql'=>true,
	'ary'=>array(
        array('column'=>"domain",'name'=>'domain'),
	)
);

$obj[]=array('type'=>'dategroup','column'=>'dategroup','sql'=>true,'ary'=>array(array('column'=>'createtime','name'=>'建立時間')));
$filterhelp->Bind($obj);