<?php
$fhelp=new coderFormHelp();
$fobj=array();
$fobj["id"]=array("type"=>"hidden","name"=>"ID","column"=>"id","sql"=>false);

$fobj["domain"]=array("type"=>"text","name"=>"domain","column"=>"domain","validate"=>array('required' => 'yes'),"sql"=>true);

$fhelp->Bind($fobj);