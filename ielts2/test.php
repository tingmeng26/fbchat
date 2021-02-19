<?php
$a = '2020-12-15 15:33:12';
$gap = strtotime($a.'+ 10 minutes')- strtotime('now');
var_dump($gap);exit;
